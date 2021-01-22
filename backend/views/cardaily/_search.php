<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\CardailySearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="cardaily-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
        'options' => [
            'data-pjax' => 1
        ],
    ]); ?>

    <div class="form-inline">
        <?= $form->field($model, 'car_id')->textInput(['class'=>'form-control','style'=>'margin-left:5px;margin-right:5px;','autocomplete'=>'off','placeholder'=>'ชื่อรถ หรือ รหัสรถ'])->label('ค้นหารถ') ?>
        <!--        <input type="text" class="form-control search-date" name="search_date" placeholder="เลือกวันที่" style="margin-left: 5px;">-->
        <?php //echo $form->field($model, 'trans_date')->textInput(['class'=>'form-control search-date','placeholder'=>'เลือกวันที่','autocomplete'=>'off'])->label(false) ?>
        <?= $form->field($model, 'trans_date')->widget(\kartik\date\DatePicker::className(),[
                'value' => date('d/m/Y'),
                'options' => [

                ]
        ])->label(false) ?>
        <button type="submit" class="btn btn-primary" style="margin-left: 5px;"><i class='fa fa-search'></i> ค้นหา </button>


        <?php ActiveForm::end(); ?>
    </div>
</div>
