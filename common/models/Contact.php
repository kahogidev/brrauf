<?php

namespace common\models;

use Yii;
use yii\behaviors\TimestampBehavior;

/**
 * Contact model (Settings - faqat bitta yozuv)
 *
 * @property int $id
 * @property string $phone1
 * @property string|null $phone2
 * @property string $address1_uz
 * @property string $address1_ru
 * @property string|null $address2_uz
 * @property string|null $address2_ru
 * @property string $email
 * @property string|null $instagram
 * @property string|null $facebook
 * @property string|null $linkedin
 * @property string|null $youtube
 * @property string|null $telegram
 * @property string|null $working_hours_uz
 * @property string|null $working_hours_ru
 * @property string|null $map_latitude
 * @property string|null $map_longitude
 * @property int $updated_at
 */
class Contact extends \yii\db\ActiveRecord
{
    public static function tableName()
    {
        return '{{%contacts}}';
    }

    public function behaviors()
    {
        return [
            [
                'class' => TimestampBehavior::class,
                'createdAtAttribute' => false, // Created_at yo'q
                'updatedAtAttribute' => 'updated_at',
            ],
        ];
    }

    public function rules()
    {
        return [
            [['phone1', 'address1_uz', 'address1_ru', 'email'], 'required'],
            [['phone1', 'phone2'], 'string', 'max' => 50],
            [['address1_uz', 'address1_ru', 'address2_uz', 'address2_ru'], 'string', 'max' => 500],
            [['email'], 'string', 'max' => 100],
            [['email'], 'email'],
            [['instagram', 'facebook', 'linkedin', 'youtube', 'telegram', 'working_hours_uz', 'working_hours_ru'], 'string', 'max' => 255],
            [['map_latitude', 'map_longitude'], 'string', 'max' => 50],
            [['instagram', 'facebook', 'linkedin', 'youtube', 'telegram'], 'url'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'phone1' => 'Telefon 1',
            'phone2' => 'Telefon 2',
            'address1_uz' => 'Manzil 1 (O\'zbekcha)',
            'address1_ru' => 'Manzil 1 (Ruscha)',
            'address2_uz' => 'Manzil 2 (O\'zbekcha)',
            'address2_ru' => 'Manzil 2 (Ruscha)',
            'email' => 'Email',
            'instagram' => 'Instagram',
            'facebook' => 'Facebook',
            'linkedin' => 'LinkedIn',
            'youtube' => 'YouTube',
            'telegram' => 'Telegram',
            'working_hours_uz' => 'Ish vaqti (O\'zbekcha)',
            'working_hours_ru' => 'Ish vaqti (Ruscha)',
            'map_latitude' => 'Xarita - Latitude',
            'map_longitude' => 'Xarita - Longitude',
            'updated_at' => 'Yangilangan',
        ];
    }

    /**
     * Settings modelini olish yoki yaratish
     */
    public static function getSettings()
    {
        $contact = self::find()->one();

        if (!$contact) {
            $contact = new self();
            $contact->save(false);
        }

        return $contact;
    }
}