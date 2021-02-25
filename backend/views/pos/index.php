<?php

use kartik\select2\Select2;
use yii\helpers\ArrayHelper;

$this->title = '<p style="color: #255985">ทำรายการขายหน้าร้าน POS</p>';

?>
<div class="row">
    <div class="col-lg-6" style="border-right: 1px dashed gray ">
        <div class="row">
            <div class="col-lg-12">
                <h5><i class="fa fa-cubes"></i> รายการสินค้า</h5>
            </div>
        </div>
        <hr style="border-top: 1px dashed gray">
        <div class="row">
            <div class="col-lg-8">
                <div class="btn btn-group group-customer-type">
                    <button class="btn btn-outline-secondary btn-sm" disabled>ประเภทลูกค้า</button>
                    <button id="btn-general-customer" class="btn btn-success btn-sm active">ลูกค้าทั่วไป</button>
                    <button id="btn-fix-customer" class="btn btn-outline-secondary btn-sm">ระบุลูกค้า</button>
                </div>
            </div>
            <div class="col-lg-4" style="text-align: right;">
                <span style="font-size: 20px;display: none;" class="text-price-type"><div
                            class="badge badge-primary badge-text-price-type"
                            style="vertical-align: middle"></div></span>
            </div>
        </div>
        <div class="row div-customer-search" style="display: none;">
            <div class="col-lg-6">
                <div class="input-group" style="margin-left: 10px;">
                    <!--                    <input type="text" class="form-control find-customer" value="">-->
                    <?php echo Select2::widget([
                        'name' => 'customer_id',
                        'value' => 1,
                        'data' => ArrayHelper::map(\backend\models\Customer::find()->all(), 'id', function ($data) {
                            return $data->code . ' ' . $data->name;
                        }),
                        'options' => [
                            'placeholder' => '--เลือกลูกค้า--',
                            'onchange' => 'getproduct_price($(this))'
                        ],
                        'pluginOptions' => [
                            'allowClear' => true
                        ]
                    ]);
                    ?>
                    <!--                    <button class="btn btn-primary"><i class="fa fa-search"></i></button>-->
                </div>
            </div>
        </div>
        <br/>
        <div class="row">
            <div class="col-lg-12" style="overflow-x: hidden">
                <div class="row">
                    <?php $i = 0; ?>
                    <?php $product_data = \backend\models\Product::find()->all(); ?>
                    <?php foreach ($product_data as $value): ?>
                        <?php $i += 1; ?>
                        <div class="col-lg-2 product-items">
                            <!--                            <div class="card" style="heightc: 200px;" onclick="showadditemx($(this))">-->
                            <div class="card" style="heightc: 200px;">
                                <img class="card-img-top" src="../web/uploads/images/products/nologo.png" alt="">
                                <!--                                <img class="card-img-top" src="../web/uploads/logo/Logo_head.jpg" alt="">-->
                                <div class="card-body">
                                    <p class="card-text"
                                       style="font-size: 20px;text-align: center;font-weight: bold"><?= $value->code ?></p>
                                </div>
                                <div class="card-footer" style="width: 100%">
                                    <div class="row" style="width: 120%;text-align: center">
                                        <div class="col-lg-12">
                                            <div class="item-price"
                                                 style="color: red;font-weight: bold;"><?= $value->sale_price ?></div>
                                        </div>
                                    </div>
                                    <div style="height: 10px;"></div>
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <input type="hidden" class="list-item-product-id list-item-id-<?= $i ?>"
                                                   value="<?= $value->id ?>">
                                            <input type="hidden" class="list-item-code-<?= $i ?>"
                                                   value="<?= $value->code ?>">
                                            <input type="hidden" class="list-item-name-<?= $i ?>"
                                                   value="<?= $value->name ?>">
                                            <input type="hidden" class="list-item-price list-item-price-<?= $i ?>"
                                                   value="<?= $value->sale_price ?>">
                                            <div class="btn-group" style="width: 100%">
                                                <div class="btn btn-outline-secondary btn-sm" data-var="<?= $i ?>"
                                                     onclick="reducecart2($(this))"><i class="fa fa-minus"></i></div>
                                                <div class="btn btn-outline-primary btn-sm" data-var="<?= $i ?>"
                                                     onclick="addcart2($(this))">
                                                    <i class="fa fa-plus"></i></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-6">
        <form action="<?= \yii\helpers\Url::to(['pos/closesale'], true) ?>" id="form-close-sale" method="post">
            <input type="hidden" class="sale-customer-id" name="customer_id" value="">
            <input type="hidden" class="sale-total-amount" name="sale_total_amount" value="">
            <input type="hidden" class="sale-pay-amount" name="sale_pay_amount" value="">
            <input type="hidden" class="sale-pay-change" name="sale_pay_change" value="">
            <input type="hidden" class="sale-pay-type" name="sale_pay_type" value="">
            <div class="row">
                <div class="col-lg-4">
                    <h5 style="color: #258faf"><i class="fa fa-calendar"></i> <?= date('d/m/Y') ?> <span
                                class="c-time"><?= date('H:i') ?></span>
                    </h5>
                </div>
                <div class="col-lg-3">

                </div>
                <div class="col-lg-5" style="text-align: right">
                    <input type="hidden" class="total-value-top" value="0">
                    <h5> ยอดขาย <span style="color: red" class="total-text-top">0</span></h5>
                </div>
            </div>
            <hr style="border-top: 1px dashed gray">
            <div class="row">
                <div class="col-lg-12">
                    <table class="table table-striped table-bordered table-cart">
                        <thead>
                        <tr style="background-color: #1aa67d;color: #e3e3e3">
                            <th style="text-align: center;width: 5%">#</th>
                            <th style="width: 15%;text-align: center">รหัสสินค้า</th>
                            <th>ชื่อสินค้า</th>
                            <th style="text-align: right;width: 15%">จำนวน</th>
                            <th style="text-align: right">ราคา</th>
                            <th style="text-align: right">ราคารวม</th>
                            <th style="text-align: center">ลบ</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <td style="text-align: center;vertical-align: middle;width: 5%"></td>
                            <td style="vertical-align: middle;text-align: center"></td>
                            <td style="vertical-align: middle"></td>
                            <td style="text-align: right">
                                <input type="number" style="vertical-align: middle;text-align: right"
                                       class="form-control cart-qty" name="cart_qty[]" onchange="line_cal($(this))"
                                       value="" min="1">
                            </td>
                            <td style="text-align: right;vertical-align: middle"></td>
                            <td style="text-align: right;vertical-align: middle"></td>
                            <td style="text-align: center">
                                <input type="hidden" class="cart-product-id" name="cart_product_id[]" value="">
                                <input type="hidden" class="cart-price" name="cart_price[]" value="">
                                <input type="hidden" class="cart-total-price" name="cart_total_price[]" value="">
                                <div class="btn btn-danger btn-sm removecart-item" onclick="removecartitem($(this))"><i
                                            class="fa fa-trash"></i></div>
                            </td>
                        </tr>

                        </tbody>
                        <tfoot>
                        <tr>
                            <td colspan="3" style="text-align: right;font-weight: bold">รวมทั้งหมด</td>
                            <td style="font-weight: bold;text-align: right"></td>
                            <td></td>
                            <td style="font-weight: bold;text-align: right"></td>
                            <td></td>
                        </tr>

                        </tfoot>
                    </table>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-6" style="text-align: left">
                    <a href="index.php?r=pos/salehistory" class="btn btn-outline-info btn-history-cart"
                       style="display: noneผ">
                        ประวัติการขาย
                    </a>
                </div>
                <div class="col-lg-6" style="text-align: right">
                    <div class="btn btn-outline-secondary btn-cancel-cart" style="display: none">
                        ยกเลิกการขาย
                    </div>
                </div>
            </div>
            <hr>
            <div class="row div-payment" style="display: none">
                <div class="col-lg-12" style="text-align: center">
                    <div class="btn btn-group">
                        <div class="btn btn-outline-success btn-lg btn-pay-cash">ชำระเงินสด</div>
                        <!--                    <div class="btn btn-outline-primary btn-lg btn-pay-credit">ชำระเงินเชื่อ</div>-->
                        <!--                        <div class="btn btn-outline-warning btn-lg btn-pay-credit-card">ชำระบัตรเครดิต</div>-->
                    </div>
                </div>
            </div>
    </div>
</div>

<div id="posModal" class="modal fade" role="dialog">
    <div class="modal-dialog modal-md">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header" style="background-color: #2b669a">
                <div class="row" style="text-align: center;width: 100%;color: white">
                    <div class="col-lg-12">
                        <span><h3 class="popup-product" style="color: white"></h3></span>
                        <input type="hidden" class="popup-product-id" value="">
                        <input type="hidden" class="popup-product-code" value="">
                    </div>
                </div>
            </div>
            <!--            <div class="modal-body" style="white-space:nowrap;overflow-y: auto">-->
            <!--            <div class="modal-body" style="white-space:nowrap;overflow-y: auto;scrollbar-x-position: top">-->

            <div class="modal-body">
                <div class="row">
                    <div class="col-lg-4"></div>
                    <div class="col-lg-4" style="text-align: center">
                        <h4>จำนวน</h4>
                    </div>
                    <div class="col-lg-4"></div>
                </div>
                <br/>
                <div class="row">
                    <div class="col-lg-3"></div>
                    <div class="col-lg-6">
                        <input type="number" class="form-control popup-qty" value="" min="1"
                               style="font-size: 100px;height: 100px;text-align: center">
                    </div>
                    <div class="col-lg-3"></div>
                </div>
                <hr>
                <div class="row">
                    <div class="col-lg-4"></div>
                    <div class="col-lg-4" style="text-align: center">
                        <h4>ราคาขาย</h4>
                    </div>
                    <div class="col-lg-4"></div>
                </div>
                <br/>
                <div class="row">
                    <div class="col-lg-3"></div>
                    <div class="col-lg-6">
                        <input type="number" class="form-control popup-price" min="1"
                               style="font-size: 100px;height: 100px;text-align: center">
                    </div>
                    <div class="col-lg-3"></div>
                </div>
            </div>

            <div class="modal-footer">
                <button class="btn btn-outline-success btn-add-cart" data-dismiss="modalx" onclick="addcart($(this))"><i
                            class="fa fa-check"></i> บันทึกรายการ
                </button>
                <button type="button" class="btn btn-default" data-dismiss="modal"><i
                            class="fa fa-close text-danger"></i> ยกเลิก
                </button>
            </div>
        </div>

    </div>
</div>

<div id="payModal" class="modal fade" role="dialog">
    <div class="modal-dialog modal-lg">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header" style="background-color: #2b669a">
                <div class="row" style="text-align: center;width: 100%;color: white">
                    <div class="col-lg-12">
                        <span><h3 class="popup-payment" style="color: white"><i class="fa fa-shopping-cart"></i> บันทึกรับเงิน</h3></span>
                        <input type="hidden" class="popup-product-id" value="">
                        <input type="hidden" class="popup-product-code" value="">
                    </div>
                </div>

            </div>
            <!--            <div class="modal-body" style="white-space:nowrap;overflow-y: auto">-->
            <!--            <div class="modal-body" style="white-space:nowrap;overflow-y: auto;scrollbar-x-position: top">-->

            <div class="modal-body">
                <!--                <div class="row">-->
                <!--                    <div class="col-lg-12">-->
                <!--                        <p>เลขที่ <b>POS20010002</b></p>-->
                <!--                    </div>-->
                <!--                </div>-->
                <!--                <hr style="border-top: 1px dashed gray">-->
                <div class="row">
                    <div class="col-lg-8">
                        <div class="row">
                            <div class="col-lg-4"></div>
                            <div class="col-lg-4" style="text-align: center">
                                <h4>ยอดขาย</h4>
                            </div>
                            <div class="col-lg-4"></div>
                        </div>
                        <br/>
                        <div class="row">
                            <div class="col-lg-3"></div>
                            <div class="col-lg-6">
                                <input type="number" class="form-control pay-total-amount" value="" min="1"
                                       style="font-size: 50px;height: 60px;text-align: center" disabled>
                            </div>
                            <div class="col-lg-3"></div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-lg-4"></div>
                            <div class="col-lg-4" style="text-align: center">
                                <h4>ชำระเงิน</h4>
                            </div>
                            <div class="col-lg-4"></div>
                        </div>
                        <br/>
                        <div class="row">
                            <div class="col-lg-3"></div>
                            <div class="col-lg-6">
                                <input type="number" class="form-control pay-amount" min="1"
                                       style="font-size: 50px;height: 60px;text-align: center" value="0">
                                <br>
                                <div class="alert alert-danger pay-alert" style="height: 50px;display: none;">
                                    <p>จำนวนเงินไม่พอสำหรับการซื้อนี้</p>
                                </div>
                            </div>
                            <div class="col-lg-3"></div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-lg-4"></div>
                            <div class="col-lg-4" style="text-align: center">
                                <h4>เงินทอน</h4>
                            </div>
                            <div class="col-lg-4">

                            </div>
                        </div>
                        <br/>
                        <div class="row">
                            <div class="col-lg-3"></div>
                            <div class="col-lg-6">
                                <input type="text" class="form-control pay-change" value="" readonly
                                       style="font-size: 50px;height: 60px;text-align: center">
                            </div>
                            <div class="col-lg-3"></div>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="row">
                            <div class="col-lg-12" style="text-align: center">
                                <h4>เหรียญหรือธนบัตร</h4>
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="btn btn-outline-primary" data-var="1"
                                     style="width: 100%;height: 60px;font-weight: bold;font-size: 30px;"
                                     onclick="calpayprice($(this))">1
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="btn btn-outline-primary" data-var="5"
                                     style="width: 100%;height: 60px;font-weight: bold;font-size: 30px;"
                                     onclick="calpayprice($(this))">5
                                </div>
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="btn btn-outline-primary" data-var="10"
                                     style="width: 100%;height: 60px;font-weight: bold;font-size: 30px;"
                                     onclick="calpayprice($(this))">10
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="btn btn-outline-primary" data-var="20"
                                     style="width: 100%;height: 60px;font-weight: bold;font-size: 30px;"
                                     onclick="calpayprice($(this))">20
                                </div>
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="btn btn-outline-primary" data-var="50"
                                     style="width: 100%;height: 60px;font-weight: bold;font-size: 30px;"
                                     onclick="calpayprice($(this))">50
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="btn btn-outline-primary" data-var="100"
                                     style="width: 100%;height: 60px;font-weight: bold;font-size: 30px;"
                                     onclick="calpayprice($(this))">100
                                </div>
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="btn btn-outline-primary" data-var="500"
                                     style="width: 100%;height: 60px;font-weight: bold;font-size: 30px;"
                                     onclick="calpayprice($(this))">500
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="btn btn-outline-primary" data-var="1000"
                                     style="width: 100%;height: 60px;font-weight: bold;font-size: 30px;"
                                     onclick="calpayprice($(this))">1000
                                </div>
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="btn btn-outline-danger" data-var="0"
                                     style="width: 100%;height: 60px;font-weight: bold;font-size: 30px;"
                                     onclick="calpayprice($(this))">Clear
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>

            <div class="modal-footer">
                <button class="btn btn-outline-success btn-pay-submit" data-dismiss="modalx">
                    <i class="fa fa-check"></i> จบการขาย
                </button>
                <button type="button" class="btn btn-default" data-dismiss="modal"><i
                            class="fa fa-ban text-danger"></i> ยกเลิก
                </button>
            </div>
        </div>

    </div>
</div>

<div id="historyModal" class="modal fade" role="dialog">
    <div class="modal-dialog modal-md">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header" style="background-color: #2b669a">
                <div class="row" style="text-align: center;width: 100%;color: white">
                    <div class="col-lg-12">
                        <span><h3 class="popup-product" style="color: white"></h3></span>
                        <input type="hidden" class="popup-product-id" value="">
                        <input type="hidden" class="popup-product-code" value="">
                    </div>
                </div>
            </div>
            <!--            <div class="modal-body" style="white-space:nowrap;overflow-y: auto">-->
            <!--            <div class="modal-body" style="white-space:nowrap;overflow-y: auto;scrollbar-x-position: top">-->

            <div class="modal-body">

            </div>

            <!--            <div class="modal-footer">-->
            <!--                <button class="btn btn-outline-success btn-add-cart" data-dismiss="modalx" onclick="addcart($(this))"><i-->
            <!--                            class="fa fa-check"></i> บันทึกรายการ-->
            <!--                </button>-->
            <!--                <button type="button" class="btn btn-default" data-dismiss="modal"><i-->
            <!--                            class="fa fa-close text-danger"></i> ยกเลิก-->
            <!--                </button>-->
            <!--            </div>-->
        </div>

    </div>
</div>

<?php
$url_to_get_origin_price = \yii\helpers\Url::to(['pos/getoriginprice'], true);
$url_to_get_basic_price = \yii\helpers\Url::to(['pos/getbasicprice'], true);
$url_to_get_price = \yii\helpers\Url::to(['pos/getcustomerprice'], true);

$js = <<<JS
 $(function(){
     
     setInterval(function (){
          var dt = new Date();
          var time = dt.getHours() + ":" + dt.getMinutes();
          $(".c-time").html(time);
     },60000);
    
     
     $(".customer-id").select2({
     dropdownAutoWidth : true
     });
     if($("#btn-general-customer").hasClass("active")){
         $(".div-customer-search").hide();
     }else{
         $(".text-price-type").show();
         $(".div-customer-search").show();
     }
     $(".btn-pay-cash").click(function(){
         $(".sale-pay-type").val(1);
         var sale_total_amt = $(".total-value-top").val()
             if(sale_total_amt > 0){
                 $(".pay-total-amount").val(sale_total_amt);
                 $(".sale-total-amount").val(sale_total_amt);
                 
                  $(".pay-amount").val(0);
                  $(".pay-change").val(0);
                  var c_pay = $(".pay-amount").val();
                  var sale_total = $(".pay-total-amount").val();
                    if(c_pay < sale_total){
                       // $(".pay-alert").fadeIn();
                        $(".btn-pay-submit").prop('disabled','disabled');
                    }else{
                       // $(".pay-alert").hide();
                        $(".btn-pay-submit").prop('disabled','');
                    }
                 $("#payModal").modal("show");
             }
     });
     
     $(".table-cart tbody tr").each(function (){
         var check_row = $(this).closest('tr').find('td:eq(1)').html();
         //alert(check_row);
        if( check_row == ''){
            $(this).closest('tr').find('.removecart-item').hide();
            $(this).closest('tr').find('.cart-qty').prop("disabled","disabled");
            $(".div-payment").hide();
        } 
     });
     
     $("#btn-fix-customer").click(function(){
        $(this).removeClass('btn-outline-secondary');
        $(this).addClass('btn-success');
        
        $("#btn-general-customer").removeClass('btn-success');
        $("#btn-general-customer").removeClass('active');
        $("#btn-general-customer").addClass('btn-outline-secondary');
        //$(".text-price-type").show();
        $(".div-customer-search").show();
     });
     
      $("#btn-general-customer").click(function(){
          price_group_name = '';
          $.ajax({
              type: "post",
              dataType: "json",
              url: "$url_to_get_origin_price",
              data: {},
              success: function(data){
                  if(data.length > 0){
                      var i = -1;
                      $(".product-items").each(function(){
                          i++;
                          var line_product_id = $(this).find(".list-item-product-id").val();
                          if(line_product_id == data[i]['product_id']){
                              $(".card").css("background-color","white"); 
                              $(this).find(".list-item-price").val(data[i]['sale_price']);
                              $(this).find(".item-price").html(data[i]['sale_price']);
                          }
                      });
                          
                  }else{
                      alert('no price');
                  }
               },
               error: function(err) {
                  alert('eror');
               }
             });
        
          if(price_group_name !=''){
              $(".text-price-type").show();
              $(".badge-text-price-type").html(price_group_name);
          }else{
              $(".text-price-type").hide();
              $(".badge-text-price-type").html('');
          }
          
        $(this).removeClass('btn-outline-secondary');
        $(this).addClass('btn-success');
        
        $("#btn-fix-customer").removeClass('btn-success');
        $("#btn-fix-customer").removeClass('active');
        $("#btn-fix-customer").addClass('btn-outline-secondary');
        
        $(".div-customer-search").hide();
     });
      
     $(".btn-cancel-cart").click(function(){
         $(".table-cart tbody tr").each(function(){
             if($(".table-cart tbody>tr").length == 1){
                 $(".table-cart tbody tr").each(function(){
                     $(this).closest('tr').find('.cart-product-id').val('');
                     $(this).closest('tr').find('.cart-price').val('');
                     $(this).closest('tr').find('.cart-qty').val('');
                     $(this).closest('tr').find('.cart-qty').prop('disabled','disabled');
                     $(this).closest('tr').find('td:eq(0)').html('');
                     $(this).closest('tr').find('td:eq(1)').html('');
                     $(this).closest('tr').find('td:eq(2)').html('');
                     $(this).closest('tr').find('td:eq(4)').html('');
                     $(this).closest('tr').find('td:eq(5)').html('');
                     $(this).closest('tr').find('.removecart-item').hide();
                 });
                  $(".btn-cancel-cart").hide();
                  $(".div-payment").hide();
                  clearall();
             }else{
                 $(this).remove();
                  calall();
             }
         });  
        
     });
     
     $(".btn-pay-submit").click(function(){
         $("form#form-close-sale").submit();
     });
      
 });

function calpayprice(e){
    var price_val = e.attr('data-var');
    if(price_val == 0){
        $(".pay-amount").val(0);
    }
    var c_pay = $(".pay-amount").val();
    var new_pay = parseFloat(price_val) + parseFloat(c_pay);

    var sale_total = $(".pay-total-amount").val();
    var price_change = parseFloat(new_pay) - parseFloat(sale_total);
    if(price_val == 0){ price_change = 0;}
    $(".pay-amount").val(new_pay);
    $(".pay-change").val(price_change);
    
    $(".sale-pay-amount").val(new_pay);
    $(".sale-pay-change").val(price_change);
    
    if(new_pay < sale_total){
        $(".pay-alert").fadeIn();
        $(".btn-pay-submit").prop('disabled','disabled');
    }else{
        $(".pay-alert").hide();
        $(".btn-pay-submit").prop('disabled','');
    }
}
function getproduct_price(e){
    var ids = e.val();
    if(ids > 0){
        $(".sale-customer-id").val(ids);
        $("div.product-items").each(function(){
         // alert();
         var _this = $(this);
          $.ajax({
                   type: "post",
                   dataType: "json",
                   async: true,
                   url: "$url_to_get_basic_price",
                   data: {'id': line_product_id, 'customer_id': ids},
                   success: function(data){
                       if(data.length > 0){
                              if(data[0]['sale_price'] != null){
                                   _this.find(".card").css("background-color","#66CCFF");
                                   _this.find(".list-item-price").val(data[0]['sale_price']);
                                   _this.find(".item-price").html(data[0]['sale_price']); 
                              }else{
                                   _this.find(".card").css("background-color","white");
                                   _this.find(".list-item-price").val(data[0]['basic_price']);
                                   _this.find(".item-price").html(data[0]['basic_price']); 
                              }
                             
                       }
                                         
                   }
          });                               
     });
    }
}
function getproduct_price2(e){
    var ids = e.val();
    if(ids > 0){
       // alert(ids);
        $(".sale-customer-id").val(ids);
         $.ajax({
              type: "post",
              dataType: "json",
              async: true,
              url: "$url_to_get_price",
              data: {customer_id: ids},
              success: function(data){
                  if(data.length > 0){
                          var i = -1;
                          var price_group_name = '';
                          if(data[0][0] != null){
                              loop_item_price(data);
                              //alert($("div.product-items").length);
//                              $("div.product-items").each(function(){
//                                // alert();
//                                     i++;
//                                     // var line_product_id = $(this).find(".list-item-product-id").val();
//                                     // alert(line_product_id);
//                                        // if(data[0][i]!= null){
//                                            // alert(data[0].length);
//                                            //  for(var x =0;x<= data[0].length -1;x++){
//                                            //      alert('product = '+ data[0][x]['product_id']);
//                                            //      if(parseInt(line_product_id) == parseInt(data[0][x]['product_id'])){
//                                            //          alert("OKKK");
//                                            //      }
//                                            //  }
//                                             
//                                             // alert('line_id= '+line_product_id + ' AND ' +data[0][i]['product_id']);
//                                             //     if(parseInt(line_product_id) == parseInt(data[0][i]['product_id'])){
//                                             //         alert("equal");
//                                             //         $(this).find(".card").css("background-color","#66CCFF");
//                                             //         $(this).find(".list-item-price").val(data[0][i]['sale_price']);
//                                             //         $(this).find(".item-price").html(data[0][i]['sale_price']);
//                                             //     }
//                                              price_group_name = data[0][i]['price_name'];
//                                             //alert(line_product_id);
//                                         // }else{
//                                         //         $(this).find(".card").css("background-color","white"); 
//                                         //         $(this).find(".list-item-price").val(data[1][i]['sale_price']);
//                                         //         $(this).find(".item-price").html(data[1][i]['sale_price']); 
//                                         // }
//                               
//                              });
                          }else{
                              $(".product-items").each(function(){
                                     i+=1;
                                     var line_product_id = $(this).find(".list-item-product-id").val();
                                     if(line_product_id == data[1][i]['product_id']){
                                         $(".card").css("background-color","white"); 
                                         $(this).find(".list-item-price").val(data[1][i]['sale_price']);
                                         $(this).find(".item-price").html(data[1][i]['sale_price']);
                                     }
                              });
                          }
                          if(price_group_name !=''){
                              $(".text-price-type").show();
                              $(".badge-text-price-type").html(price_group_name);
                          }else{
                               $(".text-price-type").hide();
                              $(".badge-text-price-type").html('');
                          }
                            
                  }else{
                      alert('no price');
                  }
               },
               error: function(err) {
                  alert('eror');
               }
             });
    }
    // $(".product-items").each(function(){
    //   // console.log($(this).find(".list-item-price").val());
    //    $(".popup-price").val($(this).find(".list-item-price").val());
    // });
}

function loop_item_price(data){
     //alert($("div.product-items").length);
     var i = -1;
     var price_group_name = '';
     $("div.product-items").each(function(){
         // alert();
         var _this = $(this);
         i++;
         var line_product_id = $(this).find(".list-item-product-id").val();
         //alert(line_product_id);
         if(data[0][0]!= null){
             //alert(data[0].length);
             for(var x =0;x<= data[0].length -1;x++){
               //  alert('product = '+ data[0][x]['product_id']);
                if(parseInt(line_product_id) == parseInt(data[0][x]['product_id'])){
                    //alert("OKKK");
                             $(this).find(".card").css("background-color","#66CCFF");
                             $(this).find(".list-item-price").val(data[0][x]['sale_price']);
                             $(this).find(".item-price").html(data[0][x]['sale_price']);
               }else{
                             $(this).find(".card").css("background-color","white");
                             $.ajax({
                                      type: "post",
                                      dataType: "json",
                                      async: true,
                                      url: "$url_to_get_basic_price",
                                      data: {id: line_product_id},
                                      success: function(data){
                                          if(data.length > 0){
                                               _this.find(".list-item-price").val(data[0]['sale_price']);
                                               _this.find(".item-price").html(data[0]['sale_price']); 
                                          }
                                         
                                      }
                             });
               }
             }
         }
                               
     });
}

function showadditem(e){
    var c_prod_id = e.find('.list-item-id').val();
    var c_prod_code = e.find('.list-item-code').val();
    var c_prod_name = e.find('.list-item-name').val();
    var c_prod_price = e.find('.list-item-price').val();
   //alert(c_prod_price);
    if(c_prod_id > 0){
        $(".popup-product-id").val(c_prod_id);
        $(".popup-product-code").val(c_prod_code);
        $(".popup-product").html(c_prod_name);
        $(".popup-qty").val(1);
        $(".popup-price").val(c_prod_price);
        $("#posModal").modal("show");
    }
}
function check_dup(prod_id){
    var has_id = 0;
     $(".table-cart tbody tr").each(function(){
        var id = $(this).closest('tr').find('.cart-product-id').val();
        if(id == prod_id){
            has_id =1;
        }
     });
    return has_id;
}

function addcart(e){
    var prod_id = $(".popup-product-id").val();
    var prod_code = $(".popup-product-code").val();
    var prod_name = $(".popup-product").html();
    var qty = $(".popup-qty").val();
    var price = $(".popup-price").val();
    var tr = $(".table-cart tbody tr:last");
    //  alert(prod_code);
    var check_old = check_dup(prod_id);
    if(check_old == 1){
        $(".table-cart tbody tr").each(function(){
        var id = $(this).closest('tr').find('.cart-product-id').val();
        if(id == prod_id){
            var old_qty = $(this).closest('tr').find('.cart-qty').val();
            var new_qty = parseFloat(old_qty) + parseFloat(qty);
            $(this).closest('tr').find('.cart-qty').val(new_qty);
            line_cal($(this));
        }
     });
    }else{
        if(tr.closest('tr').find('.cart-product-id').val() == ''){
            tr.closest('tr').find('.cart-product-id').val(prod_id);
            tr.closest('tr').find('.cart-qty').val(qty);
            tr.closest('tr').find('.cart-price').val(price);
            tr.closest('tr').find('td:eq(1)').html(prod_code);
            tr.closest('tr').find('td:eq(2)').html(prod_name);
            tr.closest('tr').find('td:eq(4)').html(price);

            tr.closest('tr').find('.cart-qty').prop("disabled","");
            tr.closest('tr').find('.removecart-item').show();
            $(".div-payment").show();
            line_cal(tr);
        }else{
            var clone = tr.clone();
            clone.find(".cart-product-id").val(prod_id);
            clone.find('.cart-qty').val(qty);
            clone.find('.cart-price').val(price);
            clone.find('td:eq(1)').html(prod_code);
            clone.find('td:eq(2)').html(prod_name);
            clone.find('td:eq(4)').html(price);
            tr.after(clone);
            line_cal(clone);
        }
    }
    cal_linenum();
    calall();
    $("#posModal").modal('hide');
}

function addcart2(e){
    var ids = e.attr('data-var');
    
    var prod_id = $(".list-item-id-"+ids).val();
    var prod_code = $(".list-item-code-"+ids).val();
    var prod_name = $(".list-item-name-"+ids).val();
    // alert(prod_id);
    var qty = 1;
    var price = $(".list-item-price-"+ids).val();
    var tr = $(".table-cart tbody tr:last");
     
    var check_old = check_dup(prod_id);
    if(check_old == 1){
        $(".table-cart tbody tr").each(function(){
        var id = $(this).closest('tr').find('.cart-product-id').val();
        if(id == prod_id){
            var old_qty = $(this).closest('tr').find('.cart-qty').val();
            var new_qty = parseFloat(old_qty) + parseFloat(qty);
            $(this).closest('tr').find('.cart-qty').val(new_qty);
            line_cal($(this));
        }
     });
    }else{
        if(tr.closest('tr').find('.cart-product-id').val() == ''){
            // alert('has');
            tr.closest('tr').find('.cart-product-id').val(prod_id);
            tr.closest('tr').find('.cart-qty').val(qty);
            tr.closest('tr').find('.cart-price').val(price);
            tr.closest('tr').find('td:eq(1)').html(prod_code);
            tr.closest('tr').find('td:eq(2)').html(prod_name);
            tr.closest('tr').find('td:eq(4)').html(price);

            tr.closest('tr').find('.cart-qty').prop("disabled","");
            tr.closest('tr').find('.removecart-item').show();
            $(".div-payment").show();
            line_cal(tr);
        }else{
            var clone = tr.clone();
            clone.find(".cart-product-id").val(prod_id);
            clone.find('.cart-qty').val(qty);
            clone.find('.cart-price').val(price);
            clone.find('td:eq(1)').html(prod_code);
            clone.find('td:eq(2)').html(prod_name);
            clone.find('td:eq(4)').html(price);
            tr.after(clone);
            line_cal(clone);
        }
    }
    cal_linenum();
    calall();
    $(".btn-cancel-cart").show();
   // $("#posModal").modal('hide');
}
function reducecart2(e){
    var ids = e.attr('data-var');
    
    var prod_id = $(".list-item-id-"+ids).val();
    var prod_code = $(".list-item-code-"+ids).val();
    var prod_name = $(".list-item-name-"+ids).val();
    // alert(prod_id);
    var qty = -1;
    var price = $(".list-item-price-"+ids).val();
    var tr = $(".table-cart tbody tr:last");
     
    var check_old = check_dup(prod_id);
    if(check_old == 1){
        $(".table-cart tbody tr").each(function(){
        var id = $(this).closest('tr').find('.cart-product-id').val();
        if(id == prod_id){
            var old_qty = $(this).closest('tr').find('.cart-qty').val();
            var new_qty = parseFloat(old_qty) + parseFloat(qty);
            if(new_qty < 0){return false;}
            $(this).closest('tr').find('.cart-qty').val(new_qty);
            line_cal($(this));
            
        }
     });
    }
    cal_linenum();
    calall();
   // $("#posModal").modal('hide');
}

function removecartitem(e){
    if(confirm('ต้องการลบข้อมูลนี้ใช่หรือไม่?')){
        
        if($('.table-cart tbody tr').length == 1){
            var tr = $('.table-cart tbody tr:last');
             tr.find('.cart-product-id').val('');
             tr.find('.cart-price').val('');
             tr.find('.cart-qty').val('');
             tr.find('.cart-qty').prop('disabled','disabled');
             tr.find('td:eq(0)').html('');
             tr.find('td:eq(1)').html('');
             tr.find('td:eq(2)').html('');
             tr.find('td:eq(4)').html('');
             tr.find('td:eq(5)').html('');
             tr.find('.removecart-item').hide();
             clearall();
            $(".btn-cancel-cart").hide();
            $(".div-payment").hide();
        }else{
             e.parent().parent().remove();
              cal_linenum();
              calall();
        }
        
        
    }
}
function cal_linenum() {
        var xline = 0;
        $(".table-cart tbody tr").each(function () {
            xline += 1;
            var ids = $(this).closest('tr').find('.cart-product-id').val();
            if(ids !=''){
               // alert()
                $(this).closest("tr").find("td:eq(0)").text(xline);
            }
            
        });
}

function line_cal(e){
    var line_total = 0;
  //  $(".table-cart tbody tr").each(function(){
          var qty = e.closest('tr').find('.cart-qty').val();
          var price = e.closest('tr').find('.cart-price').val();
          line_total = parseFloat(qty) * parseFloat(price);
        //  alert(price);
   // });
    e.closest('tr').find('.cart-total-price').val(line_total);
    e.closest('tr').find('td:eq(5)').html(addCommas(line_total));
    calall();
}
function calall(){
      var total_qty = 0;
      var total_price = 0;

      $(".table-cart tbody tr").each(function(){
          var qty = $(this).closest('tr').find('.cart-qty').val();
          var price = $(this).closest('tr').find('.cart-total-price').val();
          
         if(qty == '' || qty == null){
             qty = 0;
         }
         if(price == '' || price == null){
             price = 0;
         }
         
        // alert("qty "+qty+" price "+price);
          
          total_qty = total_qty + parseFloat(qty);
          total_price = total_price + parseFloat(price);
          // alert(total_price);
      });

      $(".table-cart tfoot tr").find('td:eq(1)').html(total_qty);
      $(".table-cart tfoot tr").find('td:eq(3)').html(addCommas(total_price));
      $(".total-text-top").html(addCommas(total_price));
      $(".total-value-top").val(total_price);

}
function clearall(){
      $(".table-cart tfoot tr").find('td:eq(1)').html(0);
      $(".table-cart tfoot tr").find('td:eq(3)').html(addCommas(0));
      $(".total-text-top").html(addCommas(0));
      $(".total-value-top").val(0);
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
