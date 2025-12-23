<?php

namespace common\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\web\UploadedFile;

/**
 * Portfolio model
 *
 * @property int $id
 * @property string $company_name_uz
 * @property string $company_name_ru
 * @property string|null $company_logo
 * @property string $title_uz
 * @property string $title_ru
 * @property string|null $description_uz
 * @property string|null $description_ru
 * @property string|null $content_uz
 * @property string|null $content_ru
 * @property string|null $images
 * @property string|null $videos
 * @property string|null $project_date
 * @property int $status
 * @property int $sort_order
 * @property int $created_at
 * @property int $updated_at
 */
class Portfolio extends \yii\db\ActiveRecord
{
    public $logoFile;
    public $imageFiles;

    public static function tableName()
    {
        return '{{%portfolio}}';
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
            [['company_name_uz', 'company_name_ru', 'title_uz', 'title_ru'], 'required'],
            [['description_uz', 'description_ru', 'content_uz', 'content_ru', 'images', 'videos'], 'string'],
            [['project_date'], 'safe'],
            [['status', 'sort_order'], 'integer'],
            [['company_name_uz', 'company_name_ru', 'title_uz', 'title_ru'], 'string', 'max' => 255],
            [['company_logo'], 'string', 'max' => 500],
            [['logoFile'], 'file', 'extensions' => 'png, jpg, jpeg, gif, webp', 'skipOnEmpty' => true],
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
            'company_name_uz' => 'Kompaniya nomi (O\'zbekcha)',
            'company_name_ru' => 'Kompaniya nomi (Ruscha)',
            'company_logo' => 'Kompaniya logosi',
            'title_uz' => 'Sarlavha (O\'zbekcha)',
            'title_ru' => 'Sarlavha (Ruscha)',
            'description_uz' => 'Qisqa tavsif (O\'zbekcha)',
            'description_ru' => 'Qisqa tavsif (Ruscha)',
            'content_uz' => 'Batafsil matn (O\'zbekcha)',
            'content_ru' => 'Batafsil matn (Ruscha)',
            'images' => 'Rasmlar',
            'videos' => 'Videolar',
            'project_date' => 'Loyiha sanasi',
            'status' => 'Status',
            'sort_order' => 'Tartiblash',
            'created_at' => 'Yaratilgan',
            'updated_at' => 'Yangilangan',
        ];
    }

    /**
     * Logo yuklash
     */
    public function uploadLogo()
    {
        $this->logoFile = UploadedFile::getInstance($this, 'logoFile');

        if (!$this->logoFile) {
            return false;
        }

        // Eski logoni o'chirish
        if ($this->company_logo) {
            $oldLogo = Yii::getAlias('@webroot/' . $this->company_logo);
            if (file_exists($oldLogo)) {
                unlink($oldLogo);
            }
        }

        $uploadPath = Yii::getAlias('@webroot/backend/web/uploads/portfolio/logos/');

        if (!is_dir($uploadPath)) {
            mkdir($uploadPath, 0777, true);
        }

        $fileName = uniqid() . '_' . time() . '.' . $this->logoFile->extension;
        $filePath = $uploadPath . $fileName;

        try {
            if ($this->logoFile->saveAs($filePath)) {
                $this->company_logo = 'backend/web/uploads/portfolio/logos/' . $fileName;
                return true;
            }
        } catch (\Exception $e) {
            Yii::error('Logo yuklashda xatolik: ' . $e->getMessage());
        }

        return false;
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

        $uploadPath = Yii::getAlias('@webroot/backend/web/uploads/portfolio/images/');

        if (!is_dir($uploadPath)) {
            mkdir($uploadPath, 0777, true);
        }

        $images = $this->getImagesArray();

        foreach ($this->imageFiles as $file) {
            $fileName = uniqid() . '_' . time() . '.' . $file->extension;
            $filePath = $uploadPath . $fileName;

            try {
                if ($file->saveAs($filePath)) {
                    $images[] = 'backend/web/uploads/portfolio/images/' . $fileName;
                }
            } catch (\Exception $e) {
                Yii::error('Rasm yuklashda xatolik: ' . $e->getMessage());
            }
        }

        $this->images = json_encode($images);
        return true;
    }

    /**
     * Video linklar saqlash
     */
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
            // Logo o'chirish
            if ($this->company_logo) {
                $fullPath = Yii::getAlias('@webroot/' . $this->company_logo);
                if (file_exists($fullPath)) {
                    unlink($fullPath);
                }
            }

            // Rasmlarni o'chirish
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