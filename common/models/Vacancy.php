<?php

namespace common\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\web\UploadedFile;

/**
 * Vacancy model
 *
 * @property int $id
 * @property string $title_uz
 * @property string $title_ru
 * @property string|null $description_uz
 * @property string|null $description_ru
 * @property string|null $requirements_uz
 * @property string|null $requirements_ru
 * @property string|null $benefits_uz
 * @property string|null $benefits_ru
 * @property string|null $image
 * @property float|null $salary_from
 * @property float|null $salary_to
 * @property string|null $employment_type
 * @property string|null $deadline
 * @property int $status
 * @property int $sort_order
 * @property int $created_at
 * @property int $updated_at
 *
 * @property VacancyApplication[] $applications
 */
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
            [['imageFile'], 'file', 'extensions' => 'png, jpg, jpeg, gif, webp', 'skipOnEmpty' => true],
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

    /**
     * Arizalar bilan bog'lanish
     */
    public function getApplications()
    {
        return $this->hasMany(VacancyApplication::class, ['vacancy_id' => 'id']);
    }

    /**
     * Yangi arizalar soni
     */
    public function getNewApplicationsCount()
    {
        return $this->hasMany(VacancyApplication::class, ['vacancy_id' => 'id'])
            ->where(['status' => VacancyApplication::STATUS_NEW])
            ->count();
    }

    /**
     * Ish turlari ro'yxati
     */
    public static function getEmploymentTypes()
    {
        return [
            self::EMPLOYMENT_FULL_TIME => 'To\'liq ish kuni',
            self::EMPLOYMENT_PART_TIME => 'Yarim ish kuni',
            self::EMPLOYMENT_REMOTE => 'Masofaviy',
        ];
    }

    /**
     * Ish turi nomini olish
     */
    public function getEmploymentTypeName()
    {
        $types = self::getEmploymentTypes();
        return isset($types[$this->employment_type]) ? $types[$this->employment_type] : '';
    }

    /**
     * Maosh oralig'ini formatlash
     */
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
     */
    public function uploadImage()
    {
        $this->imageFile = UploadedFile::getInstance($this, 'imageFile');

        if (!$this->imageFile) {
            return false;
        }

        // Eski rasmni o'chirish
        if ($this->image) {
            $oldImage = Yii::getAlias('@webroot/' . $this->image);
            if (file_exists($oldImage)) {
                unlink($oldImage);
            }
        }

        $uploadPath = Yii::getAlias('@webroot/backend/web/uploads/vacancies/');

        if (!is_dir($uploadPath)) {
            mkdir($uploadPath, 0777, true);
        }

        $fileName = uniqid() . '_' . time() . '.' . $this->imageFile->extension;
        $filePath = $uploadPath . $fileName;

        try {
            if ($this->imageFile->saveAs($filePath)) {
                $this->image = 'backend/web/uploads/vacancies/' . $fileName;
                return true;
            }
        } catch (\Exception $e) {
            Yii::error('Rasm yuklashda xatolik: ' . $e->getMessage());
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