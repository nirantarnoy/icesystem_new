<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "query_sale_pos_data".
 *
 * @property int $id
 * @property string|null $order_no
 * @property string|null $order_date
 * @property int|null $sale_channel_id
 * @property int|null $product_id
 * @property float|null $qty
 * @property float|null $price
 * @property float|null $line_total
 * @property int|null $emp_sale_id
 * @property string|null $code
 * @property string|null $name
 */
class QuerySalePosData extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'query_sale_pos_data';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'sale_channel_id', 'product_id', 'emp_sale_id'], 'integer'],
            [['order_date'], 'safe'],
            [['qty', 'price', 'line_total'], 'number'],
            [['order_no', 'code', 'name'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'order_no' => 'Order No',
            'order_date' => 'Order Date',
            'sale_channel_id' => 'Sale Channel ID',
            'product_id' => 'Product ID',
            'qty' => 'Qty',
            'price' => 'Price',
            'line_total' => 'Line Total',
            'emp_sale_id' => 'Emp Sale ID',
            'code' => 'Code',
            'name' => 'Name',
        ];
    }
}
