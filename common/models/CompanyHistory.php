<?php

namespace common\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\web\UploadedFile;

/**
 * CompanyHistory model
 *
 * @property int $id
 * @property int $year
 * @property string $title_uz
 * @property string $title_ru
 * @property string $description_uz
 * @property string $description_ru
 * @property string|null $images
 * @property string|null $videos
 * @property int $status
 * @property int $sort_order
 * @property int $created_at
 * @property int $updated_at
 */
class CompanyHistory extends \yii\db\ActiveRecord
{
    public $imageFiles;
    public $videoLinks;

    public static function tableName()
    {
        return '{{%company_history}}';
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
            [['year', 'title_uz', 'title_ru', 'description_uz', 'description_ru'], 'required'],
            [['year', 'status', 'sort_order'], 'integer'],
            [['description_uz', 'description_ru', 'images', 'videos'], 'string'],
            [['title_uz', 'title_ru'], 'string', 'max' => 255],
            // MUHIM: skipOnEmpty, checkExtensionByMimeType, maxSize
            [['imageFiles'], 'file',
                'extensions' => 'png, jpg, jpeg, gif, webp',
                'maxFiles' => 10,
                'maxSize' => 20 * 1024 * 1024, // 20MB har bir rasm
                'skipOnEmpty' => true,
                'checkExtensionByMimeType' => false,
            ],
            [['videoLinks'], 'safe'],
            ['status', 'in', 'range' => [0, 1]],
            ['status', 'default', 'value' => 1],
            ['sort_order', 'default', 'value' => 0],
            ['year', 'integer', 'min' => 1900, 'max' => 2100],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'year' => 'Yil',
            'title_uz' => 'Sarlavha (O\'zbekcha)',
            'title_ru' => 'Sarlavha (Ruscha)',
            'description_uz' => 'Tavsif (O\'zbekcha)',
            'description_ru' => 'Tavsif (Ruscha)',
            'images' => 'Rasmlar',
            'videos' => 'Videolar',
            'status' => 'Status',
            'sort_order' => 'Tartiblash',
            'created_at' => 'Yaratilgan',
            'updated_at' => 'Yangilangan',
            'imageFiles' => 'Rasmlar yuklash',
            'videoLinks' => 'Video linklar (YouTube)',
        ];
    }

    /**
     * Rasmlarni JSON formatdan arrayga o'girish
     */
    public function getImagesArray()
    {
        return $this->images ? json_decode($this->images, true) : [];
    }

    /**
     * Videolarni JSON formatdan arrayga o'girish
     */
    public function getVideosArray()
    {
        return $this->videos ? json_decode($this->videos, true) : [];
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

        $uploadPath = Yii::getAlias('@frontend/web/uploads/history/');

        if (!is_dir($uploadPath)) {
            mkdir($uploadPath, 0777, true);
        }

        $images = $this->getImagesArray();

        foreach ($this->imageFiles as $file) {
            $fileName = uniqid() . '_' . time() . '.' . $file->extension;
            $filePath = $uploadPath . $fileName;

            try {
                if ($file->saveAs($filePath)) {
                    $images[] = 'uploads/history/' . $fileName;
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

            // Faylni o'chirish
            $fullPath = Yii::getAlias('@frontend/web/' . $imagePath);
            if (file_exists($fullPath)) {
                @unlink($fullPath);
            }

            return $this->save(false);
        }

        return false;
    }

    /**
     * Video linklar saqlash
     */
    public function saveVideoLinks($links)
    {
        if (is_array($links)) {
            $videos = array_filter($links, function($link) {
                return !empty($link);
            });
            $this->videos = json_encode(array_values($videos));
            return true;
        }
        return false;
    }

    /**
     * O'chirilishdan oldin rasmlarni o'chirish
     */
    public function beforeDelete()
    {
        if (parent::beforeDelete()) {
            foreach ($this->getImagesArray() as $imagePath) {
                $fullPath = Yii::getAlias('@frontend/web/' . $imagePath);
                if (file_exists($fullPath)) {
                    @unlink($fullPath);
                }
            }
            return true;
        }
        return false;
    }
}