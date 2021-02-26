<?php

use yii\helpers\Html;
use kartik\grid\GridView;

$this->title = 'ประวัติการขาย POS';

?>
<div class="row">
    <div class="col-lg-12">
        <a href="index.php?r=pos/index" class="btn btn-primary"><i class="fa fa-arrow-left"></i> กลับหน้า POS </a>
    </div>
</div>
<div style="height: 5px;"></div>
<div class="row">
    <div class="col-lg-12">
        <?= GridView::widget([
            'dataProvider' => $dataProvider,
            // 'filterModel' => $searchModel,
            'emptyCell' => '-',
            'layout' => "{items}\n{summary}\n<div class='text-center'>{pager}</div>",
            'summary' => "แสดง {begin} - {end} ของทั้งหมด {totalCount} รายการ",
            'showOnEmpty' => false,
            //    'bordered' => true,
            //     'striped' => false,
            //    'hover' => true,
            'id' => 'product-grid',
            //'tableOptions' => ['class' => 'table table-hover'],
            'emptyText' => '<div style="color: red;text-align: center;"> <b>ไม่พบรายการไดๆ</b> <span> เพิ่มรายการโดยการคลิกที่ปุ่ม </span><span class="text-success">"สร้างใหม่"</span></div>',
            'columns' => [
                [
                    'class' => 'yii\grid\SerialColumn',
                    'headerOptions' => ['style' => 'text-align: center'],
                    'contentOptions' => ['style' => 'text-align: center'],
                ],
                'order_no',
                [
                    'attribute' => 'order_date',
                    'value' => function ($data) {
                        return date('d/m/Y', strtotime($data->order_date));
                    }
                ],
                [
                    'attribute' => 'customer_id',
                    'value' => function ($data) {
                        return \backend\models\Customer::findName($data->customer_id);
                    }
                ],
//            'customer_type',
//            'customer_name',
//                [
//                    'attribute' => 'order_channel_id',
//                    'value' => function ($data) {
//                        return \backend\models\Deliveryroute::findName($data->order_channel_id);
//                    }
//                ],
                [
                    'label' => 'เครดิต/เชื่อ',
                    'headerOptions' => ['style' => 'text-align: right'],
                    'contentOptions' => ['style' => 'text-align: right'],
                    'value' => function ($data) {
                        return number_format(\backend\models\Orders::findordercredit($data->id));
                    }
                ],
                [
                    'label' => 'สด',
                    'headerOptions' => ['style' => 'text-align: right'],
                    'contentOptions' => ['style' => 'text-align: right'],
                    'value' => function ($data) {
                        return number_format(\backend\models\Orders::findordercash($data->id));
                    }
                ],
                [
                    'attribute' => 'order_total_amt',
                    'headerOptions' => ['style' => 'text-align: right'],
                    'contentOptions' => ['style' => 'text-align: right'],
                    'value' => function ($data) {
                        return number_format($data->order_total_amt);
                    }
                ],
                //'vat_per',
                //'order_total_amt',
                //'emp_sale_id',
                //'car_ref_id',
                //'order_channel_id',
                [
                    'attribute' => 'status',
                    'format' => 'raw',
                    'headerOptions' => ['style' => 'text-align: center'],
                    'contentOptions' => ['style' => 'text-align: center'],
                    'value' => function ($data) {
                        if ($data->status == 1) {
                            return '<div class="badge badge-success">Open</div>';
                        } else {
                            return '<div class="badge badge-secondary">Closed</div>';
                        }
                    }
                ],
                //'company_id',
                //'branch_id',
                //'created_at',
                //'updated_at',
                //'created_by',
                //'updated_by',

                [

                    'header' => 'ตัวเลือก',
                    'headerOptions' => ['style' => 'text-align:center;', 'class' => 'activity-view-link',],
                    'class' => 'yii\grid\ActionColumn',
                    'contentOptions' => ['style' => 'text-align: center'],
                    'template' => '{print}{update}{delete}',
                    'buttons' => [
                        'print' => function ($url, $data, $index) {
                            $options = [
                                'title' => Yii::t('yii', 'Print'),
                                'aria-label' => Yii::t('yii', 'Print'),
                                'data-pjax' => '0',
                            ];
                            return Html::a(
                                '<span class="fas fa-print btn btn-xs btn-default"></span>', $url, $options);
                        },
                        'update' => function ($url, $data, $index) {
                            $options = array_merge([
                                'title' => Yii::t('yii', 'Update'),
                                'aria-label' => Yii::t('yii', 'Update'),
                                'data-pjax' => '0',
                                'id' => 'modaledit',
                            ]);
                            return Html::a(
                                '<span class="fas fa-edit btn btn-xs btn-default"></span>', null, [
                                'id' => 'activity-view-link',
                                //'data-toggle' => 'modal',
                                // 'data-target' => '#modal',
                                'data-id' => $data->id,
                                'data-pjax' => '0',
                                'onclick' => 'showorderedit($(this))'
                                // 'style'=>['float'=>'rigth'],
                            ]);
                        },
                        'delete' => function ($url, $data, $index) {
                            $options = array_merge([
                                'title' => Yii::t('yii', 'Delete'),
                                'aria-label' => Yii::t('yii', 'Delete'),
                                //'data-confirm' => Yii::t('yii', 'Are you sure you want to delete this item?'),
                                //'data-method' => 'post',
                                //'data-pjax' => '0',
                                'data-url' => $url,
                                'data-var' => $data->id,
                                'onclick' => 'recDelete($(this));'
                            ]);
                            return Html::a('<span class="fas fa-trash-alt btn btn-xs btn-default"></span>', 'javascript:void(0)', $options);
                        }
                    ]
                ],
            ],
        ]); ?>
    </div>
</div>

<div id="poseditModal" class="modal fade" role="dialog">
    <div class="modal-dialog modal-xl">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header" style="background-color: #2b669a">
                <div class="row" style="text-align: center;width: 100%;color: white">
                    <div class="col-lg-12">
                        <span><h3 class="popup-payment" style="color: white"><i class="fa fa-shopping-cart"></i> แก้ไขรายการขาย</h3></span>
                        <input type="hidden" class="popup-product-id" value="">
                        <input type="hidden" class="popup-product-code" value="">
                    </div>
                </div>

            </div>
            <!--            <div class="modal-body" style="white-space:nowrap;overflow-y: auto">-->
            <!--            <div class="modal-body" style="white-space:nowrap;overflow-y: auto;scrollbar-x-position: top">-->

            <div class="modal-body">
                <div class="row">
                    <div class="col-lg-6">
                        <h5>เลขที่ขาย <small>
                                <div class="badge badge-warning txt-order-no"></div>
                            </small></h5>
                    </div>
                    <div class="col-lg-6" style="border-left: 1px dashed black">
                        <h5>ลูกค้า <small>
                                <div class="badge badge-warning txt-customer-name">ป้าไพ</div>
                            </small></h5>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-6">
                        <h5>วันที่ <small>
                                <div class="badge badge-warning txt-order-date">26/02/2021</div>
                            </small></h5>
                    </div>
                    <div class="col-lg-6" style="border-left: 1px dashed black">
                        <h5>วิธีชำระเงิน <small>
                                <div class="badge badge-success txt-payment-method">เงินสด</div>
                            </small></h5>
                    </div>
                </div>
                <br>
                <div class="row">
                    <div class="col-lg-12">
                        <table class="table table-bordered table-striped table-order-history">
                            <thead>
                            <tr>
                                <th style="text-align: center;width: 10%">รหัสสินค้า</th>
                                <th style="text-align: center;">ชื่อสินค้า</th>
                                <th style="text-align: right;width: 15%">จำนวน</th>
                                <th style="text-align: right;width: 15%">ราคา</th>
                                <th style="text-align: right;width: 15%">ยอดรวม</th>
                            </tr>
                            </thead>
                            <tbody>

                            </tbody>
                            <tfoot>
                            <tr>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                            </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-outline-success btn-pos-edit-submit" data-dismiss="modalx"><i
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
$url_to_find_item = \yii\helpers\Url::to(['pos/orderedit'], true);
$js = <<<JS
 $(function(){
     
 });
function showorderedit(e){
    var ids = e.attr("data-id");
    if(ids){
        $.ajax({
              'type':'post',
              'dataType': 'json',
              'url': "$url_to_find_item",
              'data': {'order_id': ids},
              'success': function(data) {
                  //  alert(data);
                   if(data.length > 0){
                        //alert();
                        $(".txt-order-no").html(data[0]['order_no']);
                        $(".txt-order-date").html(data[0]['order_date']);
                        $(".txt-customer-name").html(data[0]['customer_name']);
                        $(".txt-payment-method").html(data[0]['payment_data']);
                        $(".table-order-history tbody").html(data[0]['html']);
                        $("#poseditModal").modal("show");
                   }
                 }
              });
        
    }
}
JS;
$this->registerJs($js, static::POS_END);
?>
