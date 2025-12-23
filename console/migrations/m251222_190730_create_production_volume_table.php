<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%production_volume}}`.
 */
class m251222_190730_create_production_volume_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%production_volume}}', [
            'id' => $this->primaryKey(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%production_volume}}');
    }
}
