<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%products}}`.
 */
class m251223_042514_create_products_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%products}}', [
            'id' => $this->primaryKey(),
            'category_id' => $this->integer()->notNull()->comment('Kategoriya ID'),
            'name_uz' => $this->string(255)->notNull()->comment('Nomi (O\'zbekcha)'),
            'name_ru' => $this->string(255)->notNull()->comment('Nomi (Ruscha)'),
            'slug' => $this->string(191)->notNull()->comment('URL slug'),
            'description_uz' => $this->text()->comment('Tavsif (O\'zbekcha)'),
            'description_ru' => $this->text()->comment('Tavsif (Ruscha)'),
            'images' => $this->text()->comment('Rasmlar (JSON format)'),
            'status' => $this->tinyInteger()->notNull()->defaultValue(1)->comment('Status (1-active, 0-inactive)'),
            'sort_order' => $this->integer()->defaultValue(0)->comment('Tartiblash'),
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),
        ]);

        // UNIQUE index alohida yaratamiz
        $this->createIndex('idx-products-slug', '{{%products}}', 'slug', true);
        $this->createIndex('idx-products-category_id', '{{%products}}', 'category_id');
        $this->createIndex('idx-products-status', '{{%products}}', 'status');
        $this->createIndex('idx-products-sort_order', '{{%products}}', 'sort_order');

        $this->addForeignKey(
            'fk-products-category_id',
            '{{%products}}',
            'category_id',
            '{{%categories}}',
            'id',
            'CASCADE',
            'CASCADE'
        );
    }

    public function safeDown()
    {
        $this->dropForeignKey('fk-products-category_id', '{{%products}}');
        $this->dropTable('{{%products}}');
    }
}
