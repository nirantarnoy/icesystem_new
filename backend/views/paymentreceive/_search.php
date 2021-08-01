<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\PaymentreceiveSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="paymentreceive-search">

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
        <?= $form->field($model, 'trans_date')->widget(\kartik\date\DatePicker::className(),[
                'options' => [

                ],
                'pluginOptions' => [
                    'format'=>'dd/mm/yyyy'
                ]
        ])->label(false) ?>
        <?= $form->field($model, 'route_id')->widget(\kartik\select2\Select2::className(),[
                'data'=> \yii\helpers\ArrayHelper::map(\backend\models\Deliveryroute::find()->all(),'id','name'),
                 'options' => [
                         'placeholder'=>'เลือกสายส่ง',
                         'style'=>'margin-left: 5px;',
                 ],
            'pluginOptions' => [
                    'allowClear'=> true,
            ]
        ])->label(false) ?>
        <button type="submit" class="btn btn-primary btn-sm" style="height: 40px;margin-left:5px;">ค้นหา</button>
    </div>

    <?php ActiveForm::end(); ?>

</div>
