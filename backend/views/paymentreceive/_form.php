<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

$t_date = date('d/m/Y');
?>

<div class="paymentreceive-form">

    <?php $form = ActiveForm::begin(['options' => ['id'=>'form-receive','enctype' => 'multipart/form-data']]); ?>
    <input type="hidden" name="removelist" class="remove-list" value="">
    <div class="row">
        <div class="col-lg-4">
            <?= $form->field($model, 'journal_no')->textInput(['maxlength' => true, 'readonly' => 'readonly']) ?>
        </div>
        <div class="col-lg-4">
            <?php $model->trans_date = $model->isNewRecord ? $t_date : date('d/m/Y', strtotime($model->trans_date)); ?>
            <?= $form->field($model, 'trans_date')->widget(\kartik\date\DatePicker::className(), [
                'pluginOptions' => [
                    'format' => 'dd/mm/yyyy',
                    'todayHighlight' => true
                ]
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
                  <?php if($model_line != null):?>
                  <?php $i=0;?>
                     <?php foreach ($model_line as $value):?>
                          <?php
                             $i+=1;
                             $order_date = \backend\models\Orders::getOrderdate($value->order_id);
                          ?>
                         <tr data-id="<?=$value->id?>">
                              <td style="text-align: center"><?= $i?></td>
                              <td style="text-align: center"><?= \backend\models\Orders::getNumber($value->order_id)?></td>
                              <td style="text-align: center"><?= date('d/m/Y', strtotime($order_date)) ?></td>
                              <td>
                                  <select name="line_pay_type[]" id=""  class="form-control" onchange="checkpaytype($(this))">
                                      <option value="0">เงินสด</option>
                                      <option value="1">โอนธนาคาร</option>
                                  </select>
                                  <input type="file" class="line-doc" name="line_doc[]" style="display: none">
                                  <input type="hidden" class="line-order-id" name="line_order_id[]" value="<?=$value->order_id ?>">
                                  <input type="hidden" class="line-number" name="line_number[]" value="<?=($i-1)?>">
                                  <input type="hidden" class="line-id" name="line_id[]" value="<?=$value->id?>">
                              </td>
                              <td>
                                  <input type="text" class="form-control line-remain" style="text-align: right" name="line_remain[]" value="<?= number_format($value->remain_amount, 2) ?>" readonly>
                                  <input type="hidden" class="line-remain-qty" value="<?=$value->remain_amount?>">
                              </td>
                              <td>
                                  <input type="number" class="form-control line-pay" name="line_pay[]" value="" onchange="linepaychange($(this))">
                              </td>
                           </tr>
                     <?php endforeach;?>
                 <?php endif;?>
                </tbody>
            </table>
        </div>
    </div>

    <div class="form-group show-save" style="display: none">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>


<?php
$url_to_get_receive = \yii\helpers\Url::to(['paymentreceive/getitem'], true);
$js = <<<JS
var removelist = [];
var selecteditem = [];
$(function(){
   
});

function linepaychange(e){
   // alert();
    var remain_amount = e.closest('tr').find('.line-remain-qty').val();
    var pay = e.val();
    
    if((int)pay > (int)remain_amount){
        alert('ชำระเงินมากกว่ายอดค้างชำระ');
        e.val(remain_amount);
        e.focus();
        return false;
    }
    calpayment();
}

function calpayment(){
    var pay_total = 0;
    $(".table-list tbody tr").each(function(){
         var x = $(this).closest('tr').find('.line-pay').val();
         x = x == null? 0 : parseFloat(x);
         pay_total = parseFloat(pay_total) + parseFloat(x);
    });
    
}

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
                   if(data != ''){
                       $(".show-save").show();
                   }else{
                       $(".show-save").hide();
                   }
                   $(".table-list tbody").html(data);
                 }
              });
    }
}
function checkpaytype(e){
    var type_ = e.val();
    if(type_ == 1){
         e.closest('tr').find('.line-doc').trigger('click');
    }
   
    
}

function cal_linenum() {
        var xline = 0;
        $("#table-list tbody tr").each(function () {
            xline += 1;
            $(this).closest("tr").find("td:eq(0)").text(xline);
        });
    }
    function removeline(e) {
        if (confirm("ต้องการลบรายการนี้ใช่หรือไม่?")) {
            if (e.parent().parent().attr("data-var") != '') {
                removelist.push(e.parent().parent().attr("data-var"));
                $(".remove-list").val(removelist);
            }
            // alert(removelist);

            if ($("#table-list tbody tr").length == 1) {
                $("#table-list tbody tr").each(function () {
                    $(this).find(":text").val("");
                   // $(this).find(".line-prod-photo").attr('src', '');
                    $(this).find(".line-price").val(0);
                    cal_num();
                });
            } else {
                e.parent().parent().remove();
            }
            cal_linenum();
           // cal_all();
        }
    }

JS;

$this->registerJs($js, static::POS_END);
?>
