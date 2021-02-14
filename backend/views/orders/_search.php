<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\OrdersSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="orders-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
        'options' => [
            'id' => 'form-order',
            'data-pjax' => 1
        ],
    ]); ?>
    <div class="row">
        <div class="col-lg-5">
            <div class="input-group">
                <!--         <span class="input-group-addon" id="basic-addon1"><i class="fa fa-search"></i></span>-->
                <?= $form->field($model, 'globalSearch')->textInput(['placeholder' => 'เลขที่ขาย,สายส่ง,รถ', 'class' => 'form-control', 'aria-describedby' => 'basic-addon1'])->label(false) ?>
                <?php $model->order_date = $model->order_date == null ? date('d/m/Y') : date('d/m/Y', strtotime($model->order_date)); ?>
                <?= $form->field($model, 'order_date')->widget(\kartik\date\DatePicker::className(), [
                    'value' => $model->order_date,
                    'options' => [
                     //   'onclick' => '$("form#form-order").submit()'
                    ],
                    'pluginOptions' => [
                        'format' => 'dd/mm/yyyy',
                        'todayHighlight' => true
                    ],
                ])->label(false) ?>

            </div>
        </div>
        <div class="col-lg-6">
            <button type="submit" class="btn btn-primary btn-search" style="margin-left: 5px;"><i
                        class='fa fa-search'></i> ค้นหา
            </button>
        </div>
    </div>
    <?php ActiveForm::end(); ?>

</div>
