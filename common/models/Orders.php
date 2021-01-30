<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "orders".
 *
 * @property int $id
 * @property string|null $order_no
 * @property int|null $customer_id
 * @property int|null $customer_type
 * @property string|null $customer_name
 * @property string|null $order_date
 * @property float|null $vat_amt
 * @property float|null $vat_per
 * @property float|null $order_total_amt
 * @property int|null $emp_sale_id
 * @property int|null $car_ref_id
 * @property int|null $order_channel_id
 * @property int|null $status
 * @property int|null $company_id
 * @property int|null $branch_id
 * @property int|null $created_at
 * @property int|null $updated_at
 * @property int|null $created_by
 * @property int|null $updated_by
 *
 * @property Branch $branch
 * @property Company $company
 */
class Orders extends \yii\db\ActiveRecord
{
    public $order_total_amt_text;
    public static function tableName()
    {
        return 'orders';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['order_no'],'unique'],
            [['order_no','order_date','order_channel_id','car_ref_id'],'required'],
            [['customer_id', 'customer_type', 'emp_sale_id','payment_status', 'car_ref_id', 'order_channel_id', 'company_id', 'branch_id', 'created_at', 'updated_at', 'created_by', 'updated_by'], 'integer'],
            [['order_date','status','order_total_amt_text'], 'safe'],
            [['vat_amt', 'vat_per', 'order_total_amt'], 'number'],
            [['order_no', 'customer_name'], 'string', 'max' => 255],
            [['payment_method_id','payment_term_id',],'safe'],
            [['sale_channel_id'],'integer'],
            [['branch_id'], 'exist', 'skipOnError' => true, 'targetClass' => Branch::className(), 'targetAttribute' => ['branch_id' => 'id']],
            [['company_id'], 'exist', 'skipOnError' => true, 'targetClass' => Company::className(), 'targetAttribute' => ['company_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'order_no' => Yii::t('app', 'เลขที่'),
            'customer_id' => Yii::t('app', 'ลูกค้า'),
            'customer_type' => Yii::t('app', 'ประเภทลูกค้า'),
            'customer_name' => Yii::t('app', 'ชื่อลูกค้า'),
            'order_date' => Yii::t('app', 'วันที่สั่งซื้อ'),
            'vat_amt' => Yii::t('app', 'Vat Amt'),
            'vat_per' => Yii::t('app', 'Vat Per'),
            'order_total_amt' => Yii::t('app', 'ยอดรวม'),
            'emp_sale_id' => Yii::t('app', 'Emp Sale ID'),
            'car_ref_id' => Yii::t('app', 'รหัสรถ'),
            'order_channel_id' => Yii::t('app', 'สายส่ง'),
            'status' => Yii::t('app', 'สถานะ'),
            'payment_method_id' => Yii::t('app', 'วิธีชำระเงิน'),
            'payment_term_id' => Yii::t('app', 'เงื่อนไขชำระเงิน'),
            'sale_channel_id' => Yii::t('app', 'ช่องทางการขาย'),
            'payment_status' => Yii::t('app', 'สถานะชำระเงิน'),
            'company_id' => Yii::t('app', 'Company ID'),
            'branch_id' => Yii::t('app', 'Branch ID'),
            'created_at' => Yii::t('app', 'Created At'),
            'updated_at' => Yii::t('app', 'Updated At'),
            'created_by' => Yii::t('app', 'Created By'),
            'updated_by' => Yii::t('app', 'Updated By'),
        ];
    }

    /**
     * Gets query for [[Branch]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getBranch()
    {
        return $this->hasOne(Branch::className(), ['id' => 'branch_id']);
    }

    /**
     * Gets query for [[Company]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCompany()
    {
        return $this->hasOne(Company::className(), ['id' => 'company_id']);
    }
}
