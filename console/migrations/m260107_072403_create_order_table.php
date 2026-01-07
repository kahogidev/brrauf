<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%order}}`.
 */
class m260107_072403_create_order_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        // Orders jadvali
        $this->createTable('{{%orders}}', [
            'id' => $this->primaryKey(),
            'order_number' => $this->string(50)->notNull()->unique()->comment('Buyurtma raqami'),
            'customer_name' => $this->string(255)->notNull()->comment('Mijoz ismi'),
            'customer_phone' => $this->string(50)->notNull()->comment('Telefon raqami'),
            'customer_city' => $this->string(255)->notNull()->comment('Shahar'),
            'customer_address' => $this->text()->comment('Manzil (ixtiyoriy)'),
            'total_amount' => $this->decimal(10, 2)->notNull()->comment('Jami summa'),
            'status' => $this->string(50)->notNull()->defaultValue('new')->comment('Status'),
            'notes' => $this->text()->comment('Qo\'shimcha izoh'),
            'admin_notes' => $this->text()->comment('Admin izohlari'),
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),
        ], 'ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci');

        // Order items jadvali
        $this->createTable('{{%order_items}}', [
            'id' => $this->primaryKey(),
            'order_id' => $this->integer()->notNull()->comment('Buyurtma ID'),
            'product_item_id' => $this->integer()->notNull()->comment('Mahsulot ID'),
            'product_name' => $this->string(255)->notNull()->comment('Mahsulot nomi'),
            'product_sku' => $this->string(100)->comment('SKU'),
            'price' => $this->decimal(10, 2)->notNull()->comment('Narxi'),
            'quantity' => $this->integer()->notNull()->comment('Miqdori'),
            'subtotal' => $this->decimal(10, 2)->notNull()->comment('Jami'),
        ], 'ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci');

        // Indekslar
        $this->createIndex('idx-orders-order_number', '{{%orders}}', 'order_number');
        $this->createIndex('idx-orders-status', '{{%orders}}', 'status');
        $this->createIndex('idx-orders-created_at', '{{%orders}}', 'created_at');
        $this->createIndex('idx-order_items-order_id', '{{%order_items}}', 'order_id');
        $this->createIndex('idx-order_items-product_item_id', '{{%order_items}}', 'product_item_id');

        // Foreign keys
        $this->addForeignKey(
            'fk-order_items-order_id',
            '{{%order_items}}',
            'order_id',
            '{{%orders}}',
            'id',
            'CASCADE',
            'CASCADE'
        );

        $this->addForeignKey(
            'fk-order_items-product_item_id',
            '{{%order_items}}',
            'product_item_id',
            '{{%product_items}}',
            'id',
            'CASCADE',
            'CASCADE'
        );
    }

    public function safeDown()
    {
        $this->dropForeignKey('fk-order_items-product_item_id', '{{%order_items}}');
        $this->dropForeignKey('fk-order_items-order_id', '{{%order_items}}');
        $this->dropTable('{{%order_items}}');
        $this->dropTable('{{%orders}}');
    }
}
