<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%vacancies}}`.
 */
class m251223_052656_create_vacancies_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%vacancies}}', [
            'id' => $this->primaryKey(),
            'title_uz' => $this->string(255)->notNull()->comment('Lavozim nomi (O\'zbekcha)'),
            'title_ru' => $this->string(255)->notNull()->comment('Lavozim nomi (Ruscha)'),
            'description_uz' => $this->text()->comment('Tavsif (O\'zbekcha)'),
            'description_ru' => $this->text()->comment('Tavsif (Ruscha)'),
            'requirements_uz' => $this->text()->comment('Talablar (O\'zbekcha)'),
            'requirements_ru' => $this->text()->comment('Talablar (Ruscha)'),
            'benefits_uz' => $this->text()->comment('Taklif qilinadigan imkoniyatlar (O\'zbekcha)'),
            'benefits_ru' => $this->text()->comment('Taklif qilinadigan imkoniyatlar (Ruscha)'),
            'image' => $this->string(500)->comment('Rasm'),
            'salary_from' => $this->decimal(15, 2)->comment('Maosh (dan)'),
            'salary_to' => $this->decimal(15, 2)->comment('Maosh (gacha)'),
            'employment_type' => $this->string(50)->comment('Ish turi (full-time, part-time, remote)'),
            'deadline' => $this->date()->comment('Arizalar qabul qilish muddati'),
            'status' => $this->tinyInteger()->notNull()->defaultValue(1)->comment('Status (1-active, 0-inactive)'),
            'sort_order' => $this->integer()->defaultValue(0)->comment('Tartiblash'),
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),
        ]);

        $this->createIndex('idx-vacancies-status', '{{%vacancies}}', 'status');
        $this->createIndex('idx-vacancies-sort_order', '{{%vacancies}}', 'sort_order');
        $this->createIndex('idx-vacancies-deadline', '{{%vacancies}}', 'deadline');
    }

    public function safeDown()
    {
        $this->dropTable('{{%vacancies}}');
    }
}
