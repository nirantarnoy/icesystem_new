<?php

use kartik\select2\Select2;

$this->title = 'ทำรายการขายหน้าร้าน POS';

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
            <div class="col-lg-9">
                <div class="btn btn-group group-customer-type">
                    <button class="btn btn-outline-secondary btn-sm" disabled>ประเภทลูกค้า</button>
                    <button id="btn-general-customer" class="btn btn-success btn-sm active">ลูกค้าทั่วไป</button>
                    <button id="btn-fix-customer" class="btn btn-outline-secondary btn-sm">ระบุลูกค้า</button>
                </div>
            </div>
        </div>
        <div class="row div-customer-search" style="display: none;">
            <div class="col-lg-12">
                <div class="input-group" style="margin-left: 10px;">
                    <!--                    <input type="text" class="form-control find-customer" value="">-->
                    <?php $cust_data = \backend\models\Customer::find()->all(); ?>
                    <select name="" class="form-control customer-id" id="">
                        <?php foreach ($cust_data as $value): ?>
                            <option value="<?= $value->id ?>"><?= $value->name ?></option>
                        <?php endforeach; ?>
                    </select>
                    <button class="btn btn-primary"><i class="fa fa-search"></i></button>
                </div>
            </div>
        </div>
        <br/>
        <div class="row">
            <div class="col-lg-12">
                <div class="row">
                    <?php $product_data = \backend\models\Product::find()->all(); ?>
                    <?php foreach ($product_data as $value): ?>
                        <div class="col-lg-2 product-items">
                            <div class="card" style="width: ;height: 180px;" onclick="showadditem($(this))">
                                <img class="card-img-top" src="../web/uploads/images/products/nologo.png" alt="">
                                <div class="card-body">
                                    <input type="hidden" class="list-item-id" value="<?= $value->id ?>">
                                    <input type="hidden" class="list-item-code" value="<?= $value->code ?>">
                                    <input type="hidden" class="list-item-name" value="<?= $value->name ?>">
                                    <input type="hidden" class="list-item-price" value="<?= $value->sale_price ?>">
                                    <p class="card-text" style="font-size: 14px;"><?= $value->name ?></p>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-6">
        <div class="row">
            <div class="col-lg-6">
                <h5><i class="fa fa-shopping-basket"></i> รายการขายสินค้า</h5>
            </div>
            <div class="col-lg-6" style="text-align: right">
                <h5> ยอดขาย <span style="color: red" class="total-text-top">0</span></h5>
            </div>
        </div>
        <hr style="border-top: 1px dashed gray">
        <div class="row">
            <div class="col-lg-12">
                <table class="table table-striped table-bordered table-cart">
                    <thead>
                    <tr>
                        <th style="text-align: center;width: 5%">#</th>
                        <th style="width: 15%">รหัสสินค้า</th>
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
                        <td style="vertical-align: middle"></td>
                        <td style="vertical-align: middle"></td>
                        <td style="text-align: right">
                            <input type="number" style="vertical-align: middle;text-align: right"
                                   class="form-control cart-qty" name="cart_qty[]"  onchange="line_cal($(this))" value="">
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
        <hr>
        <!--        <div class="row">-->
        <!--            <div class="col-lg-12">-->
        <!--                <table class="" width="100%">-->
        <!--                    <tr>-->
        <!--                        <td width="70%" style="text-align: right">จำนวนสินค้า</td>-->
        <!--                        <td style="text-align: right;width: 10%">5</td>-->
        <!--                        <td></td>-->
        <!--                    </tr>-->
        <!--                    <tr>-->
        <!--                        <td width="70%" style="text-align: right">ราคา</td>-->
        <!--                        <td style="text-align: right;width: 10%">5</td>-->
        <!--                        <td></td>-->
        <!--                    </tr>-->
        <!--                    <tr>-->
        <!--                        <td width="70%" style="text-align: right">ภาษีมูลค่าเพิ่ม</td>-->
        <!--                        <td style="text-align: right;width: 10%">5</td>-->
        <!--                        <td></td>-->
        <!--                    </tr>-->
        <!--                    <tr>-->
        <!--                        <td width="70%" style="text-align: right">รวมทั้งสิ้น</td>-->
        <!--                        <td style="text-align: right;width: 10%">5</td>-->
        <!--                        <td></td>-->
        <!--                    </tr>-->
        <!--                </table>-->
        <!--            </div>-->
        <!--        </div>-->
        <!--        <hr/>-->
        <div class="row div-payment" style="display: none">
            <div class="col-lg-12" style="text-align: center">
                <div class="btn btn-group">
                    <div class="btn btn-outline-success btn-lg">ชำระเงินสด</div>
                    <div class="btn btn-outline-primary btn-lg">ชำระเงินเชื่อ</div>
                    <div class="btn btn-outline-warning btn-lg">ชำระบัตรเครดิต</div>
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

<?php
$js = <<<JS
 $(function(){
     $(".customer-id").select2({
     dropdownAutoWidth : true
     });
     if($("#btn-general-customer").hasClass("active")){
         $(".div-customer-search").hide();
     }else{
         $(".div-customer-search").show();
     }
     
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
        
        $(".div-customer-search").show();
     });
     
      $("#btn-general-customer").click(function(){
        $(this).removeClass('btn-outline-secondary');
        $(this).addClass('btn-success');
        
        $("#btn-fix-customer").removeClass('btn-success');
        $("#btn-fix-customer").removeClass('active');
        $("#btn-fix-customer").addClass('btn-outline-secondary');
        
        $(".div-customer-search").hide();
     });
 });

function showadditem(e){
    var c_prod_id = e.find('.list-item-id').val();
    var c_prod_code = e.find('.list-item-code').val();
    var c_prod_name = e.find('.list-item-name').val();
    var c_prod_price = e.find('.list-item-price').val();
   // alert(c_prod_code);
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

function removecartitem(e){
    if(confirm('ต้องการลบข้อมูลนี้ใช่หรือไม่?')){
        e.parent().parent().remove();
        cal_linenum();
        calall();
    }
    
}
function cal_linenum() {
        var xline = 0;
        $(".table-cart tbody tr").each(function () {
            xline += 1;
            $(this).closest("tr").find("td:eq(0)").text(xline);
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
          total_qty = total_qty + parseFloat(qty);
          total_price = total_price + parseFloat(price);
          // alert(total_price);
      });
      
      $(".table-cart tfoot tr").find('td:eq(1)').html(total_qty);
      $(".table-cart tfoot tr").find('td:eq(3)').html(addCommas(total_price));
      $(".total-text-top").html(addCommas(total_price));
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
