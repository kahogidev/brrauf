<?php

namespace common\models;

use Yii;

/**
 * OrderItem model
 *
 * @property int $id
 * @property int $order_id
 * @property int $product_item_id
 * @property string $product_name
 * @property string|null $product_sku
 * @property float $price
 * @property int $quantity
 * @property float $subtotal
 *
 * @property Order $order
 * @property ProductItem $productItem
 */
class OrderItem extends \yii\db\ActiveRecord
{
    public static function tableName()
    {
        return '{{%order_items}}';
    }

    public function rules()
    {
        return [
            [['order_id', 'product_item_id', 'product_name', 'price', 'quantity', 'subtotal'], 'required'],
            [['order_id', 'product_item_id', 'quantity'], 'integer'],
            [['price', 'subtotal'], 'number'],
            [['product_name'], 'string', 'max' => 255],
            [['product_sku'], 'string', 'max' => 100],
        ];
    }

    public function attributeLabels()
    {
        $lang = Yii::$app->language;

        return [
            'id' => 'ID',
            'order_id' => $lang == 'uz' ? 'Buyurtma' : 'Заказ',
            'product_item_id' => $lang == 'uz' ? 'Mahsulot' : 'Товар',
            'product_name' => $lang == 'uz' ? 'Mahsulot nomi' : 'Название товара',
            'product_sku' => 'SKU',
            'price' => $lang == 'uz' ? 'Narxi' : 'Цена',
            'quantity' => $lang == 'uz' ? 'Miqdori' : 'Количество',
            'subtotal' => $lang == 'uz' ? 'Jami' : 'Итого',
        ];
    }

    /**
     * Order relation
     */
    public function getOrder()
    {
        return $this->hasOne(Order::class, ['id' => 'order_id']);
    }

    /**
     * Product item relation
     */
    public function getProductItem()
    {
        return $this->hasOne(ProductItem::class, ['id' => 'product_item_id']);
    }
}