<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%news}}`.
 */
class m251223_052620_create_news_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%news}}', [
            'id' => $this->primaryKey(),
            'title_uz' => $this->string(255)->notNull()->comment('Sarlavha (O\'zbekcha)'),
            'title_ru' => $this->string(255)->notNull()->comment('Sarlavha (Ruscha)'),
            'slug' => $this->string(191)->notNull()->comment('URL slug'),
            'description_uz' => $this->text()->comment('Qisqa tavsif (O\'zbekcha)'),
            'description_ru' => $this->text()->comment('Qisqa tavsif (Ruscha)'),
            'content_uz' => $this->text()->comment('To\'liq matn (O\'zbekcha)'),
            'content_ru' => $this->text()->comment('To\'liq matn (Ruscha)'),
            'images' => $this->text()->comment('Rasmlar (JSON format)'),
            'videos' => $this->text()->comment('Videolar - YouTube linklar (JSON format)'),
            'published_date' => $this->date()->comment('E\'lon qilingan sana'),
            'status' => $this->tinyInteger()->notNull()->defaultValue(1)->comment('Status (1-active, 0-inactive)'),
            'sort_order' => $this->integer()->defaultValue(0)->comment('Tartiblash'),
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),
        ]);

        $this->createIndex('idx-news-slug', '{{%news}}', 'slug', true);
        $this->createIndex('idx-news-status', '{{%news}}', 'status');
        $this->createIndex('idx-news-sort_order', '{{%news}}', 'sort_order');
        $this->createIndex('idx-news-published_date', '{{%news}}', 'published_date');
    }

    public function safeDown()
    {
        $this->dropTable('{{%news}}');
    }
}
