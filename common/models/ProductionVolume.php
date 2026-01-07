<?php

namespace common\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\web\UploadedFile;

/**
 * ProductionVolume model
 *
 * @property int $id
 * @property string $title_uz
 * @property string $title_ru
 * @property string|null $description_uz
 * @property string|null $description_ru
 * @property float $volume
 * @property string $unit_uz
 * @property string $unit_ru
 * @property string|null $period_uz
 * @property string|null $period_ru
 * @property string|null $images
 * @property string|null $videos
 * @property int $status
 * @property int $sort_order
 * @property int $created_at
 * @property int $updated_at
 */
class ProductionVolume extends \yii\db\ActiveRecord
{
    public $imageFiles;
    public $videoLinks;

    public static function tableName()
    {
        return '{{%production_volume}}';
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
            [['title_uz', 'title_ru', 'volume', 'unit_uz', 'unit_ru'], 'required'],
            [['description_uz', 'description_ru', 'images', 'videos'], 'string'],
            [['volume'], 'number', 'min' => 0],
            [['status', 'sort_order'], 'integer'],
            [['title_uz', 'title_ru'], 'string', 'max' => 255],
            [['unit_uz', 'unit_ru'], 'string', 'max' => 50],
            [['period_uz', 'period_ru'], 'string', 'max' => 100],
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
            'description_uz' => 'Tavsif (O\'zbekcha)',
            'description_ru' => 'Tavsif (Ruscha)',
            'volume' => 'Hajm (miqdor)',
            'unit_uz' => 'O\'lchov birligi (O\'zbekcha)',
            'unit_ru' => 'O\'lchov birligi (Ruscha)',
            'period_uz' => 'Davr (O\'zbekcha)',
            'period_ru' => 'Davr (Ruscha)',
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

        // TO'G'RI YO'L - frontend/web/uploads/production/
        $uploadPath = Yii::getAlias('@frontend/web/uploads/production/');

        if (!is_dir($uploadPath)) {
            mkdir($uploadPath, 0777, true);
        }

        $images = $this->getImagesArray();

        foreach ($this->imageFiles as $file) {
            $fileName = uniqid() . '_' . time() . '.' . $file->extension;
            $filePath = $uploadPath . $fileName;

            try {
                if ($file->saveAs($filePath)) {
                    $images[] = 'uploads/production/' . $fileName;
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
    public function deleteImage($imagePath)
    {
        $images = $this->getImagesArray();
        $key = array_search($imagePath, $images);

        if ($key !== false) {
            unset($images[$key]);
            $this->images = json_encode(array_values($images));

            // Frontend dan o'chirish
            $fullPath = Yii::getAlias('@frontend/web/' . $imagePath);
            if (file_exists($fullPath)) {
                unlink($fullPath);
            }

            return $this->save(false);
        }

        return false;
    }

    /**
     * Hajmni formatlangan ko'rinishda qaytarish
     */
    public function getFormattedVolume($lang = 'uz')
    {
        $unit = $lang === 'uz' ? $this->unit_uz : $this->unit_ru;
        return number_format($this->volume, 2, '.', ' ') . ' ' . $unit;
    }
}