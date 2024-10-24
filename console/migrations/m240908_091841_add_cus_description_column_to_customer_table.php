<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%customer}}`.
 */
class m240908_091841_add_cus_description_column_to_customer_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%customer}}', 'cus_description', $this->string());
        $this->addColumn('{{%customer}}', 'sale_id', $this->integer());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%customer}}', 'cus_description');
        $this->dropColumn('{{%customer}}', 'sale_id');
    }
}
