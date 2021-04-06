<?php
$this->title = 'บันทึกสินค้าเข้าคลัง';
$prod_data = \backend\models\Product::find()->all();
$wh_date = \backend\models\Warehouse::find()->where(['id'=>6])->all();
?>
<div class="row">
    <div class="col-lg-4">
        <div class="row">
            <div class="col-lg-12">
                <h3 style="color: #258faf">รหัสสินค้า</b></h3>
            </div>
        </div>
        <br />
        <div class="row">
            <?php foreach($prod_data as $val):?>
             <div class="col-lg-6">
                 <div class="small-box bg-secondary" style="text-align: center" data-id="<?=$val->id?>" data-var="<?=$val->name?>" onclick="addcart($(this))">
                     <div class="inner">
                         <h1><?=$val->code?></h1>
                     </div>
                 </div>
             </div>

            <?php endforeach;?>
        </div>
    </div>
    <div class="col-lg-8">
        <form id="form-stock-trans" method="post" action="<?=\yii\helpers\Url::to(['stocktrans/create'],true)?>">
        <div class="row">
            <div class="col-lg-4" style="text-align: left">
                <label for="">วันที่รับเข้า</label>
                <?php
                  echo \kartik\date\DatePicker::widget([
                     'name'=>'prodrecdate',
                      'value' => date('d/m/Y'),
                  ]);
                ?>
            </div>
            <div class="col-lg-4" style="text-align: right">
                <label for="" style="color: white">total</label><br />
               <h3>จำนวนรวม <span class="total-qty"></span></h3>
            </div>
            <div class="col-lg-4" style="text-align: right">
                <label for="" style="color: white">total</label><br />
                <div class="btn btn-success btn-lg" onclick="submitform($(this))">บันทึก</div>
            </div>
        </div>
        <br />
        <table class="table table-striped table-bordered table-cart">
            <thead>
            <tr style="color: #44ab7d">
                <th style="width: 5%;text-align: center">#</th>
                <th>คลังสินค้า</th>
                <th>สินค้า</th>
                <th style="width: 15%">จำนวน</th>
                <th style="width: 5%;text-align: center"></th>
            </tr>
            </thead>
            <tbody>
            <tr>
                <td style="width: 5%;text-align: center"></td>
                <td>
                    <select name="line_warehouse_id[]" class="form-control line-warehouse-id" id="">
                        <?php foreach ($wh_date as $value): ?>
                            <option value="<?=$value->id?>"><?=$value->name?></option>
                        <?php endforeach;?>
                    </select>
                </td>
                <td>
                    <input type="hidden" name="line_item_id[]" value="" class="form-control line-item-id" readonly>
                    <input type="text" name="line_item_name[]" value="" class="form-control line-item-name" readonly>
                </td>
                <td>
                    <input type="number" class="form-control line-qty" value="0" min="0" name="line_qty[]" onchange="calall()">
                </td>
                <td style="width: 5%;text-align: center">
                    <div class="btn btn-danger btn-sm removecart-item" onclick="removecartitem($(this))"><i class="fa fa-trash"></i></div>
                </td>
            </tr>
            </tbody>
        </table>
        </form>
    </div>
</div>


<?php
$js=<<<JS
$(function(){
    
});
function removecartitem(e){
   // if(confirm('ต้องการลบข้อมูลนี้ใช่หรือไม่?')){
        
        if($('.table-cart tbody tr').length == 1){
            var tr = $('.table-cart tbody tr:last');
             tr.find('.line-item-id').val('');
             tr.find('.line-qty').val('0');
             tr.find('.line-qty').prop('disabled','disabled');
             tr.find('td:eq(0)').html('');
             tr.find('.line-warehouse-id').val(6).change();
             tr.find('.line-item-name').html('');
             tr.find('.removecart-item').hide();
             clearall();
        }else{
             e.parent().parent().remove();
              cal_linenum();
              calall();
        }
        
        
  //  }
}
function submitform(e){
    if(confirm('ต้องการบันทึกข้อมูลนี้ใช่หรือไม่?')){
        $("form#form-stock-trans").submit();
    }
}
function clearall(){
    
      $(".total-qty").html(addCommas(0));
    
}
function addcart(e){
    var ids = e.attr('data-id');
    var name = e.attr('data-var');
   // alert(ids);
     var prod_id = ids;
     var prod_name = name;
    //  //alert(prod_id);
     var qty = 1;
     var tr = $(".table-cart tbody tr:last");
    // 
     var check_old = check_dup(prod_id);
    if(check_old == 1){
        $(".table-cart tbody tr").each(function(){
        var id = $(this).closest('tr').find('.line-item-id').val();
        if(id == prod_id){
            var old_qty = $(this).closest('tr').find('.line-qty').val();
            var new_qty = parseFloat(old_qty) + parseFloat(qty);
            $(this).closest('tr').find('.line-qty').val(new_qty);
            line_cal($(this));
        }
     });
    }else{
        if(tr.closest('tr').find('.line-item-id').val() == ''){
            // alert('has');
            tr.closest('tr').find('.line-item-id').val(prod_id);
            tr.closest('tr').find('.line-item-name').val(prod_name);
            tr.closest('tr').find('.line-qty').val(qty);
            tr.closest('tr').find('.line-warehouse-id').val(6).change();
            tr.closest('tr').find('.line-qty').prop("disabled","");
            tr.closest('tr').find('.removecart-item').show();
            line_cal(tr);
        }else{
            var clone = tr.clone();
            clone.find(".line-item-id").val(prod_id);
            clone.find(".line-item-name").val(prod_name);
            clone.find('.line-qty').val(qty);
            tr.closest('tr').find('.line-warehouse-id').val(6).change();
            tr.after(clone);
            line_cal(clone);
        }
    }
    cal_linenum();
    calall();
    // $(".btn-cancel-cart").show();
   // $("#posModal").modal('hide');
}

function check_dup(prod_id){
    var has_id = 0;
     $(".table-cart tbody tr").each(function(){
        var id = $(this).closest('tr').find('.line-item-id').val();
        if(id == prod_id){
            has_id =1;
        }
     });
    return has_id;
}
function line_cal(e){
    var line_total = 0;
  //  $(".table-cart tbody tr").each(function(){
          var qty = e.closest('tr').find('.line-qty').val();
          line_total = parseFloat(qty) * parseFloat(line_total);
        //  alert(price);
   // });
  
    e.closest('tr').find('td:eq(5)').html(addCommas(line_total));
    calall();
}
function cal_linenum() {
        var xline = 0;
        $(".table-cart tbody tr").each(function () {
            xline += 1;
            var ids = $(this).closest('tr').find('.line-item-id').val();
            if(ids !=''){
               // alert()
                $(this).closest("tr").find("td:eq(0)").text(xline);
            }
            
        });
}
function calall(){
      var total_qty = 0;

      $(".table-cart tbody tr").each(function(){
          var qty = $(this).closest('tr').find('.line-qty').val();
          
         if(qty == '' || qty == null){
             qty = 0;
         }
        // alert("qty "+qty+" price "+price);
          
          total_qty = total_qty + parseFloat(qty);
      });

      // $(".table-cart tfoot tr").find('td:eq(1)').html(total_qty);
      // $(".table-cart tfoot tr").find('td:eq(3)').html(addCommas(total_price));
      // $(".total-text-top").html(addCommas(total_price));
       $(".total-qty").html(addCommas(total_qty));

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

$this->registerJs($js,static::POS_END);
?>
