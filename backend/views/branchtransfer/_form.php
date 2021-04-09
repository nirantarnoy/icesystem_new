<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

$model_from_com = \backend\models\Company::find()->all();
$model_to_com = \backend\models\Company::find()->all();

?>

<div class="branchtransfer-form">

    <?php $form = ActiveForm::begin(); ?>

    <div class="row">
        <div class="col-lg-4">
            <?= $form->field($model, 'journal_no')->textInput(['maxlength' => true, 'readonly' => 'readonly']) ?>
        </div>
        <div class="col-lg-4">
            <?php $model->trans_date = $model->isNewRecord ? date('d/m/Y') : date('d/m/Y', strtotime($model->trans_date)); ?>
            <?= $form->field($model, 'trans_date')->widget(\kartik\date\DatePicker::className(),
                [
                    'pluginOptions' => [
                        'format' => 'dd/mm/yyyy',
                        'todayHighlight' => true
                    ],
                ]) ?>
        </div>
        <div class="col-lg-4">
            <?= $form->field($model, 'description')->textInput(['maxlength' => true]) ?>
        </div>
    </div>
    <br/>
    <div class="row">
        <div class="col-lg-12">
            <table class="table table-bordered table-striped">
                <thead>
                <tr>
                    <th>#</th>
                    <th>รหัสสินค้า</th>
                    <th style="text-align: center">จากบริษัท</th>
                    <th style="text-align: center">จากสาขา</th>
                    <th style="text-align: center">จากคลัง</th>
                    <th style="text-align: center">ไปยังบริษัท</th>
                    <th style="text-align: center">ไปยังสาขา</th>
                    <th style="text-align: center">ไปยังคลัง</th>
                    <th style="width: 10%">จำนวน</th>
                    <th></th>
                </tr>
                </thead>
                <tbody>
                <tr>
                    <td></td>
                    <td>
                        <input type="text" name="" class="form-control line-product-name" value="PB">
                        <input type="hidden" name="line_product_id[]" class="line-product-id" value="1">
                    </td>
                    <td>
                        <select name="line_from_company[]" class="form-control line-select-from-company" id=""
                                style="background-color: #44ab7d;color: white;" onchange="getBranch($(this))">
                            <option value="-1">--เลือก--</option>
                            <?php foreach ($model_from_com as $value): ?>
                                <option value="<?= $value->id ?>"><?= $value->name ?></option>
                            <?php endforeach; ?>
                        </select>
                    </td>
                    <td>
                        <select name="line_from_branch[]" class="form-control line-select-from-branch" id=""
                                style="background-color: #44ab7d;color: white;" onchange="getWarehouse($(this))">
                            <option value="-1">--เลือก--</option>
                        </select>
                    </td>
                    <td>
                        <select name="line_from_warehouse[]" class="form-control line-select-from-warehouse" id=""
                                style="background-color: #44ab7d;color: white;">
                            <option value="-1">--เลือก--</option>
                        </select>
                    </td>
                    <td>
                        <select name="line_to_company[]" class="form-control" id=""
                                style="background-color: #f9a123;color: black;" onchange="getBranch2($(this))">
                            <option value="-1">--เลือก--</option>
                            <?php foreach ($model_from_com as $value): ?>
                                <option value="<?= $value->id ?>"><?= $value->name ?></option>
                            <?php endforeach; ?>
                        </select>
                    </td>
                    <td>
                        <select name="line_to_branch[]" class="form-control line-select-to-branch" id=""
                                style="background-color: #f9a123;color: black;" onchange="getWarehouse2($(this))">
                            <option value="-1">--เลือก--</option>
                        </select>
                    </td>
                    <td>
                        <select name="line_to_warehouse[]" class="form-control line-select-to-warehouse" id=""
                                style="background-color: #f9a123;color: black;" onchange="whchange($(this))">
                            <option value="-1">--เลือก--</option>
                        </select>
                    </td>
                    <td>
                        <input type="number" class="form-control line-qty" name="line_qty[]" value="" disabled>
                    </td>
                    <td></td>
                </tr>
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
$url_to_get_branch = \yii\helpers\Url::to(['branchtransfer/getbranch'], true);
$url_to_get_warehouse = \yii\helpers\Url::to(['branchtransfer/getwarehouse'], true);


$js = <<<JS
$(function(){});
function whchange(e){
    var wh1 = e.closest('tr').find('.line-select-from-warehouse').val();
    var wh2 = e.closest('tr').find('.line-select-to-warehouse').val();
    if(wh1 == wh2){
        alert('คลังสินค้าซ้ำกัน');
        e.closest('tr').find('.line-select-to-warehouse').val(-1).change();
        e.closest('tr').find('.line-qty').attr("disabled", true);
        return false;
    }else{
        e.closest('tr').find('.line-qty').attr("disabled", false);
    }
}
function getBranch(e){
     $.ajax({
              'type':'post',
              'dataType': 'html',
              'async': false,
              'url': "$url_to_get_branch" ,
              'data': {'company_id': e.val()},
              'success': function(data) {
                  //  alert(data);
                   e.closest('tr').find(".line-select-from-branch").html(data);
                 //  $("#findModal").modal("show");
                 }
              });
}
function getWarehouse(e){
     $.ajax({
              'type':'post',
              'dataType': 'html',
              'async': false,
              'url': "$url_to_get_warehouse" ,
              'data': {'branch_id': e.val()},
              'success': function(data) {
                  //  alert(data);
                   e.closest('tr').find(".line-select-from-warehouse").html(data);
                 //  $("#findModal").modal("show");
                 }
              });
}
function getBranch2(e){
     $.ajax({
              'type':'post',
              'dataType': 'html',
              'async': false,
              'url': "$url_to_get_branch" ,
              'data': {'company_id': e.val()},
              'success': function(data) {
                  //  alert(data);
                   e.closest('tr').find(".line-select-to-branch").html(data);
                 //  $("#findModal").modal("show");
                 }
              });
}
function getWarehouse2(e){
    //alert(e.val());
     $.ajax({
              'type':'post',
              'dataType': 'html',
              'async': false,
              'url': "$url_to_get_warehouse" ,
              'data': {'branch_id': e.val()},
              'success': function(data) {
                  //  alert(data);
                   e.closest('tr').find(".line-select-to-warehouse").html(data);
                 //  $("#findModal").modal("show");
                 }
              });
}
JS;
$this->registerJs($js, static::POS_END);
?>
