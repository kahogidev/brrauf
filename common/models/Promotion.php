<?php

namespace common\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\web\UploadedFile;

/**
 * Promotion model
 *
 * @property int $id
 * @property string $title_uz
 * @property string $title_ru
 * @property string|null $description_uz
 * @property string|null $description_ru
 * @property float $discount_percent
 * @property string|null $image
 * @property string $start_date
 * @property string $end_date
 * @property int $status
 * @property int $sort_order
 * @property int $created_at
 * @property int $updated_at
 *
 * @property PromotionProduct[] $promotionProducts
 * @property Product[] $products
 */
class Promotion extends \yii\db\ActiveRecord
{
    public $imageFile;
    public $product_ids = []; // Ko'p mahsulotlarni tanlash uchun

    public static function tableName()
    {
        return '{{%promotions}}';
    }

    public function behaviors()
    {
        return [
            TimestampBehavior::class,
        ];
    }

    public function rules()
    {
        return [
            [['title_uz', 'title_ru', 'discount_percent', 'start_date', 'end_date'], 'required'],
            [['description_uz', 'description_ru'], 'string'],
            [['discount_percent'], 'number', 'min' => 0, 'max' => 100],
            [['start_date', 'end_date'], 'safe'],
            [['status', 'sort_order'], 'integer'],
            [['title_uz', 'title_ru'], 'string', 'max' => 255],
            [['image'], 'string', 'max' => 500],
            [['imageFile'], 'file', 'extensions' => 'png, jpg, jpeg, gif, webp', 'skipOnEmpty' => true],
            [['product_ids'], 'safe'],
            ['status', 'in', 'range' => [0, 1]],
            ['status', 'default', 'value' => 1],
            ['sort_order', 'default', 'value' => 0],
            ['end_date', 'compare', 'compareAttribute' => 'start_date', 'operator' => '>=', 'message' => 'Tugash sanasi boshlanish sanasidan katta yoki teng bo\'lishi kerak.'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title_uz' => 'Sarlavha (O\'zbekcha)',
            'title_ru' => 'Sarlavha (Ruscha)',
            'description_uz' => 'Tavsif (O\'zbekcha)',
            'description_ru' => 'Tavsif (Ruscha)',
            'discount_percent' => 'Chegirma (%)',
            'image' => 'Rasm',
            'start_date' => 'Boshlanish sanasi',
            'end_date' => 'Tugash sanasi',
            'status' => 'Status',
            'sort_order' => 'Tartiblash',
            'created_at' => 'Yaratilgan',
            'updated_at' => 'Yangilangan',
            'product_ids' => 'Mahsulotlar',
        ];
    }

    /**
     * Promotion Products bilan bog'lanish
     */
    public function getPromotionProducts()
    {
        return $this->hasMany(PromotionProduct::class, ['promotion_id' => 'id']);
    }

    /**
     * Products bilan bog'lanish (many-to-many)
     */
    public function getProducts()
    {
        return $this->hasMany(Product::class, ['id' => 'product_id'])
            ->viaTable('{{%promotion_products}}', ['promotion_id' => 'id']);
    }

    /**
     * Mahsulotlarni saqlash
     */
    public function saveProducts($productIds)
    {
        // Eski bog'lanishlarni o'chirish
        PromotionProduct::deleteAll(['promotion_id' => $this->id]);

        // Yangi bog'lanishlarni yaratish
        if (!empty($productIds)) {
            foreach ($productIds as $productId) {
                $promotionProduct = new PromotionProduct();
                $promotionProduct->promotion_id = $this->id;
                $promotionProduct->product_id = $productId;
                $promotionProduct->save();
            }
        }
    }

    /**
     * Aksiya faolmi tekshirish
     */
    public function isActive()
    {
        if ($this->status != 1) {
            return false;
        }

        $today = date('Y-m-d');
        return $today >= $this->start_date && $today <= $this->end_date;
    }

    /**
     * Rasm yuklash
     */
    public function uploadImage()
    {
        $this->imageFile = UploadedFile::getInstance($this, 'imageFile');

        if (!$this->imageFile) {
            return false;
        }

        // Eski rasmni o'chirish
        if ($this->image) {
            $oldImage = Yii::getAlias('@webroot/' . $this->image);
            if (file_exists($oldImage)) {
                unlink($oldImage);
            }
        }

        $uploadPath = Yii::getAlias('@frontend/web/uploads/promotions/');

        if (!is_dir($uploadPath)) {
            mkdir($uploadPath, 0777, true);
        }

        $fileName = uniqid() . '_' . time() . '.' . $this->imageFile->extension;
        $filePath = $uploadPath . $fileName;

        try {
            if ($this->imageFile->saveAs($filePath)) {
                $this->image = 'uploads/promotions/' . $fileName;
                return true;
            }
        } catch (\Exception $e) {
            Yii::error('Rasm yuklashda xatolik: ' . $e->getMessage());
        }

        return false;
    }

    /**
     * Model o'chirilganda rasmni ham o'chirish
     */
    public function beforeDelete()
    {
        if (parent::beforeDelete()) {
            if ($this->image) {
                $fullPath = Yii::getAlias('@webroot/' . $this->image);
                if (file_exists($fullPath)) {
                    unlink($fullPath);
                }
            }
            return true;
        }
        return false;
    }

    /**
     * Model load qilgandan keyin mahsulot ID larini yuklash
     */
    public function afterFind()
    {
        parent::afterFind();
        $this->product_ids = \yii\helpers\ArrayHelper::getColumn($this->promotionProducts, 'product_id');
    }
}