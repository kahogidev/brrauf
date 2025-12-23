<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%company_history}}`.
 */
class m251222_190537_create_company_history_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%company_history}}', [
            'id' => $this->primaryKey(),
            'year' => $this->integer()->notNull()->comment('Yil'),
            'title_uz' => $this->string(255)->notNull()->comment('Sarlavha (O\'zbekcha)'),
            'title_ru' => $this->string(255)->notNull()->comment('Sarlavha (Ruscha)'),
            'description_uz' => $this->text()->notNull()->comment('Tavsif (O\'zbekcha)'),
            'description_ru' => $this->text()->notNull()->comment('Tavsif (Ruscha)'),
            'images' => $this->text()->comment('Rasmlar (JSON format)'),
            'videos' => $this->text()->comment('Video linklar (JSON format)'),
            'status' => $this->tinyInteger()->notNull()->defaultValue(1)->comment('Status (1-active, 0-inactive)'),
            'sort_order' => $this->integer()->defaultValue(0)->comment('Tartiblash'),
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),
        ]);

        $this->createIndex('idx-company_history-year', '{{%company_history}}', 'year');
        $this->createIndex('idx-company_history-status', '{{%company_history}}', 'status');
        $this->createIndex('idx-company_history-sort_order', '{{%company_history}}', 'sort_order');
    }

    public function safeDown()
    {
        $this->dropTable('{{%company_history}}');
    }
}
