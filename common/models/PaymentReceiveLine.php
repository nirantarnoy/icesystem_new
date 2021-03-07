<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "payment_receive_line".
 *
 * @property int $id
 * @property int|null $payment_receive_id
 * @property int|null $order_id
 * @property int|null $product_id
 * @property float|null $remain_amount
 * @property float|null $payment_amount
 * @property int|null $status
 */
class PaymentReceiveLine extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'payment_receive_line';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['payment_receive_id', 'order_id', 'product_id', 'status'], 'integer'],
            [['remain_amount', 'payment_amount'], 'number'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'payment_receive_id' => 'Payment Receive ID',
            'order_id' => 'Order ID',
            'product_id' => 'Product ID',
            'remain_amount' => 'Remain Amount',
            'payment_amount' => 'Payment Amount',
            'status' => 'Status',
        ];
    }
}
