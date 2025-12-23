<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%vacancy_applications}}`.
 */
class m251223_052727_create_vacancy_applications_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%vacancy_applications}}', [
            'id' => $this->primaryKey(),
            'vacancy_id' => $this->integer()->notNull()->comment('Vakansiya ID'),
            'full_name' => $this->string(255)->notNull()->comment('To\'liq ismi'),
            'email' => $this->string(100)->notNull()->comment('Email'),
            'phone' => $this->string(50)->notNull()->comment('Telefon'),
            'birth_date' => $this->date()->comment('Tug\'ilgan sana'),
            'education' => $this->string(255)->comment('Ma\'lumoti'),
            'experience' => $this->text()->comment('Ish tajribasi'),
            'cover_letter' => $this->text()->comment('Qo\'shimcha ma\'lumot / Cover letter'),
            'resume_file' => $this->string(500)->comment('Resume fayli (CV)'),
            'status' => $this->string(50)->notNull()->defaultValue('new')->comment('Status (new, viewed, accepted, rejected)'),
            'admin_notes' => $this->text()->comment('Admin izohlar'),
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),
        ]);

        $this->createIndex('idx-vacancy_applications-vacancy_id', '{{%vacancy_applications}}', 'vacancy_id');
        $this->createIndex('idx-vacancy_applications-status', '{{%vacancy_applications}}', 'status');
        $this->createIndex('idx-vacancy_applications-created_at', '{{%vacancy_applications}}', 'created_at');

        $this->addForeignKey(
            'fk-vacancy_applications-vacancy_id',
            '{{%vacancy_applications}}',
            'vacancy_id',
            '{{%vacancies}}',
            'id',
            'CASCADE',
            'CASCADE'
        );
    }

    public function safeDown()
    {
        $this->dropForeignKey('fk-vacancy_applications-vacancy_id', '{{%vacancy_applications}}');
        $this->dropTable('{{%vacancy_applications}}');
    }
}
