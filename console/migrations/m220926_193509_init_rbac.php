<?php

use yii\db\Migration;

/**
 * Class m220926_193509_init_rbac
 */
class m220926_193509_init_rbac extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m220926_193509_init_rbac cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m220926_193509_init_rbac cannot be reverted.\n";

        return false;
    }
    */
}
