<?php

namespace common\models;

use Yii;
use yii\behaviors\TimestampBehavior;

/**
 * PromotionProduct model (Pivot table)
 *
 * @property int $id
 * @property int $promotion_id
 * @property int $product_id
 * @property int $created_at
 *
 * @property Promotion $promotion
 * @property Product $product
 */
class PromotionProduct extends \yii\db\ActiveRecord
{
    public static function tableName()
    {
        return '{{%promotion_products}}';
    }

    public function behaviors()
    {
        return [
            [
                'class' => TimestampBehavior::class,
                'createdAtAttribute' => 'created_at',
                'updatedAtAttribute' => false,
            ],
        ];
    }

    public function rules()
    {
        return [
            [['promotion_id', 'product_id'], 'required'],
            [['promotion_id', 'product_id'], 'integer'],
            [['promotion_id'], 'exist', 'skipOnError' => true, 'targetClass' => Promotion::class, 'targetAttribute' => ['promotion_id' => 'id']],
            [['product_id'], 'exist', 'skipOnError' => true, 'targetClass' => Product::class, 'targetAttribute' => ['product_id' => 'id']],
            [['promotion_id', 'product_id'], 'unique', 'targetAttribute' => ['promotion_id', 'product_id']],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'promotion_id' => 'Aksiya',
            'product_id' => 'Mahsulot',
            'created_at' => 'Yaratilgan',
        ];
    }

    /**
     * Aksiya bilan bog'lanish
     */
    public function getPromotion()
    {
        return $this->hasOne(Promotion::class, ['id' => 'promotion_id']);
    }

    /**
     * Mahsulot bilan bog'lanish
     */
    public function getProduct()
    {
        return $this->hasOne(Product::class, ['id' => 'product_id']);
    }
}