<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "query_order_update".
 *
 * @property int|null $customer_id
 * @property string|null $name
 * @property int|null $order_id
 * @property string|null $code
 */
class QueryOrderUpdate extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'query_order_update';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['customer_id', 'order_id'], 'integer'],
            [['name', 'code'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'customer_id' => 'Customer ID',
            'name' => 'Name',
            'order_id' => 'Order ID',
            'code' => 'Code',
        ];
    }
}
