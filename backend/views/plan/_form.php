<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

$company_id = 1;
$branch_id = 1;
if (!empty(\Yii::$app->user->identity->company_id)) {
    $company_id = \Yii::$app->user->identity->company_id;
}
if (!empty(\Yii::$app->user->identity->branch_id)) {
    $branch_id = \Yii::$app->user->identity->branch_id;
}
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
            <?= $form->field($model, 'route_id')->widget(\kartik\select2\Select2::className(), [
                'data' => \yii\helpers\ArrayHelper::map(\backend\models\Deliveryroute::find()->where(['company_id'=>$company_id,'branch_id'=>$branch_id])->all(), 'id', 'name'),
                'options' => [
                    'placeholder' => 'เลือกสายส่ง'
                ]
            ]) ?>
        </div>
        <div class="col-lg-3">
            <?= $form->field($model, 'customer_id')->widget(\kartik\select2\Select2::className(), [
                'data' => \yii\helpers\ArrayHelper::map(\backend\models\Customer::find()->where(['company_id'=>$company_id,'branch_id'=>$branch_id])->all(), 'id', 'name'),
                'options' => [
                    'placeholder' => 'เลือกลูกค้า'
                ]
            ]) ?>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-3">
            <?= $form->field($model, 'description')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-lg-3">
            <?= $form->field($model, 'status')->textInput(['readonly'=>'readonly']) ?>
        </div>
    </div>
    <br />

    <div class="row">
        <div class="col-lg-12">
            <table class="table table-bordered table-triped">
                <thead>
                <tr>
                    <th style="text-align: center;width: 5%">
                        #
                    </th>
                    <th>
                        รหัสสินค้า
                    </th>
                    <th>
                        ชื่อสินค้า
                    </th>
                    <th style="text-align: right">
                        จำนวน
                    </th>
                    <th style="text-align: center;width: 10%">
                        -
                    </th>
                </tr>
                </thead>
            </table>
        </div>
    </div>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
