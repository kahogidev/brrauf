<?php

namespace common\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\web\UploadedFile;

class Vacancy extends \yii\db\ActiveRecord
{
    public $imageFile;

    const EMPLOYMENT_FULL_TIME = 'full-time';
    const EMPLOYMENT_PART_TIME = 'part-time';
    const EMPLOYMENT_REMOTE = 'remote';

    public static function tableName()
    {
        return '{{%vacancies}}';
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
            [['title_uz', 'title_ru'], 'required'],
            [['description_uz', 'description_ru', 'requirements_uz', 'requirements_ru', 'benefits_uz', 'benefits_ru'], 'string'],
            [['salary_from', 'salary_to'], 'number', 'min' => 0],
            [['deadline'], 'safe'],
            [['status', 'sort_order'], 'integer'],
            [['title_uz', 'title_ru'], 'string', 'max' => 255],
            [['employment_type'], 'string', 'max' => 50],
            [['image'], 'string', 'max' => 500],
            // imageFile uchun validation - MUHIM: skipOnEmpty => true
            [['imageFile'], 'file',
                'extensions' => 'png, jpg, jpeg, gif, webp',
                'maxSize' => 5 * 1024 * 1024, // 5MB
                'skipOnEmpty' => true,  // Bo'sh bo'lsa o'tkazib yuborish
                'checkExtensionByMimeType' => false, // MIME type tekshirmaslik
            ],
            ['status', 'in', 'range' => [0, 1]],
            ['status', 'default', 'value' => 1],
            ['sort_order', 'default', 'value' => 0],
            ['employment_type', 'in', 'range' => [self::EMPLOYMENT_FULL_TIME, self::EMPLOYMENT_PART_TIME, self::EMPLOYMENT_REMOTE]],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title_uz' => 'Lavozim nomi (O\'zbekcha)',
            'title_ru' => 'Lavozim nomi (Ruscha)',
            'description_uz' => 'Tavsif (O\'zbekcha)',
            'description_ru' => 'Tavsif (Ruscha)',
            'requirements_uz' => 'Talablar (O\'zbekcha)',
            'requirements_ru' => 'Talablar (Ruscha)',
            'benefits_uz' => 'Imkoniyatlar (O\'zbekcha)',
            'benefits_ru' => 'Imkoniyatlar (Ruscha)',
            'image' => 'Rasm',
            'imageFile' => 'Rasm',
            'salary_from' => 'Maosh (dan)',
            'salary_to' => 'Maosh (gacha)',
            'employment_type' => 'Ish turi',
            'deadline' => 'Muddat',
            'status' => 'Status',
            'sort_order' => 'Tartiblash',
            'created_at' => 'Yaratilgan',
            'updated_at' => 'Yangilangan',
        ];
    }

    public function getApplications()
    {
        return $this->hasMany(VacancyApplication::class, ['vacancy_id' => 'id']);
    }

    public function getNewApplicationsCount()
    {
        return $this->hasMany(VacancyApplication::class, ['vacancy_id' => 'id'])
            ->where(['status' => VacancyApplication::STATUS_NEW])
            ->count();
    }

    public static function getEmploymentTypes()
    {
        return [
            self::EMPLOYMENT_FULL_TIME => 'To\'liq ish kuni',
            self::EMPLOYMENT_PART_TIME => 'Yarim ish kuni',
            self::EMPLOYMENT_REMOTE => 'Masofaviy',
        ];
    }

    public function getEmploymentTypeName()
    {
        $types = self::getEmploymentTypes();
        return isset($types[$this->employment_type]) ? $types[$this->employment_type] : '';
    }

    public function getFormattedSalary()
    {
        if ($this->salary_from && $this->salary_to) {
            return number_format($this->salary_from, 0, '.', ' ') . ' - ' . number_format($this->salary_to, 0, '.', ' ') . ' UZS';
        } elseif ($this->salary_from) {
            return 'dan ' . number_format($this->salary_from, 0, '.', ' ') . ' UZS';
        } elseif ($this->salary_to) {
            return 'gacha ' . number_format($this->salary_to, 0, '.', ' ') . ' UZS';
        }
        return 'Kelishiladi';
    }

    /**
     * Rasm yuklash
     * @return bool
     */
    public function uploadImage()
    {
        // Faylni olish
        $this->imageFile = UploadedFile::getInstance($this, 'imageFile');

        // Agar fayl yuborilmagan bo'lsa
        if (!$this->imageFile) {
            return false;
        }

        // Upload papkasini tekshirish va yaratish
        $uploadPath = Yii::getAlias('@frontend/web/uploads/vacancies/');
        if (!is_dir($uploadPath)) {
            mkdir($uploadPath, 0777, true);
        }

        // Eski rasmni o'chirish
        if ($this->image && !$this->isNewRecord) {
            $oldImage = Yii::getAlias('@frontend/web/' . $this->image);
            if (file_exists($oldImage)) {
                @unlink($oldImage);
            }
        }

        // Yangi fayl nomi
        $fileName = uniqid() . '_' . time() . '.' . $this->imageFile->extension;
        $filePath = $uploadPath . $fileName;

        // Faylni saqlash
        try {
            if ($this->imageFile->saveAs($filePath)) {
                $this->image = 'uploads/vacancies/' . $fileName;
                return true;
            }
        } catch (\Exception $e) {
            Yii::error('Rasm yuklashda xatolik: ' . $e->getMessage());
        }

        return false;
    }

    public function beforeDelete()
    {
        if (parent::beforeDelete()) {
            if ($this->image) {
                $fullPath = Yii::getAlias('@frontend/web/' . $this->image);
                if (file_exists($fullPath)) {
                    @unlink($fullPath);
                }
            }
            return true;
        }
        return false;
    }
}