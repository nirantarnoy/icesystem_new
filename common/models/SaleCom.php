<?php

namespace common\models;

use Yii;

class SaleCom extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'sale_com';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['emp_qty', 'status', 'created_at', 'updated_at', 'created_by'], 'integer'],
            [['com_extra'], 'number'],
            [['code', 'name'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'code' => 'Code',
            'name' => 'Name',
            'emp_qty' => 'Emp Qty',
            'com_extra' => 'Com Extra',
            'status' => 'Status',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'created_by' => 'Created By',
        ];
    }
}
