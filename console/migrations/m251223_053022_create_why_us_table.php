<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%why_us}}`.
 */
class m251223_053022_create_why_us_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%why_us}}', [
            'id' => $this->primaryKey(),
            'title_uz' => $this->string(255)->notNull()->comment('Sarlavha (O\'zbekcha)'),
            'title_ru' => $this->string(255)->notNull()->comment('Sarlavha (Ruscha)'),
            'description_uz' => $this->text()->comment('Tavsif (O\'zbekcha)'),
            'description_ru' => $this->text()->comment('Tavsif (Ruscha)'),
            'status' => $this->tinyInteger()->notNull()->defaultValue(1)->comment('Status (1-active, 0-inactive)'),

        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%why_us}}');
    }
}
