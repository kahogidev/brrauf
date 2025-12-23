<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%categories}}`.
 */
class m251223_042457_create_categories_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%categories}}', [
            'id' => $this->primaryKey(),
            'name_uz' => $this->string(255)->notNull()->comment('Nomi (O\'zbekcha)'),
            'name_ru' => $this->string(255)->notNull()->comment('Nomi (Ruscha)'),
            'slug' => $this->string(191)->notNull()->comment('URL slug'),
            'description_uz' => $this->text()->comment('Tavsif (O\'zbekcha)'),
            'description_ru' => $this->text()->comment('Tavsif (Ruscha)'),
            'image' => $this->string(500)->comment('Rasm'),
            'status' => $this->tinyInteger()->notNull()->defaultValue(1)->comment('Status (1-active, 0-inactive)'),
            'sort_order' => $this->integer()->defaultValue(0)->comment('Tartiblash'),
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),
        ]);

        // UNIQUE index alohida yaratamiz
        $this->createIndex('idx-categories-slug', '{{%categories}}', 'slug', true);
        $this->createIndex('idx-categories-status', '{{%categories}}', 'status');
        $this->createIndex('idx-categories-sort_order', '{{%categories}}', 'sort_order');
    }

    public function safeDown()
    {
        $this->dropTable('{{%categories}}');
    }
}
