<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%organization}}`.
 */
class m240320_000001_create_organization_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('organization', [
            'id' => $this->primaryKey()->unsigned(),
            'title' => $this->string()->notNull(),
            'organization_unit_type' => $this->string()->notNull(),
            'parent' => $this->string()->notNull(),
            'institute_name' => $this->string()->notNull(),
            'status' => $this->string()->notNull()->defaultValue('Active'),
            'created_at' => $this->timestamp()->defaultExpression('CURRENT_TIMESTAMP'),
            'updated_at' => $this->timestamp()->defaultExpression('CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP'),
        ]);

        // Set the auto-increment start value
        $this->execute('ALTER TABLE organization AUTO_INCREMENT = 20000000');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('organization');
    }
} 