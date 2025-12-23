<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%portfolio}}`.
 */
class m251223_052600_create_portfolio_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%portfolio}}', [
            'id' => $this->primaryKey(),
            'company_name_uz' => $this->string(255)->notNull()->comment('Kompaniya nomi (O\'zbekcha)'),
            'company_name_ru' => $this->string(255)->notNull()->comment('Kompaniya nomi (Ruscha)'),
            'company_logo' => $this->string(500)->comment('Kompaniya logosi'),
            'title_uz' => $this->string(255)->notNull()->comment('Sarlavha (O\'zbekcha)'),
            'title_ru' => $this->string(255)->notNull()->comment('Sarlavha (Ruscha)'),
            'description_uz' => $this->text()->comment('Qisqa tavsif (O\'zbekcha)'),
            'description_ru' => $this->text()->comment('Qisqa tavsif (Ruscha)'),
            'content_uz' => $this->text()->comment('Batafsil matn (O\'zbekcha)'),
            'content_ru' => $this->text()->comment('Batafsil matn (Ruscha)'),
            'images' => $this->text()->comment('Rasmlar (JSON format)'),
            'videos' => $this->text()->comment('Videolar - YouTube linklar (JSON format)'),
            'project_date' => $this->date()->comment('Loyiha sanasi'),
            'status' => $this->tinyInteger()->notNull()->defaultValue(1)->comment('Status (1-active, 0-inactive)'),
            'sort_order' => $this->integer()->defaultValue(0)->comment('Tartiblash'),
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),
        ]);

        $this->createIndex('idx-portfolio-status', '{{%portfolio}}', 'status');
        $this->createIndex('idx-portfolio-sort_order', '{{%portfolio}}', 'sort_order');
    }

    public function safeDown()
    {
        $this->dropTable('{{%portfolio}}');
    }
}
