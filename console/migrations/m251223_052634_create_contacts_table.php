<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%contacts}}`.
 */
class m251223_052634_create_contacts_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%contacts}}', [
            'id' => $this->primaryKey(),
            'phone1' => $this->string(50)->notNull()->comment('Telefon raqam 1'),
            'phone2' => $this->string(50)->comment('Telefon raqam 2'),
            'address1_uz' => $this->string(500)->notNull()->comment('Manzil 1 (O\'zbekcha)'),
            'address1_ru' => $this->string(500)->notNull()->comment('Manzil 1 (Ruscha)'),
            'address2_uz' => $this->string(500)->comment('Manzil 2 (O\'zbekcha)'),
            'address2_ru' => $this->string(500)->comment('Manzil 2 (Ruscha)'),
            'email' => $this->string(100)->notNull()->comment('Email'),
            'instagram' => $this->string(255)->comment('Instagram link'),
            'facebook' => $this->string(255)->comment('Facebook link'),
            'linkedin' => $this->string(255)->comment('LinkedIn link'),
            'youtube' => $this->string(255)->comment('YouTube link'),
            'telegram' => $this->string(255)->comment('Telegram link'),
            'working_hours_uz' => $this->string(255)->comment('Ish vaqti (O\'zbekcha)'),
            'working_hours_ru' => $this->string(255)->comment('Ish vaqti (Ruscha)'),
            'map_latitude' => $this->string(50)->comment('Xarita - Latitude'),
            'map_longitude' => $this->string(50)->comment('Xarita - Longitude'),
            'updated_at' => $this->integer()->notNull(),
        ]);
    }

    public function safeDown()
    {
        $this->dropTable('{{%contacts}}');
    }
}
