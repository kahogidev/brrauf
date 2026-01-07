<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%production_volume}}`.
 */
class m251224_162940_create_production_volume_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%production_volume}}', [
            'id' => $this->primaryKey(),
            'title_uz' => $this->string(255)->notNull()->comment('Sarlavha (O\'zbekcha)'),
            'title_ru' => $this->string(255)->notNull()->comment('Sarlavha (Ruscha)'),
            'description_uz' => $this->text()->comment('Tavsif (O\'zbekcha)'),
            'description_ru' => $this->text()->comment('Tavsif (Ruscha)'),
            'volume' => $this->decimal(15, 2)->notNull()->comment('Hajm (miqdor)'),
            'unit_uz' => $this->string(50)->notNull()->comment('O\'lchov birligi (O\'zbekcha)'),
            'unit_ru' => $this->string(50)->notNull()->comment('O\'lchov birligi (Ruscha)'),
            'period_uz' => $this->string(100)->comment('Davr (O\'zbekcha)'),
            'period_ru' => $this->string(100)->comment('Davr (Ruscha)'),
            'images' => $this->text()->comment('Rasmlar (JSON format)'),
            'videos' => $this->text()->comment('Video linklar (JSON format)'),
            'status' => $this->tinyInteger()->notNull()->defaultValue(1)->comment('Status (1-active, 0-inactive)'),
            'sort_order' => $this->integer()->defaultValue(0)->comment('Tartiblash'),
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),
        ]);

        $this->createIndex('idx-production_volume-status', '{{%production_volume}}', 'status');
        $this->createIndex('idx-production_volume-sort_order', '{{%production_volume}}', 'sort_order');
    }

    public function safeDown()
    {
        $this->dropTable('{{%production_volume}}');
    }
}
