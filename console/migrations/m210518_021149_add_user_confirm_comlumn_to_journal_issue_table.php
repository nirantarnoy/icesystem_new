<?php

use yii\db\Migration;

/**
 * Class m210518_021149_add_user_confirm_comlumn_to_journal_issue_table
 */
class m210518_021149_add_user_confirm_comlumn_to_journal_issue_table extends Migration
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
        echo "m210518_021149_add_user_confirm_comlumn_to_journal_issue_table cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m210518_021149_add_user_confirm_comlumn_to_journal_issue_table cannot be reverted.\n";

        return false;
    }
    */
}
