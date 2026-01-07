<?php

namespace common\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\behaviors\SluggableBehavior;
use yii\web\UploadedFile;

/**
 * Product model
 *
 * @property int $id
 * @property int $category_id
 * @property string $name_uz
 * @property string $name_ru
 * @property string $slug
 * @property string|null $description_uz
 * @property string|null $description_ru
 * @property string|null $images
 * @property int $status
 * @property int $sort_order
 * @property int $created_at
 * @property int $updated_at
 *
 * @property Category $category
 * @property ProductItem[] $productItems
 */
class Product extends \yii\db\ActiveRecord
{
    public $imageFiles;

    public static function tableName()
    {
        return '{{%products}}';
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
            [['category_id', 'name_uz', 'name_ru'], 'required'],
            [['category_id', 'status', 'sort_order'], 'integer'],
            [['description_uz', 'description_ru', 'images'], 'string'],
            [['name_uz', 'name_ru'], 'string', 'max' => 255],
            [['slug'], 'string', 'max' => 191],
            [['slug'], 'unique'],
            [['imageFiles'], 'file', 'extensions' => 'png, jpg, jpeg, gif, webp', 'maxFiles' => 10, 'skipOnEmpty' => true],
            ['status', 'in', 'range' => [0, 1]],
            ['status', 'default', 'value' => 1],
            ['sort_order', 'default', 'value' => 0],
            [['category_id'], 'exist', 'skipOnError' => true, 'targetClass' => Category::class, 'targetAttribute' => ['category_id' => 'id']],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'category_id' => 'Kategoriya',
            'name_uz' => 'Nomi (O\'zbekcha)',
            'name_ru' => 'Nomi (Ruscha)',
            'slug' => 'Slug',
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
     * Kategoriya bilan bog'lanish
     */
    public function getCategory()
    {
        return $this->hasOne(Category::class, ['id' => 'category_id']);
    }

    /**
     * Mahsulot elementlari bilan bog'lanish
     */
    public function getProductItems()
    {
        return $this->hasMany(ProductItem::class, ['product_id' => 'id']);
    }

    /**
     * Faol mahsulot elementlari
     */
    public function getActiveProductItems()
    {
        return $this->hasMany(ProductItem::class, ['product_id' => 'id'])
            ->where(['status' => 1])
            ->orderBy(['sort_order' => SORT_ASC]);
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

        $uploadPath = Yii::getAlias('@frontend/web/uploads/products/');

        if (!is_dir($uploadPath)) {
            mkdir($uploadPath, 0777, true);
        }

        $images = $this->getImagesArray();

        foreach ($this->imageFiles as $file) {
            $fileName = uniqid() . '_' . time() . '.' . $file->extension;
            $filePath = $uploadPath . $fileName;

            try {
                if ($file->saveAs($filePath)) {
                    $images[] = 'uploads/products/' . $fileName;
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