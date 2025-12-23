<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%partners}}`.
 */
class m251223_052611_create_partners_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%partners}}', [
            'id' => $this->primaryKey(),
            'brand_name_uz' => $this->string(255)->notNull()->comment('Brend nomi (O\'zbekcha)'),
            'brand_name_ru' => $this->string(255)->notNull()->comment('Brend nomi (Ruscha)'),
            'logo' => $this->string(500)->comment('Logo'),
            'description_uz' => $this->text()->comment('Qisqa ma\'lumot (O\'zbekcha)'),
            'description_ru' => $this->text()->comment('Qisqa ma\'lumot (Ruscha)'),
            'website' => $this->string(255)->comment('Veb-sayt'),
            'status' => $this->tinyInteger()->notNull()->defaultValue(1)->comment('Status (1-active, 0-inactive)'),
            'sort_order' => $this->integer()->defaultValue(0)->comment('Tartiblash'),
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),
        ]);

        $this->createIndex('idx-partners-status', '{{%partners}}', 'status');
        $this->createIndex('idx-partners-sort_order', '{{%partners}}', 'sort_order');
    }

    public function safeDown()
    {
        $this->dropTable('{{%partners}}');
    }
}
