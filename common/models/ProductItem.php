<?php

namespace common\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\web\UploadedFile;

/**
 * ProductItem model
 *
 * @property int $id
 * @property int $product_id
 * @property string $name_uz
 * @property string $name_ru
 * @property string|null $sku
 * @property float $price
 * @property string|null $description_uz
 * @property string|null $description_ru
 * @property string|null $images
 * @property int $status
 * @property int $sort_order
 * @property int $created_at
 * @property int $updated_at
 *
 * @property Product $product
 */
class ProductItem extends \yii\db\ActiveRecord
{
    public $imageFiles;

    public static function tableName()
    {
        return '{{%product_items}}';
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
            [['product_id', 'name_uz', 'name_ru', 'price'], 'required'],
            [['product_id', 'status', 'sort_order'], 'integer'],
            [['price'], 'number', 'min' => 0],
            [['description_uz', 'description_ru', 'images'], 'string'],
            [['name_uz', 'name_ru'], 'string', 'max' => 255],
            [['sku'], 'string', 'max' => 100],
            [['sku'], 'unique'],
            [['imageFiles'], 'file', 'extensions' => 'png, jpg, jpeg, gif, webp', 'maxFiles' => 10, 'skipOnEmpty' => true],
            ['status', 'in', 'range' => [0, 1]],
            ['status', 'default', 'value' => 1],
            ['sort_order', 'default', 'value' => 0],
            [['product_id'], 'exist', 'skipOnError' => true, 'targetClass' => Product::class, 'targetAttribute' => ['product_id' => 'id']],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'product_id' => 'Mahsulot',
            'name_uz' => 'Variant nomi (O\'zbekcha)',
            'name_ru' => 'Variant nomi (Ruscha)',
            'sku' => 'SKU Kodi',
            'price' => 'Narxi',
            'description_uz' => 'Tavsif (O\'zbekcha)',
            'description_ru' => 'Tavsif (Ruscha)',
            'images' => 'Rasmlar',
            'status' => 'Status',
            'sort_order' => 'Tartiblash',
            'created_at' => 'Yaratilgan',
            'updated_at' => 'Yangilangan',
            'imageFiles' => 'Rasmlar yuklash',
        ];
    }

    /**
     * Mahsulot bilan bog'lanish
     */
    public function getProduct()
    {
        return $this->hasOne(Product::class, ['id' => 'product_id']);
    }

    /**
     * Rasmlarni JSON formatdan arrayga o'girish
     */
    public function getImagesArray()
    {
        return $this->images ? json_decode($this->images, true) : [];
    }

    /**
     * Rasmlarni yuklash
     */
    public function uploadImages()
    {
        $this->imageFiles = UploadedFile::getInstances($this, 'imageFiles');

        if (!$this->imageFiles) {
            return false;
        }

        $uploadPath = Yii::getAlias('@frontend/web/uploads/product-items/');

        if (!is_dir($uploadPath)) {
            mkdir($uploadPath, 0777, true);
        }

        $images = $this->getImagesArray();

        foreach ($this->imageFiles as $file) {
            $fileName = uniqid() . '_' . time() . '.' . $file->extension;
            $filePath = $uploadPath . $fileName;

            try {
                if ($file->saveAs($filePath)) {
                    $images[] = 'uploads/product-items/' . $fileName;
                }
            } catch (\Exception $e) {
                Yii::error('Rasm yuklashda xatolik: ' . $e->getMessage());
            }
        }

        $this->images = json_encode($images);
        return true;
    }

    /**
     * Rasmni o'chirish
     */
    public function deleteImage($imagePath)
    {
        $images = $this->getImagesArray();
        $key = array_search($imagePath, $images);

        if ($key !== false) {
            unset($images[$key]);
            $this->images = json_encode(array_values($images));

            $fullPath = Yii::getAlias('@webroot/' . $imagePath);
            if (file_exists($fullPath)) {
                unlink($fullPath);
            }

            return $this->save(false);
        }

        return false;
    }

    /**
     * Narxni formatlangan ko'rinishda qaytarish
     */
    public function getFormattedPrice()
    {
        return number_format($this->price, 2, '.', ' ') . ' UZS';
    }

    /**
     * Model o'chirilganda rasmlarni ham o'chirish
     */
    public function beforeDelete()
    {
        if (parent::beforeDelete()) {
            foreach ($this->getImagesArray() as $imagePath) {
                $fullPath = Yii::getAlias('@webroot/' . $imagePath);
                if (file_exists($fullPath)) {
                    unlink($fullPath);
                }
            }
            return true;
        }
        return false;
    }
}