<?php

use yii\db\Migration;

/**
 * Class m240419_000002_modify_organization_table
 */
class m240419_000002_modify_organization_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        // Drop existing columns
        $this->dropColumn('{{%organization}}', 'title');
        $this->dropColumn('{{%organization}}', 'organization_unit_type');
        $this->dropColumn('{{%organization}}', 'parent');
        $this->dropColumn('{{%organization}}', 'institute_name');
        $this->dropColumn('{{%organization}}', 'status');
        
        // Add new columns
        $this->addColumn('{{%organization}}', 'name', $this->string()->notNull()->after('id'));
        $this->addColumn('{{%organization}}', 'email', $this->string()->notNull()->after('name'));
        $this->addColumn('{{%organization}}', 'phone', $this->string(20)->after('email'));
        $this->addColumn('{{%organization}}', 'address', $this->string()->after('phone'));

        // Modify timestamp columns to integer
        $this->alterColumn('{{%organization}}', 'created_at', $this->integer());
        $this->alterColumn('{{%organization}}', 'updated_at', $this->integer());

        // Create indexes
        $this->createIndex(
            'idx-organization-name',
            '{{%organization}}',
            'name'
        );

        $this->createIndex(
            'idx-organization-email',
            '{{%organization}}',
            'email'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        // Drop new columns
        $this->dropColumn('{{%organization}}', 'name');
        $this->dropColumn('{{%organization}}', 'email');
        $this->dropColumn('{{%organization}}', 'phone');
        $this->dropColumn('{{%organization}}', 'address');

        // Restore original columns
        $this->addColumn('{{%organization}}', 'title', $this->string()->notNull());
        $this->addColumn('{{%organization}}', 'organization_unit_type', $this->string()->notNull());
        $this->addColumn('{{%organization}}', 'parent', $this->string()->notNull());
        $this->addColumn('{{%organization}}', 'institute_name', $this->string()->notNull());
        $this->addColumn('{{%organization}}', 'status', $this->string()->notNull()->defaultValue('Active'));

        // Restore timestamp columns
        $this->alterColumn('{{%organization}}', 'created_at', 'timestamp NULL DEFAULT CURRENT_TIMESTAMP');
        $this->alterColumn('{{%organization}}', 'updated_at', 'timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP');
    }
} 