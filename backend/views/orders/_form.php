<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

?>
<div class="orders-form">
    <input type="hidden" class="page-status" data-var="<?= $model->id ?>" value="<?= $model->isNewRecord ? 0 : 1 ?>">
    <?php $form = ActiveForm::begin(['id' => 'order-form', 'method' => 'post']); ?>
    <input type="hidden" class="current_id" value="<?= $model->id ?>">
    <input type="hidden" class="remove-list" name="removelist" value="">
    <div class="row">
        <div class="col-lg-3">
            <?= $form->field($model, 'order_no')->textInput(['value' => $model->isNewRecord ? $model::getLastNo() : $model->order_no, 'readonly' => 'readonly']) ?>
        </div>
        <div class="col-lg-3">
            <?= $form->field($model, 'order_date')->textInput(['value' => date('d/m/Y'), 'id' => 'order-date']) ?>
        </div>
        <div class="col-lg-3">
            <?= $form->field($model, 'order_channel_id')->Widget(\kartik\select2\Select2::className(), [
                'data' => \yii\helpers\ArrayHelper::map(\backend\models\Deliveryroute::find()->all(), 'id', 'name'),
                'options' => [
                    'id' => 'delivery-route-id',
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
            <?= $form->field($model, 'payment_method_id')->Widget(\kartik\select2\Select2::className(), [
                'data' => \yii\helpers\ArrayHelper::map(\backend\models\Paymentmethod::find()->all(), 'id', function ($data) {
                    return $data->name;
                }),
                'options' => [
                    'placeholder' => '--เลือกวิธีชำระเงิน--'
                ]
            ]) ?>
        </div>
        <div class="col-lg-3">
            <?= $form->field($model, 'order_total_amt')->textInput(['readonly' => 'readonly', 'id' => 'order-total-amt']) ?>
        </div>
        <div class="col-lg-3">
            <?= $form->field($model, 'status')->textInput(['readonly' => 'readonly']) ?>
        </div>
    </div>
    <br>
    <h5>รายละเอียดการขาย</h5>
    <hr>
    <table class="table" id="table-sale-list">
        <!--        <thead>-->
        <!--        <tr>-->
        <!--            <th>#</th>-->
        <!--            <th></th>-->
        <!--            <th></th>-->
        <!--            <th></th>-->
        <!--            <th></th>-->
        <!--            <th></th>-->
        <!--            <th></th>-->
        <!--        </tr>-->
        <!--        </thead>-->
        <!--        <tbody>-->
        <!--        </tbody>-->
    </table>
    <br/>
    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
<div class="url-customer" data-url="<?= \yii\helpers\Url::to(['orders/find-saledata'], true) ?>"></div>

<div id="findModal" class="modal fade" role="dialog">
    <div class="modal-dialog modal-lg">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="input-group">
                            <input type="text" class="form-control search-item" placeholder="ค้นหาสินค้า">
                            <span class="input-group-addon">
                                        <button type="submit" class="btn btn-primary btn-search-submit">
                                            <span class="fa fa-search"></span>
                                        </button>
                                    </span>
                        </div>
                    </div>
                    <div class="col-lg-1">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                </div>

            </div>
            <!--            <div class="modal-body" style="white-space:nowrap;overflow-y: auto">-->
            <!--            <div class="modal-body" style="white-space:nowrap;overflow-y: auto;scrollbar-x-position: top">-->

            <div class="modal-body">

                <input type="hidden" name="line_qc_product" class="line_qc_product" value="">
                <table class="table table-bordered table-striped table-find-list" width="100%">
                    <thead>
                    <tr>
                        <th style="text-align: center">เลือก</th>
                        <th>รหัสสินค้า</th>
                        <th>รายละเอียด</th>
                        <th>ต้นทุน</th>
                        <th>ราคาขาย</th>
                    </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
            <div class="modal-footer">
                <button class="btn btn-outline-success btn-product-selected" data-dismiss="modalx" disabled><i
                            class="fa fa-check"></i> ตกลง
                </button>
                <button type="button" class="btn btn-default" data-dismiss="modal"><i
                            class="fa fa-close text-danger"></i> ปิดหน้าต่าง
                </button>
            </div>
        </div>

    </div>
</div>
<?php
$url_to_find_item = \yii\helpers\Url::to(['pricegroup/productdata'], true);
$url_to_get_sale_item = \yii\helpers\Url::to(['orders/find-saledata'], true);
$url_to_get_car_item = \yii\helpers\Url::to(['orders/find-car-data'], true);
$url_to_get_sale_item_update = \yii\helpers\Url::to(['orders/find-saledata-update'], true);
$js = <<<JS
  var removelist = [];
  var selecteditem = [];
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
     
  });
//  function showfind(e){
//      $.ajax({
//              'type':'post',
//              'dataType': 'html',
//              'async': false,
//              'url': "$url_to_find_item",
//              'data': {},
//              'success': function(data) {
//                  //  alert(data);
//                   $(".table-find-list tbody").html(data);
//                   $("#findModal").modal("show");
//                 }
//              });
//      
//  }
//  function addselecteditem(e) {
//        var id = e.attr('data-var');
//        var code = e.closest('tr').find('.line-find-code').val();
//        var name = e.closest('tr').find('.line-find-name').val();
//        var price = e.closest('tr').find('.line-find-price').val();
//        if (id) {
//            if (e.hasClass('btn-outline-success')) {
//                var obj = {};
//                obj['id'] = id;
//                obj['code'] = code;
//                obj['name'] = name;
//                obj['price'] = price;
//                selecteditem.push(obj);
//                
//                e.removeClass('btn-outline-success');
//                e.addClass('btn-success');
//                disableselectitem();
//                console.log(selecteditem);
//            } else {
//                //selecteditem.pop(id);
//                $.each(selecteditem, function (i, el) {
//                    if (this.id == id) {
//                        selecteditem.splice(i, 1);
//                    }
//                });
//                e.removeClass('btn-success');
//                e.addClass('btn-outline-success');
//                disableselectitem();
//                console.log(selecteditem);
//            }
//        }
//    }
//    
//    function check_dup(prod_id){
//      var _has = 0;
//      $("#table-list tbody tr").each(function(){
//          var p_id = $(this).closest('tr').find('.line-prod-id').val();
//         // alert(p_id + " = " + prod_id);
//          if(p_id == prod_id){
//              _has = 1;
//          }
//      });
//      return _has;
//    }
//    
//    function disableselectitem() {
//        if (selecteditem.length > 0) {
//            $(".btn-product-selected").prop("disabled", "");
//            $(".btn-product-selected").removeClass('btn-outline-success');
//            $(".btn-product-selected").addClass('btn-success');
//        } else {
//            $(".btn-product-selected").prop("disabled", "disabled");
//            $(".btn-product-selected").removeClass('btn-success');
//            $(".btn-product-selected").addClass('btn-outline-success');
//        }
//    }
//    $(".btn-product-selected").click(function () {
//        var linenum = 0;
//        if (selecteditem.length > 0) {
//            for (var i = 0; i <= selecteditem.length - 1; i++) {
//                var line_prod_id = selecteditem[i]['id'];
//                var line_prod_code = selecteditem[i]['code'];
//                var line_prod_name = selecteditem[i]['name'];
//                var line_prod_price = selecteditem[i]['price'];
//                
//                 if(check_dup(line_prod_id) == 1){
//                        alert("รายการสินค้า " +line_prod_code+ " มีในรายการแล้ว");
//                        return false;
//                    }
//                
//                var tr = $("#table-list tbody tr:last");
//                
//                if (tr.closest("tr").find(".line-prod-code").val() == "") {
//                    tr.closest("tr").find(".line-prod-id").val(line_prod_id);
//                    tr.closest("tr").find(".line-prod-code").val(line_prod_code);
//                    tr.closest("tr").find("td:eq(2)").html(line_prod_name);
//                    tr.closest("tr").find(".line-qty").val(1);
//                    tr.closest("tr").find(".line-price").val(line_prod_price);
//
//                    //cal_num();
//                    console.log(line_prod_code);
//                } else {
//                   // alert("dd");
//                    console.log(line_prod_code);
//                    //tr.closest("tr").find(".line_code").css({'border-color': ''});
//
//                    var clone = tr.clone();
//                    //clone.find(":text").val("");
//                    // clone.find("td:eq(1)").text("");
//                    clone.find(".line-prod-id").val(line_prod_id);
//                    clone.find(".line-prod-code").val(line_prod_code);
//                    clone.find("td:eq(2)").html(line_prod_name);
//                    clone.find(".line-qty").val(1);
//                    clone.find(".line-price").val(line_prod_price);
//
//                    clone.attr("data-var", "");
//                    clone.find('.rec-id').val("");
//
//                    clone.find(".line-price").on("keypress", function (event) {
//                        $(this).val($(this).val().replace(/[^0-9\.]/g, ""));
//                        if ((event.which != 46 || $(this).val().indexOf(".") != -1) && (event.which < 48 || event.which > 57)) {
//                            event.preventDefault();
//                        }
//                    });
//                    tr.after(clone);
//                }
//            }
//            selecteditem.length = 0;
//        }
//        $("#table-list tbody tr").each(function () {
//            linenum += 1;
//            $(this).closest("tr").find("td:eq(0)").text(linenum);
//            // $(this).closest("tr").find(".line-prod-code").val(line_prod_code);
//        });
//        selecteditem.length = 0;
//
//        $("#table-find-list tbody tr").each(function () {
//            $(this).closest("tr").find(".btn-line-select").removeClass('btn-success');
//            $(this).closest("tr").find(".btn-line-select").addClass('btn-outline-success');
//        });
//        $(".btn-product-selected").removeClass('btn-success');
//        $(".btn-product-selected").addClass('btn-outline-success');
//        
//      //  alert();
//        $("#findModal").modal('hide');
//    });
//  function cal_num(){}
//  function removeline(e) {
//        if (confirm("ต้องการลบรายการนี้ใช่หรือไม่?")) {
//            if (e.parent().parent().attr("data-var") != '') {
//                removelist.push(e.parent().parent().attr("data-var"));
//            }
//            // alert(removelist);
//            $(".remove-list").val(removelist);
//            if ($(".table-list tbody tr").length == 1) {
//                $(".table-list tbody tr").each(function () {
//                    $(this).find(":text").val("");
//                });
//            } else {
//
//                e.parent().parent().remove();
//                cal_linenum();
//            }
//            cal_all();
//        }
//  }
//  function line_cal(e){
//    var line_total = 0;
//  //  $(".table-cart tbody tr").each(function(){
//          var qty = e.closest('tr').find('.line-qty').val();
//          var price = e.closest('tr').find('.line-price').val();
//          line_total = parseFloat(qty) * parseFloat(price);
//        //  alert(price);
//   // });
//    e.closest('tr').find('.line-total-cal').val(line_total);
//     e.closest('tr').find('.line-price-total').val(addCommas(line_total));
//   // e.closest('tr').find('td:eq(5)').html(addCommas(line_total));
//    cal_all();
//}
//  function cal_linenum() {
//        var xline = 0;
//        $(".table-list tbody tr").each(function () {
//            xline += 1;
//            $(this).closest("tr").find("td:eq(0)").text(xline);
//        });
//    }
//
//    function cal_num(e) {
//        var qty = e.closest("tr").find(".line-qty").val();
//        var price = e.closest("tr").find(".line-price").val();
//
//        if (qty == "") {
//            qty = 0;
//        }
//        if (price == "") {
//            price = 0;
//        }
//
//        var total = parseFloat(qty).toFixed(2) * parseFloat(price).toFixed(2);
//       // e.closest("tr").find(".line-total-cal").val(parseFloat(total).toFixed(2));
//
//        e.closest("tr").find(".line-price-total").val("");
//        e.closest("tr").find(".line-price-total").val(addCommas(parseFloat(total).toFixed(2)));
//
//        cal_all();
//  }
//
//   function cal_all() {
//        var totalall = 0;
//        var totalqty = 0;
//        $(".table-list tbody tr").each(function () {
//            var linetotal = $(this).closest("tr").find(".line-total-cal").val();
//            var lineqty = $(this).closest("tr").find(".line-qty").val();
//
//            if (linetotal == '') {
//                linetotal = 0;
//            }
//            if (lineqty == '') {
//                lineqty = 0;
//            }
//
//            totalqty = parseFloat(totalqty) + parseFloat(lineqty);
//            totalall = parseFloat(totalall) + parseFloat(linetotal);
//        });
//        $(".qty-sum").text(parseFloat(totalqty).toFixed(2));
//        $(".total-amount").val(parseFloat(totalall).toFixed(2));
//        
//        $("#order-total-amt").val(parseFloat(totalall).toFixed(0));
//  }

 function route_change(e) {
        //var url_to_show_customer = $(".url-customer").attr('data-url');
          //$.post(url_to_show_customer + "&id=" + e.val(), function (data) {
            //$("select#customer-id").html(data);
           // $("select#customer-id").prop("disabled", "");
           //alert(data);
           //  $("#table-sale-list tbody").html(data);
         //});
         
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
              }
         });
         
 }
 
 function removeorderline(e){
     var cust_line_id = e.closest('tr').find('.line-customer-id').val();
     if(cust_line_id > 0){
         removelist.push(cust_line_id);
         e.parent().parent().remove();
     }
     $(".remove-list").val(removelist);
     
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
                  $("#table-sale-list").html(data);
              }
         });
     }         
     cal_all();
 }
 
 function line_qty_cal(e){
      var row = e.parent().parent();
      var line_total = 0;
      var line_sale_price_total = 0;
      row.find(':input[type=number]').each(function(){
         var qty = parseFloat($(this).val());
         var price = $(this).closest('tr').find('.line-sale-price').val();
         var xqty = 0;
        // alert(qty);
         if(!isNaN(qty)){
             xqty = qty;
         }
         line_total = parseFloat(line_total) + xqty;
         line_sale_price_total = parseFloat(line_sale_price_total) + (xqty * price);
      });
      e.closest("tr").find(".line-qty-cal").val(line_total);
      e.closest("tr").find(".line-total-price").val(line_sale_price_total);
      
      cal_all();
 }
 
   function cal_all() {
       var totalall = 0;
       $("#table-sale-list tr").each(function () {
           var linetotal = $(this).closest("tr").find(".line-total-price").val();
           
           if (linetotal == '' || isNaN(linetotal)) {
               linetotal = 0;
           }
    
           totalall = parseFloat(totalall) + parseFloat(linetotal);
       });
   
       $("#order-total-amt").val(parseFloat(totalall).toFixed(0));
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
