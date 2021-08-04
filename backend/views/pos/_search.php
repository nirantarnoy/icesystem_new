<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

$dash_date = null;
$trigger_submit = 0;
if ($model->order_date != null) {
    $trigger_submit = 0;
    //$dash_date = date('d/m/Y', strtotime($model->f_date)) . ' - ' . date('d/m/Y', strtotime($model->t_date));
} else {
    $model->order_date = date('d/m/Y') . '-' . date('d/m/Y');
    $trigger_submit = 1;
}

$company_id = 0;
$branch_id = 0;

if (!empty(\Yii::$app->user->identity->company_id)) {
    $company_id = \Yii::$app->user->identity->company_id;
}
if (!empty(\Yii::$app->user->identity->branch_id)) {
    $branch_id= \Yii::$app->user->identity->branch_id;
}

//echo $dash_date;
?>

<div class="position-search">
    <input type="hidden" id="check-is-init" value="<?= $trigger_submit ?>">
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
        <?php $model->created_by = $model->created_by == null ? \Yii::$app->user->id : $model->created_by ?>
        <?= $form->field($model, 'created_by')->widget(\kartik\select2\Select2::className(), [
            'data' => \yii\helpers\ArrayHelper::map(\backend\models\User::find()->where(['company_id'=>$company_id,'branch_id'=>$branch_id])->all(), 'id', function ($data) {
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
                'id' => 'search-date',
                'class' => 'form-control',
                'onchange' => '$("#form-dashboard").submit();'
            ],
        ])->label(false) ?>
        <span style="margin-left: 10px;"> <button type="submit" class="btn btn-primary btn-find-data">ค้นหา</button></span>

    </div>

    <?php ActiveForm::end(); ?>

</div>
<?php
$js = <<<JS
$(function(){
   var x = $("#check-is-init").val();
   if(x == 1){
       $("#search-date").trigger('change');
   }
});
JS;
$this->registerJs($js, static::POS_END);
?>
