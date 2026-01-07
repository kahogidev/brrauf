<?php

namespace common\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\web\UploadedFile;

/**
 * AboutCompany model
 *
 * @property int $id
 * @property string $title_uz
 * @property string $title_ru
 * @property string|null $description_uz
 * @property string|null $description_ru
 * @property string $content_uz
 * @property string $content_ru
 * @property string|null $images
 * @property string|null $videos
 * @property int $status
 * @property int $sort_order
 * @property int $created_at
 * @property int $updated_at
 */
class AboutCompany extends \yii\db\ActiveRecord
{
    public $imageFiles;
    public $videoLinks;

    public static function tableName()
    {
        return '{{%about_company}}';
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
            [['title_uz', 'title_ru', 'content_uz', 'content_ru'], 'required'],
            [['description_uz', 'description_ru', 'content_uz', 'content_ru', 'images', 'videos'], 'string'],
            [['status', 'sort_order'], 'integer'],
            [['title_uz', 'title_ru'], 'string', 'max' => 255],
            [['imageFiles'], 'file', 'extensions' => 'png, jpg, jpeg, gif, webp', 'maxFiles' => 10, 'skipOnEmpty' => true],
            [['videoLinks'], 'safe'],
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
            'description_uz' => 'Qisqacha tavsif (O\'zbekcha)',
            'description_ru' => 'Qisqacha tavsif (Ruscha)',
            'content_uz' => 'Kontent (O\'zbekcha)',
            'content_ru' => 'Kontent (Ruscha)',
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

        // To'g'ri absolut yo'l
        $uploadPath = Yii::getAlias('@frontend/web/uploads/about/');

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
                    $images[] = 'uploads/about/' . $fileName;
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
            $fullPath = Yii::getAlias('@frontend/web/' . $imagePath);
            if (file_exists($fullPath)) {
                unlink($fullPath);
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
     * Rasmni o'chirish
     */

}