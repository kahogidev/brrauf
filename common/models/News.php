<?php

namespace common\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\behaviors\SluggableBehavior;
use yii\web\UploadedFile;

class News extends \yii\db\ActiveRecord
{
    public $imageFiles;

    public static function tableName()
    {
        return '{{%news}}';
    }

    public function behaviors()
    {
        return [
            TimestampBehavior::class,
            [
                'class' => SluggableBehavior::class,
                'attribute' => 'title_uz',
                'slugAttribute' => 'slug',
                'ensureUnique' => true,
            ],
        ];
    }

    public function rules()
    {
        return [
            [['title_uz', 'title_ru'], 'required'],
            [['description_uz', 'description_ru', 'content_uz', 'content_ru', 'images', 'videos'], 'string'],
            [['published_date'], 'safe'],
            [['status', 'sort_order'], 'integer'],
            [['title_uz', 'title_ru'], 'string', 'max' => 255],
            [['slug'], 'string', 'max' => 191],
            [['slug'], 'unique'],
            [['imageFiles'], 'file', 'extensions' => 'png, jpg, jpeg, gif, webp', 'maxFiles' => 10, 'skipOnEmpty' => true],
            ['status', 'in', 'range' => [0, 1]],
            ['status', 'default', 'value' => 1],
            ['sort_order', 'default', 'value' => 0],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title_uz' => 'Sarlavha (O\'zbekcha)',
            'title_ru' => 'Sarlavha (Ruscha)',
            'slug' => 'Slug',
            'description_uz' => 'Qisqa tavsif (O\'zbekcha)',
            'description_ru' => 'Qisqa tavsif (Ruscha)',
            'content_uz' => 'To\'liq matn (O\'zbekcha)',
            'content_ru' => 'To\'liq matn (Ruscha)',
            'images' => 'Rasmlar',
            'videos' => 'Videolar',
            'published_date' => 'E\'lon sanasi',
            'status' => 'Status',
            'sort_order' => 'Tartiblash',
            'created_at' => 'Yaratilgan',
            'updated_at' => 'Yangilangan',
        ];
    }

    public function getImagesArray()
    {
        return $this->images ? json_decode($this->images, true) : [];
    }

    public function getVideosArray()
    {
        return $this->videos ? json_decode($this->videos, true) : [];
    }

    /**
     * Rasmlarni yuklash - TO'G'RILANDI
     */
    public function uploadImages()
    {
        $this->imageFiles = UploadedFile::getInstances($this, 'imageFiles');

        if (!$this->imageFiles) {
            return false;
        }

        $uploadPath = Yii::getAlias('@frontend/web/uploads/news/');

        if (!is_dir($uploadPath)) {
            mkdir($uploadPath, 0777, true);
        }

        $images = $this->getImagesArray();

        foreach ($this->imageFiles as $file) {
            $fileName = uniqid() . '_' . time() . '.' . $file->extension;
            $filePath = $uploadPath . $fileName;

            try {
                if ($file->saveAs($filePath)) {
                    $images[] = 'uploads/news/' . $fileName; // TO'G'RILANDI
                }
            } catch (\Exception $e) {
                Yii::error('Rasm yuklashda xatolik: ' . $e->getMessage());
            }
        }

        $this->images = json_encode($images);
        return true;
    }

    /**
     * Rasmni o'chirish - TO'G'RILANDI
     */
    public function deleteImage($imagePath)
    {
        $images = $this->getImagesArray();
        $key = array_search($imagePath, $images);

        if ($key !== false) {
            unset($images[$key]);
            $this->images = json_encode(array_values($images));

            $fullPath = Yii::getAlias('@frontend/web/' . $imagePath); // TO'G'RILANDI
            if (file_exists($fullPath)) {
                unlink($fullPath);
            }

            return $this->save(false);
        }

        return false;
    }

    public function saveVideoLinks($videoLinks)
    {
        if (!empty($videoLinks)) {
            $videos = array_filter($videoLinks, function($link) {
                return !empty(trim($link));
            });
            $this->videos = json_encode(array_values($videos));
        } else {
            $this->videos = null;
        }
    }

    public function beforeDelete()
    {
        if (parent::beforeDelete()) {
            foreach ($this->getImagesArray() as $imagePath) {
                $fullPath = Yii::getAlias('@frontend/web/' . $imagePath);
                if (file_exists($fullPath)) {
                    unlink($fullPath);
                }
            }
            return true;
        }
        return false;
    }
}