<?php

namespace common\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\web\UploadedFile;

/**
 * Partner model
 *
 * @property int $id
 * @property string $brand_name_uz
 * @property string $brand_name_ru
 * @property string|null $logo
 * @property string|null $description_uz
 * @property string|null $description_ru
 * @property string|null $website
 * @property int $status
 * @property int $sort_order
 * @property int $created_at
 * @property int $updated_at
 */
class Partner extends \yii\db\ActiveRecord
{
    public $logoFile;

    public static function tableName()
    {
        return '{{%partners}}';
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
            [['brand_name_uz', 'brand_name_ru'], 'required'],
            [['description_uz', 'description_ru'], 'string'],
            [['status', 'sort_order'], 'integer'],
            [['brand_name_uz', 'brand_name_ru', 'website'], 'string', 'max' => 255],
            [['logo'], 'string', 'max' => 500],
            [['logoFile'], 'file', 'extensions' => 'png, jpg, jpeg, gif, webp, svg', 'skipOnEmpty' => true],
            ['status', 'in', 'range' => [0, 1]],
            ['status', 'default', 'value' => 1],
            ['sort_order', 'default', 'value' => 0],
            ['website', 'url'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'brand_name_uz' => 'Brend nomi (O\'zbekcha)',
            'brand_name_ru' => 'Brend nomi (Ruscha)',
            'logo' => 'Logo',
            'description_uz' => 'Qisqa ma\'lumot (O\'zbekcha)',
            'description_ru' => 'Qisqa ma\'lumot (Ruscha)',
            'website' => 'Veb-sayt',
            'status' => 'Status',
            'sort_order' => 'Tartiblash',
            'created_at' => 'Yaratilgan',
            'updated_at' => 'Yangilangan',
            'logoFile' => 'Logo yuklash',
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
        if ($this->logo) {
            $oldLogo = Yii::getAlias('@webroot/' . $this->logo);
            if (file_exists($oldLogo)) {
                unlink($oldLogo);
            }
        }

        $uploadPath = Yii::getAlias('@webroot/backend/web/uploads/partners/');

        if (!is_dir($uploadPath)) {
            mkdir($uploadPath, 0777, true);
        }

        $fileName = uniqid() . '_' . time() . '.' . $this->logoFile->extension;
        $filePath = $uploadPath . $fileName;

        try {
            if ($this->logoFile->saveAs($filePath)) {
                $this->logo = 'backend/web/uploads/partners/' . $fileName;
                return true;
            }
        } catch (\Exception $e) {
            Yii::error('Logo yuklashda xatolik: ' . $e->getMessage());
        }

        return false;
    }

    /**
     * Model o'chirilganda logoni ham o'chirish
     */
    public function beforeDelete()
    {
        if (parent::beforeDelete()) {
            if ($this->logo) {
                $fullPath = Yii::getAlias('@webroot/' . $this->logo);
                if (file_exists($fullPath)) {
                    unlink($fullPath);
                }
            }
            return true;
        }
        return false;
    }
}