<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\Orders */
/* @var $form yii\widgets\ActiveForm */
?>

    <div class="orders-form">

        <?php $form = ActiveForm::begin(); ?>
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
                <?= $form->field($model, 'customer_id')->Widget(\kartik\select2\Select2::className(), [
                    'data' => \yii\helpers\ArrayHelper::map(\backend\models\Customer::find()->all(), 'id', 'name'),
                    'options' => [
                        'id' => 'customer-id',
                        'placeholder' => '--เลือกลูกค้า--'
                    ]
                ]) ?>
            </div>

        </div>
        <div class="row">
            <div class="col-lg-3">
                <?= $form->field($model, 'car_ref_id')->Widget(\kartik\select2\Select2::className(), [
                    'data' => \yii\helpers\ArrayHelper::map(\backend\models\Car::find()->all(), 'id', 'name'),
                    'options' => [
                        'placeholder' => '--เลือกรถขาย--'
                    ]
                ]) ?>
            </div>
            <div class="col-lg-3">
                <?= $form->field($model, 'emp_sale_id')->Widget(\kartik\select2\Select2::className(), [
                    'data' => \yii\helpers\ArrayHelper::map(\backend\models\Employee::find()->all(), 'id', 'name'),
                    'options' => [
                        'placeholder' => '--เลือกพนักงานขาย--'
                    ]
                ]) ?>
            </div>

            <div class="col-lg-3">
                <?= $form->field($model, 'order_total_amt')->textInput(['readonly' => 'readonly']) ?>
            </div>
            <div class="col-lg-3">
                <?= $form->field($model, 'status')->textInput(['readonly' => 'readonly']) ?>
            </div>
        </div>
        <br>
        <h5>รายการสินค้า</h5>
        <table class="table table-bordered table-striped table-list" id="table-list">
            <thead>
            <tr>
                <th style="width: 5%;text-align: center">#</th>
                <th style="width: 15%">รหัสสินค้า</th>
                <th>ชื่อสินค้า</th>
                <th style="text-align: right;width: 15%">จำนวน</th>
                <th style="text-align: right;width: 15%">ราคา</th>
                <th style="text-align: right;width: 15%">รวม</th>
                <th style="width: 5%;text-align: center">-</th>
            </tr>
            </thead>
            <tbody>
            <?php if ($model->isNewRecord): ?>
                <tr>
                    <td style="text-align: center"></td>
                    <td>
                        <input type="hidden" class="line-prod-id" name="product_id[]" value="">
                        <input type="text" class="form-control line-prod-code" value="">
                    </td>
                    <td style="vertical-align: middle"></td>
                    <td>
                        <input type="number" class="form-control line-qty" name="line_qty[]" value="" min="0" style="text-align: right">
                    </td>
                    <td>
                        <input type="text" class="form-control line-price" name="line_price[]" value="" style="text-align: right">
                    </td>
                    <td>
                        <input type="text" class="form-control line-price-total" name="line_price_total[]" readonly
                               value="" style="text-align: right" style="text-align: right">
                    </td>
                    <td style="text-align: center">
                        <div class="btn btn-danger btn-sm" onclick="removeline($(this))"><i class="fa fa-trash"></i>
                        </div>
                    </td>
                </tr>
            <?php else: ?>
                <?php if ($model_line != null): ?>
                <?php $x = 0;?>
                    <?php foreach($model_line as $value):?>
                    <?php $x+=1;?>
                        <tr>
                            <td style="text-align: center"><?=$x?></td>
                            <td>
                                <input type="hidden" class="line-rec-id" name="line_rec_id" value="<?=$value->id?>">
                                <input type="hidden" class="line-prod-id" name="product_id[]" value="<?=$value->product_id?>">
                                <input type="text" class="form-control line-prod-code" value="<?=\backend\models\Product::findCode($value->product_id)?>">
                            </td>
                            <td style="vertical-align: middle"><?=\backend\models\Product::findName($value->product_id)?></td>
                            <td>
                                <input type="number" class="form-control line-qty" name="line_qty[]" value="<?=$value->qty?>" min="0" style="text-align: right">
                            </td>
                            <td>
                                <input type="text" class="form-control line-price" name="line_price[]" value="<?=$value->price?>" style="text-align: right">
                            </td>
                            <td>
                                <input type="text" class="form-control line-price-total" name="line_price_total[]" readonly
                                       value="" style="text-align: right" style="text-align: right">
                            </td>
                            <td style="text-align: center">
                                <div class="btn btn-danger btn-sm" onclick="removeline($(this))"><i class="fa fa-trash"></i>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach;?>
                <?php else: ?>
                    <tr>
                        <td style="text-align: center"></td>
                        <td>
                            <input type="hidden" class="line-prod-id" name="product_id[]" value="">
                            <input type="text" class="form-control line-prod-code" value="">
                        </td>
                        <td style="vertical-align: middle"></td>
                        <td>
                            <input type="number" class="form-control line-qty" name="line_qty[]" value="" min="0" style="text-align: right">
                        </td>
                        <td>
                            <input type="text" class="form-control line-price" name="line_price[]" value="" style="text-align: right">
                        </td>
                        <td>
                            <input type="text" class="form-control line-price-total" name="line_price_total[]" readonly
                                   value="" style="text-align: right" style="text-align: right">
                        </td>
                        <td style="text-align: center">
                            <div class="btn btn-danger btn-sm" onclick="removeline($(this))"><i class="fa fa-trash"></i>
                            </div>
                        </td>
                    </tr>
                <?php endif; ?>
            <?php endif; ?>
            </tbody>
        </table>
        <div class="btn btn-primary" onclick="showfind($(this))"><i class="fa fa-plus-circle"></i></div>
        <hr>
        <div class="form-group">
            <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success']) ?>
        </div>

        <?php ActiveForm::end(); ?>

    </div>
    <div class="url-customer" data-url="<?= \yii\helpers\Url::to(['orders/find-customer'], true) ?>"></div>

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
  });
  function showfind(e){
      $.ajax({
              'type':'post',
              'dataType': 'html',
              'async': false,
              'url': "$url_to_find_item",
              'data': {},
              'success': function(data) {
                  //  alert(data);
                   $(".table-find-list tbody").html(data);
                   $("#findModal").modal("show");
                 }
              });
      
  }
  function addselecteditem(e) {
        var id = e.attr('data-var');
        var code = e.closest('tr').find('.line-find-code').val();
        var name = e.closest('tr').find('.line-find-name').val();
        var price = e.closest('tr').find('.line-find-price').val();
        if (id) {
            if (e.hasClass('btn-outline-success')) {
                var obj = {};
                obj['id'] = id;
                obj['code'] = code;
                obj['name'] = name;
                obj['price'] = price;
                selecteditem.push(obj);
                
                e.removeClass('btn-outline-success');
                e.addClass('btn-success');
                disableselectitem();
                console.log(selecteditem);
            } else {
                //selecteditem.pop(id);
                $.each(selecteditem, function (i, el) {
                    if (this.id == id) {
                        selecteditem.splice(i, 1);
                    }
                });
                e.removeClass('btn-success');
                e.addClass('btn-outline-success');
                disableselectitem();
                console.log(selecteditem);
            }
        }
    }
    
    function check_dup(prod_id){
      var _has = 0;
      $("#table-list tbody tr").each(function(){
          var p_id = $(this).closest('tr').find('.line-prod-id').val();
         // alert(p_id + " = " + prod_id);
          if(p_id == prod_id){
              _has = 1;
          }
      });
      return _has;
    }
    
    function disableselectitem() {
        if (selecteditem.length > 0) {
            $(".btn-product-selected").prop("disabled", "");
            $(".btn-product-selected").removeClass('btn-outline-success');
            $(".btn-product-selected").addClass('btn-success');
        } else {
            $(".btn-product-selected").prop("disabled", "disabled");
            $(".btn-product-selected").removeClass('btn-success');
            $(".btn-product-selected").addClass('btn-outline-success');
        }
    }
    $(".btn-product-selected").click(function () {
        var linenum = 0;
        if (selecteditem.length > 0) {
            for (var i = 0; i <= selecteditem.length - 1; i++) {
                var line_prod_id = selecteditem[i]['id'];
                var line_prod_code = selecteditem[i]['code'];
                var line_prod_name = selecteditem[i]['name'];
                var line_prod_price = selecteditem[i]['price'];
                
                 if(check_dup(line_prod_id) == 1){
                        alert("รายการสินค้า " +line_prod_code+ " มีในรายการแล้ว");
                        return false;
                    }
                
                var tr = $("#table-list tbody tr:last");
                
                if (tr.closest("tr").find(".line-prod-code").val() == "") {
                    tr.closest("tr").find(".line-prod-id").val(line_prod_id);
                    tr.closest("tr").find(".line-prod-code").val(line_prod_code);
                    tr.closest("tr").find("td:eq(2)").html(line_prod_name);
                    tr.closest("tr").find(".line-qty").val(1);
                    tr.closest("tr").find(".line-price").val(line_prod_price);

                    //cal_num();
                    console.log(line_prod_code);
                } else {
                   // alert("dd");
                    console.log(line_prod_code);
                    //tr.closest("tr").find(".line_code").css({'border-color': ''});

                    var clone = tr.clone();
                    //clone.find(":text").val("");
                    // clone.find("td:eq(1)").text("");
                    clone.find(".line-prod-id").val(line_prod_id);
                    clone.find(".line-prod-code").val(line_prod_code);
                    clone.find("td:eq(2)").html(line_prod_name);
                    clone.find(".line-qty").val(1);
                    clone.find(".line-price").val(line_prod_price);

                    clone.attr("data-var", "");
                    clone.find('.rec-id').val("");

                    clone.find(".line-price").on("keypress", function (event) {
                        $(this).val($(this).val().replace(/[^0-9\.]/g, ""));
                        if ((event.which != 46 || $(this).val().indexOf(".") != -1) && (event.which < 48 || event.which > 57)) {
                            event.preventDefault();
                        }
                    });
                    tr.after(clone);
                }
            }
            selecteditem.length = 0;
        }
        $("#table-list tbody tr").each(function () {
            linenum += 1;
            $(this).closest("tr").find("td:eq(0)").text(linenum);
            // $(this).closest("tr").find(".line-prod-code").val(line_prod_code);
        });
        selecteditem.length = 0;

        $("#table-find-list tbody tr").each(function () {
            $(this).closest("tr").find(".btn-line-select").removeClass('btn-success');
            $(this).closest("tr").find(".btn-line-select").addClass('btn-outline-success');
        });
        $(".btn-product-selected").removeClass('btn-success');
        $(".btn-product-selected").addClass('btn-outline-success');
        
      //  alert();
        $("#findModal").modal('hide');
    });
  function cal_num(){}
  function removeline(e) {
        if (confirm("ต้องการลบรายการนี้ใช่หรือไม่?")) {
            if (e.parent().parent().attr("data-var") != '') {
                removelist.push(e.parent().parent().attr("data-var"));
            }
            // alert(removelist);
            $(".remove-list").val(removelist);
            if ($(".table-list tbody tr").length == 1) {
                $(".table-list tbody tr").each(function () {
                    $(this).find(":text").val("");
                });
            } else {

                e.parent().parent().remove();
                cal_linenum();
            }
            cal_all();
        }
  }
  function cal_linenum() {
        var xline = 0;
        $(".table-list tbody tr").each(function () {
            xline += 1;
            $(this).closest("tr").find("td:eq(0)").text(xline);
        });
    }

    function cal_num(e) {
        var qty = e.closest("tr").find(".line-qty").val();
        var price = e.closest("tr").find(".line-price").val();

        if (qty == "") {
            qty = 0;
        }
        if (price == "") {
            price = 0;
        }

        var total = parseFloat(qty).toFixed(2) * parseFloat(price).toFixed(2);
        e.closest("tr").find(".line-total-cal").val(parseFloat(total).toFixed(2));

        e.closest("tr").find(".line-total").val("");
        e.closest("tr").find(".line-total").val(addCommas(parseFloat(total).toFixed(2)));

        cal_all();
  }

   function cal_all() {
        var totalall = 0;
        var totalqty = 0;
        $(".table-list tbody tr").each(function () {
            var linetotal = $(this).closest("tr").find(".line-total-cal").val();
            var lineqty = $(this).closest("tr").find(".line-qty").val();

            if (linetotal == '') {
                linetotal = 0;
            }
            if (lineqty == '') {
                lineqty = 0;
            }

            totalqty = parseFloat(totalqty) + parseFloat(lineqty);
            totalall = parseFloat(totalall) + parseFloat(linetotal);
        });
        $(".qty-sum").text(parseFloat(totalqty).toFixed(2));
        $(".total-amount").val(parseFloat(totalall).toFixed(2));
  }
 function route_change(e) {
        var url_to_show_customer = $(".url-customer").attr('data-url');
        $.post(url_to_show_customer + "&id=" + e.val(), function (data) {
            $("select#customer-id").html(data);
            $("select#customer-id").prop("disabled", "");
        });
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