<?php

namespace common\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\web\UploadedFile;

/**
 * VacancyApplication model
 *
 * @property int $id
 * @property int $vacancy_id
 * @property string $full_name
 * @property string $email
 * @property string $phone
 * @property string|null $birth_date
 * @property string|null $education
 * @property string|null $experience
 * @property string|null $cover_letter
 * @property string|null $resume_file
 * @property string $status
 * @property string|null $admin_notes
 * @property int $created_at
 * @property int $updated_at
 *
 * @property Vacancy $vacancy
 */
class VacancyApplication extends \yii\db\ActiveRecord
{
    public $resumeFile;

    const STATUS_NEW = 'new';
    const STATUS_VIEWED = 'viewed';
    const STATUS_ACCEPTED = 'accepted';
    const STATUS_REJECTED = 'rejected';

    public static function tableName()
    {
        return '{{%vacancy_applications}}';
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
            [['vacancy_id', 'full_name', 'email', 'phone'], 'required'],
            [['vacancy_id'], 'integer'],
            [['birth_date'], 'safe'],
            [['experience', 'cover_letter', 'admin_notes'], 'string'],
            [['full_name', 'education'], 'string', 'max' => 255],
            [['email'], 'string', 'max' => 100],
            [['email'], 'email'],
            [['phone'], 'string', 'max' => 50],
            [['resume_file'], 'string', 'max' => 500],
            [['status'], 'string', 'max' => 50],
            [['resumeFile'], 'file', 'extensions' => 'pdf, doc, docx', 'maxSize' => 5 * 1024 * 1024, 'skipOnEmpty' => true],
            ['status', 'in', 'range' => [self::STATUS_NEW, self::STATUS_VIEWED, self::STATUS_ACCEPTED, self::STATUS_REJECTED]],
            ['status', 'default', 'value' => self::STATUS_NEW],
            [['vacancy_id'], 'exist', 'skipOnError' => true, 'targetClass' => Vacancy::class, 'targetAttribute' => ['vacancy_id' => 'id']],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'vacancy_id' => 'Vakansiya',
            'full_name' => 'To\'liq ism',
            'email' => 'Email',
            'phone' => 'Telefon',
            'birth_date' => 'Tug\'ilgan sana',
            'education' => 'Ma\'lumot',
            'experience' => 'Ish tajribasi',
            'cover_letter' => 'Qo\'shimcha ma\'lumot',
            'resume_file' => 'Resume (CV)',
            'status' => 'Status',
            'admin_notes' => 'Admin izohlar',
            'created_at' => 'Yuborilgan',
            'updated_at' => 'Yangilangan',
        ];
    }

    /**
     * Vakansiya bilan bog'lanish
     */
    public function getVacancy()
    {
        return $this->hasOne(Vacancy::class, ['id' => 'vacancy_id']);
    }

    /**
     * Statuslar ro'yxati
     */
    public static function getStatuses()
    {
        return [
            self::STATUS_NEW => 'Yangi',
            self::STATUS_VIEWED => 'Ko\'rilgan',
            self::STATUS_ACCEPTED => 'Qabul qilingan',
            self::STATUS_REJECTED => 'Rad etilgan',
        ];
    }

    /**
     * Status nomini olish
     */
    public function getStatusName()
    {
        $statuses = self::getStatuses();
        return isset($statuses[$this->status]) ? $statuses[$this->status] : '';
    }

    /**
     * Status badge classi
     */
    public function getStatusBadgeClass()
    {
        switch ($this->status) {
            case self::STATUS_NEW:
                return 'badge-outline-primary';
            case self::STATUS_VIEWED:
                return 'badge-outline-info';
            case self::STATUS_ACCEPTED:
                return 'badge-outline-success';
            case self::STATUS_REJECTED:
                return 'badge-outline-danger';
            default:
                return 'badge-outline-secondary';
        }
    }

    /**
     * Resume yuklash
     */
    public function uploadResume()
    {
        $this->resumeFile = UploadedFile::getInstance($this, 'resumeFile');

        if (!$this->resumeFile) {
            return false;
        }

        // Eski faylni o'chirish
        if ($this->resume_file) {
            $oldFile = Yii::getAlias('@webroot/' . $this->resume_file);
            if (file_exists($oldFile)) {
                unlink($oldFile);
            }
        }

        $uploadPath = Yii::getAlias('@webroot/backend/web/uploads/resumes/');

        if (!is_dir($uploadPath)) {
            mkdir($uploadPath, 0777, true);
        }

        $fileName = uniqid() . '_' . time() . '.' . $this->resumeFile->extension;
        $filePath = $uploadPath . $fileName;

        try {
            if ($this->resumeFile->saveAs($filePath)) {
                $this->resume_file = 'backend/web/uploads/resumes/' . $fileName;
                return true;
            }
        } catch (\Exception $e) {
            Yii::error('Resume yuklashda xatolik: ' . $e->getMessage());
        }

        return false;
    }

    /**
     * Model o'chirilganda faylni ham o'chirish
     */
    public function beforeDelete()
    {
        if (parent::beforeDelete()) {
            if ($this->resume_file) {
                $fullPath = Yii::getAlias('@webroot/' . $this->resume_file);
                if (file_exists($fullPath)) {
                    unlink($fullPath);
                }
            }
            return true;
        }
        return false;
    }
}