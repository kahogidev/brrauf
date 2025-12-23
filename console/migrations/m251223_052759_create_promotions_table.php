<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%promotions}}`.
 */
class m251223_052759_create_promotions_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%promotions}}', [
            'id' => $this->primaryKey(),
            'title_uz' => $this->string(255)->notNull()->comment('Sarlavha (O\'zbekcha)'),
            'title_ru' => $this->string(255)->notNull()->comment('Sarlavha (Ruscha)'),
            'description_uz' => $this->text()->comment('Tavsif (O\'zbekcha)'),
            'description_ru' => $this->text()->comment('Tavsif (Ruscha)'),
            'discount_percent' => $this->decimal(5, 2)->notNull()->comment('Chegirma foizi'),
            'image' => $this->string(500)->comment('Aksiya rasmi'),
            'start_date' => $this->date()->notNull()->comment('Boshlanish sanasi'),
            'end_date' => $this->date()->notNull()->comment('Tugash sanasi'),
            'status' => $this->tinyInteger()->notNull()->defaultValue(1)->comment('Status (1-active, 0-inactive)'),
            'sort_order' => $this->integer()->defaultValue(0)->comment('Tartiblash'),
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),
        ]);

        $this->createIndex('idx-promotions-status', '{{%promotions}}', 'status');
        $this->createIndex('idx-promotions-sort_order', '{{%promotions}}', 'sort_order');
        $this->createIndex('idx-promotions-dates', '{{%promotions}}', ['start_date', 'end_date']);
    }

    public function safeDown()
    {
        $this->dropTable('{{%promotions}}');
    }
}
