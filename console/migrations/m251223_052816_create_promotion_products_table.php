<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%promotion_products}}`.
 */
class m251223_052816_create_promotion_products_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%promotion_products}}', [
            'id' => $this->primaryKey(),
            'promotion_id' => $this->integer()->notNull()->comment('Aksiya ID'),
            'product_id' => $this->integer()->notNull()->comment('Mahsulot ID'),
            'created_at' => $this->integer()->notNull(),
        ]);

        $this->createIndex('idx-promotion_products-promotion_id', '{{%promotion_products}}', 'promotion_id');
        $this->createIndex('idx-promotion_products-product_id', '{{%promotion_products}}', 'product_id');
        $this->createIndex('idx-promotion_products-unique', '{{%promotion_products}}', ['promotion_id', 'product_id'], true);

        $this->addForeignKey(
            'fk-promotion_products-promotion_id',
            '{{%promotion_products}}',
            'promotion_id',
            '{{%promotions}}',
            'id',
            'CASCADE',
            'CASCADE'
        );

        $this->addForeignKey(
            'fk-promotion_products-product_id',
            '{{%promotion_products}}',
            'product_id',
            '{{%products}}',
            'id',
            'CASCADE',
            'CASCADE'
        );
    }

    public function safeDown()
    {
        $this->dropForeignKey('fk-promotion_products-promotion_id', '{{%promotion_products}}');
        $this->dropForeignKey('fk-promotion_products-product_id', '{{%promotion_products}}');
        $this->dropTable('{{%promotion_products}}');
    }
}
