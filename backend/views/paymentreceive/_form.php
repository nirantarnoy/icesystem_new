<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
$t_date = date('d/m/Y');
?>

<div class="paymentreceive-form">

    <?php $form = ActiveForm::begin(); ?>
    <div class="row">
        <div class="col-lg-4">
            <?= $form->field($model, 'journal_no')->textInput(['maxlength' => true, 'readonly' => 'readonly']) ?>
        </div>
        <div class="col-lg-4">
            <?= $form->field($model, 'trans_date')->widget(\kartik\date\DatePicker::className(), [
                'data' => $t_date,
            ]) ?>
        </div>
        <div class="col-lg-4">
            <?= $form->field($model, 'customer_id')->widget(\kartik\select2\Select2::className(), [
                'data' => \yii\helpers\ArrayHelper::map(\backend\models\Customer::find()->all(), 'id', function ($data) {
                    return $data->code . ' ' . $data->name;
                }),
                'options' => [
                    'placeholder' => '--เลือกลูกค้า--',
                    'onchange' => 'getpaymentrec($(this));'
                ],
                'pluginOptions' => [
                    'allowClear' => true,
                ]
            ]) ?>
        </div>
    </div>
    <hr>
    <div class="row">
        <div class="col-lg-12">
            <table class="table table-striped table-bordered table-list">
                <thead>
                <tr>
                    <th style="text-align: center" width="5%">#</th>
                    <th style="text-align: center">เลขที่</th>
                    <th style="text-align: center">วันที่</th>
                    <th style="text-align: center">ช่องทางชำระ</th>
<!--                    <th style="text-align: center">แนบเอกสาร</th>-->
                    <th style="text-align: center">ค้างชำระ</th>
                    <th style="text-align: center">ยอดชำระ</th>
                </tr>
                </thead>
                <tbody>
<!--                <tr>-->
<!--                    <td></td>-->
<!--                    <td></td>-->
<!--                    <td></td>-->
<!--                    <td></td>-->
<!--                    <td></td>-->
<!--                </tr>-->
                </tbody>
            </table>
        </div>
    </div>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>


<?php
$url_to_get_receive = \yii\helpers\Url::to(['paymentreceive/getitem'], true);
$js = <<<JS
$(function(){
    
});
function getpaymentrec(e){
    var ids = e.val();
    if(ids){
        $.ajax({
              'type':'post',
              'dataType': 'html',
              'async': false,
              'url': "$url_to_get_receive",
              'data': {'customer_id': ids},
              'success': function(data) {
                  //  alert(data);
                   $(".table-list tbody").html(data);
                 }
              });
    }
}
JS;

$this->registerJs($js, static::POS_END);
?>
