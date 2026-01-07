<?php

namespace common\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\behaviors\SluggableBehavior;
use yii\web\UploadedFile;

/**
 * Category model
 *
 * @property int $id
 * @property string $name_uz
 * @property string $name_ru
 * @property string $slug
 * @property string|null $description_uz
 * @property string|null $description_ru
 * @property string|null $image
 * @property int $status
 * @property int $sort_order
 * @property int $created_at
 * @property int $updated_at
 *
 * @property Product[] $products
 */
class Category extends \yii\db\ActiveRecord
{
    public $imageFile;

    public static function tableName()
    {
        return '{{%categories}}';
    }

    public function behaviors()
    {
        return [
            TimestampBehavior::class,
            [
                'class' => SluggableBehavior::class,
                'attribute' => 'name_uz',
                'slugAttribute' => 'slug',
                'ensureUnique' => true,
            ],
        ];
    }

    public function rules()
    {
        return [
            [['name_uz', 'name_ru'], 'required'],
            [['description_uz', 'description_ru'], 'string'],
            [['status', 'sort_order'], 'integer'],
            [['name_uz', 'name_ru'], 'string', 'max' => 255],
            [['slug'], 'string', 'max' => 191],
            [['image'], 'string', 'max' => 500],
            [['slug'], 'unique'],
            [['imageFile'], 'file', 'extensions' => 'png, jpg, jpeg, gif, webp', 'skipOnEmpty' => true],
            ['status', 'in', 'range' => [0, 1]],
            ['status', 'default', 'value' => 1],
            ['sort_order', 'default', 'value' => 0],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name_uz' => 'Nomi (O\'zbekcha)',
            'name_ru' => 'Nomi (Ruscha)',
            'slug' => 'Slug',
            'description_uz' => 'Tavsif (O\'zbekcha)',
            'description_ru' => 'Tavsif (Ruscha)',
            'image' => 'Rasm',
            'status' => 'Status',
            'sort_order' => 'Tartiblash',
            'created_at' => 'Yaratilgan',
            'updated_at' => 'Yangilangan',
            'imageFile' => 'Rasm yuklash',
        ];
    }

    /**
     * Mahsulotlar bilan bog'lanish
     */
    public function getProducts()
    {
        return $this->hasMany(Product::class, ['category_id' => 'id']);
    }

    /**
     * Faol mahsulotlar
     */
    public function getActiveProducts()
    {
        return $this->hasMany(Product::class, ['category_id' => 'id'])
            ->where(['status' => 1])
            ->orderBy(['sort_order' => SORT_ASC]);
    }

    /**
     * Rasmni yuklash
     */
    public function uploadImages()
    {
        $this->imageFiles = UploadedFile::getInstances($this, 'imageFiles');

        if (!$this->imageFiles) {
            return false;
        }

        // To'g'ri absolut yo'l
        $uploadPath = Yii::getAlias('@feontend/web/uploads/category/');

        if (!is_dir($uploadPath)) {
            mkdir($uploadPath, 0777, true);
        }

        $images = $this->getImagesArray();

        foreach ($this->imageFiles as $file) {
            $fileName = uniqid() . '_' . time() . '.' . $file->extension;
            $filePath = $uploadPath . $fileName;

            try {
                if ($file->saveAs($filePath)) {
                    // Faqat nisbiy yo'lni saqlash (backend/web ni olib tashlash)
                    $images[] = 'uploads/category/' . $fileName;
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

            // To'g'ri yo'l bilan o'chirish
            $fullPath = Yii::getAlias('@backend/web/' . $imagePath);
            if (file_exists($fullPath)) {
                unlink($fullPath);
            }

            return $this->save(false);
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
}