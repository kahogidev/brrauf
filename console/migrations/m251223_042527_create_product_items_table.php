<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%product_items}}`.
 */
class m251223_042527_create_product_items_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%product_items}}', [
            'id' => $this->primaryKey(),
            'product_id' => $this->integer()->notNull()->comment('Mahsulot ID'),
            'name_uz' => $this->string(255)->notNull()->comment('Variant nomi (O\'zbekcha)'),
            'name_ru' => $this->string(255)->notNull()->comment('Variant nomi (Ruscha)'),
            'sku' => $this->string(100)->comment('SKU kodi'),
            'price' => $this->decimal(15, 2)->notNull()->comment('Narxi'),
            'description_uz' => $this->text()->comment('Tavsif (O\'zbekcha)'),
            'description_ru' => $this->text()->comment('Tavsif (Ruscha)'),
            'images' => $this->text()->comment('Rasmlar (JSON format)'),
            'status' => $this->tinyInteger()->notNull()->defaultValue(1)->comment('Status (1-active, 0-inactive)'),
            'sort_order' => $this->integer()->defaultValue(0)->comment('Tartiblash'),
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),
        ]);

        $this->createIndex('idx-product_items-product_id', '{{%product_items}}', 'product_id');
        $this->createIndex('idx-product_items-status', '{{%product_items}}', 'status');
        $this->createIndex('idx-product_items-sort_order', '{{%product_items}}', 'sort_order');
        $this->createIndex('idx-product_items-sku', '{{%product_items}}', 'sku');

        $this->addForeignKey(
            'fk-product_items-product_id',
            '{{%product_items}}',
            'product_id',
            '{{%products}}',
            'id',
            'CASCADE',
            'CASCADE'
        );
    }

    public function safeDown()
    {
        $this->dropForeignKey('fk-product_items-product_id', '{{%product_items}}');
        $this->dropTable('{{%product_items}}');
    }
}
