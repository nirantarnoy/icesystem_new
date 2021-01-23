<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\CustomerSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="customer-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
        'options' => [
            'data-pjax' => 1
        ],
    ]); ?>

    <div class="input-group">
        <!--         <span class="input-group-addon" id="basic-addon1"><i class="fa fa-search"></i></span>-->
        <?= $form->field($model, 'globalSearch')->textInput(['placeholder' => 'ค้นหา', 'class' => 'form-control', 'aria-describedby' => 'basic-addon1'])->label(false) ?>
        <span style="margin-left: 5px;"></span>
        <?= $form->field($model, 'customer_group_id')->widget(\kartik\select2\Select2::className(), [
            'data' => \yii\helpers\ArrayHelper::map(\backend\models\Customergroup::find()->all(), 'id', function ($data) {
                return $data->code . ' ' . $data->name;
            }),
            'options' => [
                'placeholder' => '--เลือกกลุ่ม--',
                'onchange' => 'this.form.submit();'
            ],
            'pluginOptions' => [
                'allowClear' => true,
            ]
        ])->label(false) ?>
        <span style="margin-left: 5px;"></span>
        <?= $form->field($model, 'customer_type_id')->widget(\kartik\select2\Select2::className(), [
            'data' => \yii\helpers\ArrayHelper::map(\backend\models\Customertype::find()->all(), 'id', function ($data) {
                return $data->code . ' ' . $data->name;
            }),
            'options' => [
                'placeholder' => '--เลือกประเภท--',
                'onchange' => 'this.form.submit();'
            ],
            'pluginOptions' => [
                'allowClear' => true,
            ]
        ])->label(false) ?>
        <span style="margin-left: 5px;"></span>
        <?= $form->field($model, 'delivery_route_id')->widget(\kartik\select2\Select2::className(), [
            'data' => \yii\helpers\ArrayHelper::map(\backend\models\Deliveryroute::find()->all(), 'id', function ($data) {
                return $data->code . ' ' . $data->name;
            }),
            'options' => [
                'placeholder' => '--เลือกสายส่ง--',
                'onchange' => 'this.form.submit();'
            ],
            'pluginOptions' => [
                'allowClear' => true,
            ]
        ])->label(false) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
