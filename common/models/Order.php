<?php

namespace common\models;

use Yii;
use yii\behaviors\TimestampBehavior;

/**
 * Order model
 *
 * @property int $id
 * @property string $order_number
 * @property string $customer_name
 * @property string $customer_phone
 * @property string $customer_city
 * @property string|null $customer_address
 * @property float $total_amount
 * @property string $status
 * @property string|null $notes
 * @property string|null $admin_notes
 * @property int $created_at
 * @property int $updated_at
 *
 * @property OrderItem[] $orderItems
 */
class Order extends \yii\db\ActiveRecord
{
    const STATUS_NEW = 'new';
    const STATUS_CONFIRMED = 'confirmed';
    const STATUS_PROCESSING = 'processing';
    const STATUS_DELIVERED = 'delivered';
    const STATUS_CANCELLED = 'cancelled';

    public static function tableName()
    {
        return '{{%orders}}';
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
            [['customer_name', 'customer_phone', 'customer_city', 'total_amount'], 'required'],
            [['total_amount'], 'number'],
            [['notes', 'admin_notes', 'customer_address'], 'string'],
            [['created_at', 'updated_at'], 'integer'],
            [['order_number', 'status'], 'string', 'max' => 50],
            [['customer_name', 'customer_city'], 'string', 'max' => 255],
            [['customer_phone'], 'string', 'max' => 50],
            ['status', 'in', 'range' => [
                self::STATUS_NEW,
                self::STATUS_CONFIRMED,
                self::STATUS_PROCESSING,
                self::STATUS_DELIVERED,
                self::STATUS_CANCELLED
            ]],
            ['status', 'default', 'value' => self::STATUS_NEW],
        ];
    }

    public function attributeLabels()
    {
        $lang = Yii::$app->language;

        return [
            'id' => 'ID',
            'order_number' => $lang == 'uz' ? 'Buyurtma raqami' : 'Номер заказа',
            'customer_name' => $lang == 'uz' ? 'Mijoz ismi' : 'Имя клиента',
            'customer_phone' => $lang == 'uz' ? 'Telefon' : 'Телефон',
            'customer_city' => $lang == 'uz' ? 'Shahar' : 'Город',
            'customer_address' => $lang == 'uz' ? 'Manzil' : 'Адрес',
            'total_amount' => $lang == 'uz' ? 'Jami summa' : 'Общая сумма',
            'status' => $lang == 'uz' ? 'Status' : 'Статус',
            'notes' => $lang == 'uz' ? 'Izoh' : 'Примечание',
            'admin_notes' => $lang == 'uz' ? 'Admin izohi' : 'Заметка админа',
            'created_at' => $lang == 'uz' ? 'Yaratilgan' : 'Создано',
            'updated_at' => $lang == 'uz' ? 'Yangilangan' : 'Обновлено',
        ];
    }

    /**
     * Order items
     */
    public function getOrderItems()
    {
        return $this->hasMany(OrderItem::class, ['order_id' => 'id']);
    }

    /**
     * Generate unique order number
     */
    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {
            if ($insert && empty($this->order_number)) {
                $this->order_number = $this->generateOrderNumber();
            }
            return true;
        }
        return false;
    }

    /**
     * Generate order number
     */
    private function generateOrderNumber()
    {
        return 'ORD-' . date('Ymd') . '-' . str_pad(rand(1, 9999), 4, '0', STR_PAD_LEFT);
    }

    /**
     * Get status list
     */
    public static function getStatuses()
    {
        $lang = Yii::$app->language;

        return [
            self::STATUS_NEW => $lang == 'uz' ? 'Yangi' : 'Новый',
            self::STATUS_CONFIRMED => $lang == 'uz' ? 'Tasdiqlangan' : 'Подтвержден',
            self::STATUS_PROCESSING => $lang == 'uz' ? 'Jarayonda' : 'В обработке',
            self::STATUS_DELIVERED => $lang == 'uz' ? 'Yetkazildi' : 'Доставлен',
            self::STATUS_CANCELLED => $lang == 'uz' ? 'Bekor qilindi' : 'Отменен',
        ];
    }

    /**
     * Get status name
     */
    public function getStatusName()
    {
        $statuses = self::getStatuses();
        return $statuses[$this->status] ?? $this->status;
    }

    /**
     * Get status badge class
     */
    public function getStatusBadgeClass()
    {
        switch ($this->status) {
            case self::STATUS_NEW:
                return 'badge-outline-primary';
            case self::STATUS_CONFIRMED:
                return 'badge-outline-info';
            case self::STATUS_PROCESSING:
                return 'badge-outline-warning';
            case self::STATUS_DELIVERED:
                return 'badge-outline-success';
            case self::STATUS_CANCELLED:
                return 'badge-outline-danger';
            default:
                return 'badge-outline-secondary';
        }
    }
}