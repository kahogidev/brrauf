<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%managers}}`.
 */
class m251223_042434_create_managers_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%managers}}', [
            'id' => $this->primaryKey(),
            'full_name' => $this->string(255)->notNull()->comment('To\'liq ismi'),
            'position_uz' => $this->string(255)->notNull()->comment('Lavozimi (O\'zbekcha)'),
            'position_ru' => $this->string(255)->notNull()->comment('Lavozimi (Ruscha)'),
            'bio_uz' => $this->text()->comment('Biografiya (O\'zbekcha)'),
            'bio_ru' => $this->text()->comment('Biografiya (Ruscha)'),
            'photo' => $this->string(500)->comment('Rasmi'),
            'status' => $this->tinyInteger()->notNull()->defaultValue(1)->comment('Status (1-active, 0-inactive)'),
            'sort_order' => $this->integer()->defaultValue(0)->comment('Tartiblash'),
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),
        ]);

        $this->createIndex('idx-managers-status', '{{%managers}}', 'status');
        $this->createIndex('idx-managers-sort_order', '{{%managers}}', 'sort_order');
    }

    public function safeDown()
    {
        $this->dropTable('{{%managers}}');
    }
}
