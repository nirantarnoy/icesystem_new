<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "car_daily".
 *
 * @property int $id
 * @property int|null $car_id
 * @property int|null $employee_id
 * @property int|null $is_driver
 * @property int|null $status
 */
class CarDaily extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'car_daily';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['car_id', 'employee_id', 'is_driver', 'status'], 'integer'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'car_id' => 'Car ID',
            'employee_id' => 'Employee ID',
            'is_driver' => 'Is Driver',
            'status' => 'Status',
        ];
    }
}
