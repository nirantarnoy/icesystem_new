<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

?>
<div class="orders-form">
    <input type="hidden" class="page-status" data-var="<?= $model->id ?>" value="<?= $model->isNewRecord ? 0 : 1 ?>">
    <?php $form = ActiveForm::begin(['id' => 'order-form', 'method' => 'post']); ?>
    <input type="hidden" class="current_id" value="<?= $model->id ?>">
    <input type="hidden" class="current-price-group" value="">
    <input type="hidden" class="remove-list" name="removelist" value="">
    <div class="row">
        <div class="col-lg-3">
            <?= $form->field($model, 'order_no')->textInput(['value' => $model->isNewRecord ? $model::getLastNo() : $model->order_no, 'readonly' => 'readonly']) ?>
        </div>
        <div class="col-lg-3">
            <?= $form->field($model, 'order_date')->textInput(['value' => date('d/m/Y'), 'id' => 'order-date']) ?>
        </div>
        <div class="col-lg-3">
            <?php
            $x_disabled = !$model->isNewRecord ? "disabled" : '';

            ?>
            <?= $form->field($model, 'order_channel_id')->Widget(\kartik\select2\Select2::className(), [
                'data' => \yii\helpers\ArrayHelper::map(\backend\models\Deliveryroute::find()->all(), 'id', 'name'),
                'options' => [
                    'id' => 'delivery-route-id',
                    'readonly' => 'readonly',
                    'placeholder' => '--เลือกสายส่ง--',
                    'onchange' => '
                           route_change($(this));
                        '
                ]
            ]) ?>
        </div>
        <div class="col-lg-3">
            <?= $form->field($model, 'car_ref_id')->Widget(\kartik\select2\Select2::className(), [
                'data' => \yii\helpers\ArrayHelper::map(\backend\models\Car::find()->all(), 'id', 'name'),
                'options' => [
                    'id' => 'car-ref-id',
                    'disabled' => 'disabled',
                    'onchange' => 'getcaremp($(this));',
                    'placeholder' => '--เลือกรถขาย--'
                ]
            ]) ?>
        </div>
        <!--            <div class="col-lg-3">-->
        <!--                --><?php ////echo $form->field($model, 'customer_id')->Widget(\kartik\select2\Select2::className(), [
        //                    'data' => \yii\helpers\ArrayHelper::map(\backend\models\Customer::find()->all(), 'id', 'name'),
        //                    'options' => [
        //                        'id' => 'customer-id',
        //                        'placeholder' => '--เลือกลูกค้า--'
        //                    ]
        //                ]) ?>
    </div>

    <div class="row">
        <div class="col-lg-3">
            <?= $form->field($model, 'order_total_amt_text')->textInput(['readonly' => 'readonly', 'id' => 'order-total-amt-text'])->label('ยอดขาย') ?>
        </div>
        <div class="col-lg-3">
            <?= $form->field($model, 'status')->textInput(['readonly' => 'readonly', 'value' => $model->isNewRecord ? 'Open' : \backend\helpers\OrderStatus::getTypeById($model->status)]) ?>
        </div>
    </div>
    <br>
    <?php
    $get_emp_show = \backend\models\Orders::findOrderemp($model->id);
    ?>
    <div class="row">
        <div class="col-lg-10">
            <h5>รายละเอียดการขาย <span class="badge badge-info text-car-emp"><?= $get_emp_show; ?></span></h5>
        </div>
        <div class="col-lg-2" style="text-align: right">
            <div class="btn btn-primary btn-payment" style="display: none"><span class="count-selected"></span>บันทึกชำระเงิน
            </div>
        </div>
    </div>

    <hr>
    <div class="list-detail">

    </div>
    <br/>
    <?= $form->field($model, 'order_total_amt')->hiddenInput(['readonly' => 'readonly', 'id' => 'order-total-amt'])->label(false) ?>
    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
<div class="url-customer" data-url="<?= \yii\helpers\Url::to(['orders/find-saledata'], true) ?>"></div>

<div id="paymentModal" class="modal fade" role="dialog">
    <div class="modal-dialog modal-xl">
        <!-- Modal content-->
        <form id="form-payment" action="<?= \yii\helpers\Url::to(['orders/addpayment'], true) ?>" method="post">
            <input type="hidden" class="payment-order-id" name="payment_order_id" value="<?= $model->id ?>">
            <div class="modal-content">
                <div class="modal-header">
                    <div class="row" style="width: 100%">
                        <div class="col-lg-11">
                            <h2 style="color: #255985"><i class="fa fa-coins"></i> บันทึกชำระเงิน</h2>
                        </div>
                        <div class="col-lg-1">
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                        </div>
                    </div>

                </div>
                <!--            <div class="modal-body" style="white-space:nowrap;overflow-y: auto">-->
                <!--            <div class="modal-body" style="white-space:nowrap;overflow-y: auto;scrollbar-x-position: top">-->

                <div class="modal-body">
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="label">วันที่</div>
                            <?php
                            echo \kartik\date\DatePicker::widget([
                                'name' => 'payment_date',
                                'value' => date('d/m/Y'),
                                'options' => [
                                    // 'readonly' => true,
                                ],
                                'pluginOptions' => [
                                    'format' => 'dd/mm/yyyy',
                                    'todayHighlight' => true
                                ],
                            ]);
                            ?>
                        </div>
                        <div class="col-lg-6">
                            <div class="label">เวลา</div>
                            <?php
                            echo \kartik\time\TimePicker::widget([
                                'name' => 'payment_time',
                                'options' => [
                                    //'readonly' => true,
                                ],
                                'pluginOptions' => [
                                    'showSeconds' => false,
                                    'showMeridian' => false,
                                    'minuteStep' => 1,
                                    'secondStep' => 5,
                                ]
                            ]);
                            ?>
                        </div>
                    </div>
                    <br>
                    <div class="row">
                        <div class="col-lg-12">
                            <table class="table table-striped table-bordered table-payment-list">
                                <thead>
                                <tr>
                                    <th>รหัสลูกค้า</th>
                                    <th>ชื่อลูกค้า</th>
                                    <th>ยอดขาย</th>
                                    <th>วิธีชำระเงิน</th>
                                    <th>เงื่อนไข</th>
                                    <th>ยอดชำระ</th>
                                    <th>คงค้าง</th>
                                    <th style="text-align: center">-</th>
                                </tr>
                                </thead>
                                <tbody>

                                </tbody>
                            </table>
                        </div>
                    </div>

                </div>
                <div class="modal-footer">
                    <button class="btn btn-outline-success btn-paymet-submit" data-dismiss="modalx"><i
                                class="fa fa-check"></i> ตกลง
                    </button>
                    <button type="button" class="btn btn-default" data-dismiss="modal"><i
                                class="fa fa-close text-danger"></i> ปิดหน้าต่าง
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>
<?php
$url_to_find_item = \yii\helpers\Url::to(['pricegroup/productdata'], true);
$url_to_get_sale_item = \yii\helpers\Url::to(['orders/find-saledata'], true);
$url_to_get_price_group = \yii\helpers\Url::to(['orders/find-pricegroup'], true);
$url_to_get_car_item = \yii\helpers\Url::to(['orders/find-car-data'], true);
$url_to_get_sale_item_update = \yii\helpers\Url::to(['orders/find-saledata-update'], true);
$url_to_get_car_emp = \yii\helpers\Url::to(['orders/findcarempdaily'], true);
$url_to_get_term_item = \yii\helpers\Url::to(['orders/find-term-data'], true);
$url_to_get_payment_list = \yii\helpers\Url::to(['orders/find-payment-list'], true);
$url_to_get_condition = \yii\helpers\Url::to(['orders/getpaycondition'], true);
$js = <<<JS
  var removelist = [];
  var selecteditem = [];
  var checkeditem = [];
  var current_row = 0;
  $(function(){
     $("#order-date").datepicker({
       'format':'dd/mm/yyyy'
     });

     $(".line_qty,.line_price").on("keypress", function (event) {
            $(this).val($(this).val().replace(/[^0-9\.]/g, ""));
            if ((event.which != 46 || $(this).val().indexOf(".") != -1) && (event.which < 48 || event.which > 57)) {
                event.preventDefault();
            }
     });

     var page_status = $(".page-status").val();
     if(page_status == 1){
         var ids = $(".page-status").attr("data-var");
         order_update_data(ids);
     }
     cal_all();
     
     $(".btn-payment").click(function(){
          var ids = $(".current_id").val();
          var price_group = $(".current-price-group").val();
          alert(checkeditem.length);
          if(checkeditem.length > 0 && ids >0){
              $.ajax({
              'type':'post',
              'dataType': 'html',
              'async': false,
              'url': "$url_to_get_payment_list",
              'data': {'order_id': checkeditem, 'id': ids, 'price_group_id': price_group},
              'success': function(data) {
                  //  alert(data);
                   $(".table-payment-list tbody").html(data);
                  $("#paymentModal").modal("show"); 
                 }
              });
          }
     });
     
     $(".btn-paymet-submit").click(function(){
        if(confirm('คุณมันใจที่จะทำรายการนี้ใช่หรือไม่ ?')){
            $("form#form-payment").submit();
        } 
     });
     
  });

 function getCondition(e){
     var ids = e.val();
     if(ids){
        // alert(ids);
         $.ajax({
              'type':'post',
              'dataType': 'html',
              'async': false,
              'url': "$url_to_get_condition",
              'data': {'id': ids},
              'success': function(data) {
                   e.closest('tr').find(".select-condition").html(data);
              }
         });
     }
 }
 function route_change(e) {
        //var url_to_show_customer = $(".url-customer").attr('data-url');
          //$.post(url_to_show_customer + "&id=" + e.val(), function (data) {
            //$("select#customer-id").html(data);
           // $("select#customer-id").prop("disabled", "");
           //alert(data);
           //  $("#table-sale-list tbody").html(data);
         //});
         $(".text-car-emp").html("");
         $.ajax({
              'type':'post',
              'dataType': 'html',
              'async': false,
              'url': "$url_to_get_price_group",
              'data': {'route_id': e.val()},
              'success': function(data) {
                  $(".list-detail").html(data);
              }
         });
         
          $.ajax({
              'type':'post',
              'dataType': 'html',
              'async': false,
              'url': "$url_to_get_sale_item",
              'data': {'id': e.val()},
              'success': function(data) {
                  $("#table-sale-list").html(data);
              }
         });

         $.ajax({
              'type':'post',
              'dataType': 'html',
              'async': false,
              'url': "$url_to_get_car_item",
              'data': {'id': e.val()},
              'success': function(data) {
                 // alert();
                 $("#car-ref-id").html(data);
                 $("#car-ref-id").prop("disabled","");
              }
         });

 }
 
 function getPaymentterm(e){
     $.ajax({
              'type':'post',
              'dataType': 'html',
              'async': false,
              'url': "$url_to_get_term_item",
              'data': {'id': e.val()},
              'success': function(data) {
                 // alert();
                 $("#payment-term-id").html(data);
                // $("#car-ref-id").prop("disabled","");
              }
         });
 }

 function removeorderline(e){
     //var cust_line_id = e.closest('tr').find('.line-customer-id').val();
    var recid = e.attr("data-var");
     if(recid > 0){
         alert(recid);
         removelist.push(recid);
         e.parent().parent().remove();
     }
     $(".remove-list").val(removelist);
     cal_all();
 }

 function order_update_data(ids) {
     if(ids !='' || ids > 0){
               $.ajax({
              'type':'post',
              'dataType': 'html',
              'async': false,
              'url': "$url_to_get_sale_item_update",
              'data': {'id': ids},
              'success': function(data) {
                  //alert(data);
                  $(".list-detail").html(data);
              }
         });
     }
     cal_all();
 }

 function line_qty_cal(e){
      var row = e.parent().parent();
     // var line_price = e.attr('data-var');
      var line_total = 0;
      var line_sale_price_total = 0;
      row.find(':input[type=number]').each(function(){
         var qty = parseFloat($(this).val());
         var price = $(this).attr('data-var');
         var xqty = 0;
        // alert(qty);
         if(!isNaN(qty)){
             xqty = qty;
         }
         line_total = parseFloat(line_total) + xqty;
         line_sale_price_total = parseFloat(line_sale_price_total) + (xqty * price);
      });
     // alert(e.val());
      if(e.val()>0){
           e.css('background-color', '#33CC00');
           e.css('color', 'black');
      }else{
           e.css('background-color', 'white');
           e.css('color', 'black');
      }
      e.closest("tr").find(".line-qty-cal").val(line_total);
      e.closest("tr").find(".line-total-price").val(line_sale_price_total);
      e.closest("tr").find(".line-total-price-cal").val(line_sale_price_total);

      cal_all();
 }

   function cal_all() {
       var totalall = 0;
       $("#table-sale-list tr").each(function () {
           var linetotal = $(this).closest("tr").find(".line-total-price-cal").val();
           if (linetotal == '' || isNaN(linetotal)) {
               linetotal = 0;
           }
           totalall = parseFloat(totalall) + parseFloat(linetotal);
       });

       $("#order-total-amt").val(parseFloat(totalall).toFixed(0));
       $("#order-total-amt-text").val(addCommas(parseFloat(totalall).toFixed(0)));
 }

 function getcaremp(e){
   var ids = e.val();
   var trans_date = $("#order-date").val();
   //alert(trans_date);
   if(ids){
               $.ajax({
              'type':'post',
              'dataType': 'html',
              'async': false,
              'url': "$url_to_get_car_emp",
              'data': {'id': ids,'order_date': trans_date},
              'success': function(data) {
                  // alert(data);
                  if(data == ''){
                      $(".text-car-emp").removeClass('badge-info');
                      $(".text-car-emp").addClass('badge-danger');
                      $(".text-car-emp").html('ไม่พบรายชื่อพนักงาน');
                  }else{
                      $(".text-car-emp").html(data);
                  }
              }
         });
   }
 }
 
   function updatetab(e){
     checkeditem = [];
     var ids = e.attr('data-var');
     $(".current-price-group").val(ids);
   }
   
   function showselectpayment(e){
        var table_id = e.parent().parent().parent().parent().attr('id');
        var cnt = 0;
        var cnt_selected = 0;
        var cur_id = e.attr('data-var');
       // alert(table_id);
        if(typeof(table_id) != 'undefined'){
               var all_checkbox = $("#"+table_id+ " tbody input[type=checkbox]").length;
               var cnt_selected = $("#"+table_id+" tbody input:checked").length;
               if(all_checkbox == cnt_selected){
                   $(".selected-all-item").prop('checked',true);
                   $("#"+table_id+ " tbody input[type=checkbox]").each(function(){
                      $(this).prop('checked',true);
                   //   checkeditem.push($(this).attr('data-var'));
                   });
               }else{
                   // $(".selected-all-item").prop('checked',false);
                   // $("#"+table_id+ " tbody input[type=checkbox]").each(function(){
                   //    $(this).prop('checked',false);
                   //    var index = checkeditem.indexOf($(this).attr('data-var'));
                   //    if (index !== -1) {
                   //        checkeditem.splice(index, 1);
                   //    }
                   // });
               }
               
               if(cnt_selected > 0){
                 $('.count-selected').html("["+cnt_selected+"] ");   
               }else{
                 $('.count-selected').html("");   
               }
               
               console.log(checkeditem);
               checkeditem = [];
               $("#"+table_id+ " tbody input[type=checkbox]").each(function(){
                    if(this.checked){
                       // if(cur_id != $(this).attr('data-var')){
                          //   alert($(this).attr('data-var'));
                            checkeditem.push($(this).attr('data-var'));
                       // }
                    }else{
                        // var index = checkeditem.indexOf($(this).attr('data-var'));
                        // if (index !== -1) {
                        //     checkeditem.splice(index, 1);
                        // }
                    }
                          
                });
           $('.btn-payment').show();
        }
        
    }
    
    function showselectpaymentall(e){
        var table_id = e.parent().parent().parent().parent().attr('id');
        var cnt = 0;
        var cnt_selected = 0;
        if(typeof(table_id) != 'undefined'){
            var all_checkbox = $("#"+table_id+ " tbody input[type=checkbox]").length;
            var cnt_selected = $("#"+table_id+" tbody input:checked").length;
            if(cnt_selected > 0){
                if(all_checkbox != cnt_selected){
                    //alert();
                     $("#"+table_id+ " tbody input[type=checkbox]").each(function(){
                        $(this).prop('checked',true);
                     });
                }else{
                     $("#"+table_id+ " tbody input[type=checkbox]").each(function(){
                        $(this).prop('checked',false);
                     });
                }
               
            }else{
                $("#"+table_id+ " tbody input[type=checkbox]").each(function(){
                      $(this).prop('checked',true);
                });
            }
        }
        
        $("#"+table_id+ " tbody input[type=checkbox]").each(function(){
            if(this.checked){
                // alert($(this).attr('data-var'));
                checkeditem.push($(this).attr('data-var'));
            }else{
                var index = checkeditem.indexOf($(this).attr('data-var'));
                if (index !== -1) {
                    checkeditem.splice(index, 1);
                }
            }
                  
        });
        
        if(checkeditem.length > 0){
            $('.count-selected').html("["+checkeditem.length+"] ");
            $('.btn-payment').show();
        }else{
            $('.count-selected').html("");   
            $('.btn-payment').hide();
        }
        
    }
 
function addCommas(nStr) {
        nStr += '';
        var x = nStr.split('.');
        var x1 = x[0];
        var x2 = x.length > 1 ? '.' + x[1] : '';
        var rgx = /(\d+)(\d{3})/;
        while (rgx.test(x1)) {
            x1 = x1.replace(rgx, '$1' + ',' + '$2');
        }
        return x1 + x2;
 }
JS;
$this->registerJs($js, static::POS_END);
?>
