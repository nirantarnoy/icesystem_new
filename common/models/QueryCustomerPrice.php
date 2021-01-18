<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "query_customer_price".
 *
 * @property int $customer_id
 * @property int|null $price_group_id
 * @property int|null $product_id
 * @property float|null $sale_price
 * @property int|null $customer_type_id
 */
class QueryCustomerPrice extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'query_customer_price';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['customer_id', 'price_group_id', 'product_id', 'customer_type_id'], 'integer'],
            [['sale_price'], 'number'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'customer_id' => 'Customer ID',
            'price_group_id' => 'Price Group ID',
            'product_id' => 'Product ID',
            'sale_price' => 'Sale Price',
            'customer_type_id' => 'Customer Type ID',
        ];
    }
}
