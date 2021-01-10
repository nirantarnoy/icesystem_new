<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\Orders */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="orders-form">

    <?php $form = ActiveForm::begin(); ?>

    <div class="row">
        <div class="col-lg-3">
            <?= $form->field($model, 'order_no')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-lg-3">
            <?= $form->field($model, 'order_date')->textInput() ?>
        </div>
        <div class="col-lg-3">
            <?= $form->field($model, 'customer_id')->textInput() ?>
        </div>
        <div class="col-lg-3">
            <?= $form->field($model, 'emp_sale_id')->textInput() ?>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-3">
            <?= $form->field($model, 'order_channel_id')->textInput() ?>
        </div>
        <div class="col-lg-3">
            <?= $form->field($model, 'car_ref_id')->textInput() ?>
        </div>
        <div class="col-lg-3">
            <?= $form->field($model, 'order_total_amt')->textInput() ?>
        </div>
        <div class="col-lg-3">
            <?= $form->field($model, 'status')->textInput() ?>
        </div>
    </div>
    <br>
    <table class="table table-bordered table-striped table-list">
        <thead>
        <tr>
            <th style="width: 5%;text-align: center">#</th>
            <th>รหัสสินค้า</th>
            <th>ชื่อสินค้า</th>
            <th style="text-align: right">จำนวน</th>
            <th style="text-align: right">ราคา</th>
            <th style="text-align: right">รวม</th>
            <th style="width: 5%;text-align: center">-</th>
        </tr>
        </thead>
    </table>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
