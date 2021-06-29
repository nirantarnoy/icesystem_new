<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\Plan */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="plan-form">

    <?php $form = ActiveForm::begin(); ?>

    <div class="row">
        <div class="col-lg-3">
            <?= $form->field($model, 'journal_no')->textInput(['maxlength' => true, 'readonly' => 'readonly']) ?>
        </div>
        <div class="col-lg-3">
            <?= $form->field($model, 'trans_date')->widget(\kartik\date\DatePicker::className(), [
                'options' => [
                    'format' => 'dd/mm/yyyy'
                ]
            ]) ?>
        </div>
        <div class="col-lg-3">
            <?= $form->field($model, 'customer_id')->widget(\kartik\select2\Select2::className(), [
                'data' => \yii\helpers\ArrayHelper::map(\backend\models\Customer::find()->where(['companay_id'=>$company_id,'branch_id'=>$branch_id])->all(), 'id', 'name'),
                'options' => [
                    'placeholder' => 'เลือกลูกค้า'
                ]
            ]) ?>
        </div>
        <div class="col-lg-3">
            <?= $form->field($model, 'description')->textInput(['maxlength' => true]) ?>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-3">
            <?= $form->field($model, 'status')->textInput(['readonly'=>'readonly']) ?>
        </div>
    </div>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
