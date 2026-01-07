<?php

namespace common\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\web\UploadedFile;

class Manager extends \yii\db\ActiveRecord
{
    public $photoFile;

    public static function tableName()
    {
        return '{{%managers}}';
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
            [['full_name', 'position_uz', 'position_ru'], 'required'],
            [['bio_uz', 'bio_ru'], 'string'],
            [['status', 'sort_order'], 'integer'],
            [['full_name', 'position_uz', 'position_ru'], 'string', 'max' => 255],
            [['photo'], 'string', 'max' => 500],
            [['photoFile'], 'file', 'extensions' => 'png, jpg, jpeg, gif, webp', 'skipOnEmpty' => true],
            ['status', 'in', 'range' => [0, 1]],
            ['status', 'default', 'value' => 1],
            ['sort_order', 'default', 'value' => 0],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'full_name' => 'To\'liq ismi',
            'position_uz' => 'Lavozim (O\'zbekcha)',
            'position_ru' => 'Lavozim (Ruscha)',
            'bio_uz' => 'Biografiya (O\'zbekcha)',
            'bio_ru' => 'Biografiya (Ruscha)',
            'photo' => 'Rasmi',
            'status' => 'Status',
            'sort_order' => 'Tartiblash',
            'created_at' => 'Yaratilgan',
            'updated_at' => 'Yangilangan',
            'photoFile' => 'Rasm yuklash',
        ];
    }

    /**
     * Rasmni yuklash
     */
    public function uploadPhoto()
    {
        $this->photoFile = UploadedFile::getInstance($this, 'photoFile');

        if (!$this->photoFile) {
            return false;
        }

        // Eski rasmni o'chirish
        if ($this->photo) {
            $oldPhoto = Yii::getAlias('@frontend/web/' . $this->photo);
            if (file_exists($oldPhoto)) {
                unlink($oldPhoto);
            }
        }

        $uploadPath = Yii::getAlias('@frontend/web/uploads/managers/');

        if (!is_dir($uploadPath)) {
            mkdir($uploadPath, 0777, true);
        }

        $fileName = uniqid() . '_' . time() . '.' . $this->photoFile->extension;
        $filePath = $uploadPath . $fileName;

        try {
            if ($this->photoFile->saveAs($filePath)) {
                $this->photo = 'uploads/managers/' . $fileName;
                return true;
            }
        } catch (\Exception $e) {
            Yii::error('Rasm yuklashda xatolik: ' . $e->getMessage());
        }

        return false;
    }

    /**
     * Rasmni o'chirish
     */
    public function deletePhoto()
    {
        if ($this->photo) {
            $fullPath = Yii::getAlias('@frontend/web/' . $this->photo);
            if (file_exists($fullPath)) {
                unlink($fullPath);
            }
            $this->photo = null;
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
            if ($this->photo) {
                $fullPath = Yii::getAlias('@frontend/web/' . $this->photo);
                if (file_exists($fullPath)) {
                    unlink($fullPath);
                }
            }
            return true;
        }
        return false;
    }
}