<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

$dash_date = null;
if ($model->f_date != null && $$model->t_date != null) {
    $dash_date = date('d/m/Y', strtotime($$model->f_date)) . ' - ' . date('d/m/Y', strtotime($$model->t_date));
}
?>

<div class="position-search">

    <?php $form = ActiveForm::begin([
        'action' => ['salehistory'],
        'method' => 'get',
        'options' => [
            'data-pjax' => 1
        ],
    ]); ?>

    <div class="input-group">
        <!--         <span class="input-group-addon" id="basic-addon1"><i class="fa fa-search"></i></span>-->
        <?= $form->field($model, 'globalSearch')->textInput(['placeholder' => 'ค้นหา', 'class' => 'form-control', 'aria-describedby' => 'basic-addon1'])->label(false) ?>
       <?php $model->created_by = $model->created_by == null ? \Yii::$app->user->id: $model->created_by ?>
        <?= $form->field($model, 'created_by')->widget(\kartik\select2\Select2::className(), [
            'data' => \yii\helpers\ArrayHelper::map(\backend\models\User::find()->all(), 'id', function ($data) {
                return $data->username;
            }),
            'options' => [
                'placeholder' => '--เลือกพนักงาน--'
            ],
            'pluginOptions' => [
                'allowClear' => true
            ],
        ])->label(false) ?>
        <?= $form->field($model, 'order_date')->widget(\kartik\daterange\DateRangePicker::className(), [
            'value' => $dash_date,
            'pluginOptions' => [
                'format' => 'DD/MM/YYYY',
                'locale' => [
                    'format' => 'DD/MM/YYYY'
                ],
            ],
            'presetDropdown' => true,
            'options' => [
                'class' => 'form-control',
                'onchange' => '$("#form-dashboard").submit();'
            ],
        ])->label(false) ?>
        <span style="margin-left: 10px;"> <button type="submit" class="btn btn-primary">ค้นหา</button></span>

    </div>

    <?php ActiveForm::end(); ?>

</div>
