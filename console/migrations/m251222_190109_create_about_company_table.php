<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%about-company}}`.
 */
class m251222_190109_create_about_company_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%about-company}}', [
            'id' => $this->primaryKey(),
            'title_uz' => $this->string(255)->notNull()->comment('Sarlavha (O\'zbekcha)'),
            'title_ru' => $this->string(255)->notNull()->comment('Sarlavha (Ruscha)'),
            'description_uz' => $this->text()->comment('Qisqacha tavsif (O\'zbekcha)'),
            'description_ru' => $this->text()->comment('Qisqacha tavsif (Ruscha)'),
            'content_uz' => $this->text()->notNull()->comment('Asosiy kontent (O\'zbekcha)'),
            'content_ru' => $this->text()->notNull()->comment('Asosiy kontent (Ruscha)'),
            'images' => $this->text()->comment('Rasmlar (JSON format)'),
            'videos' => $this->text()->comment('Video linklar (JSON format)'),
            'status' => $this->tinyInteger()->notNull()->defaultValue(1)->comment('Status (1-active, 0-inactive)'),
            'sort_order' => $this->integer()->defaultValue(0)->comment('Tartiblash'),
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),
        ]);

        $this->createIndex('idx-about-company-status', '{{%about-company}}', 'status');
        $this->createIndex('idx-about-company-sort_order', '{{%about-company}}', 'sort_order');
    }

    public function safeDown()
    {
        $this->dropTable('{{%about-company}}');
    }
}
