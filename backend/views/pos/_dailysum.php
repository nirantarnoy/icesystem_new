<?php

use kartik\grid\GridView;
use yii\helpers\Html;
use yii\widgets\LinkPager;

$this->title = 'สรุปยอดขายประจำวัน';

?>
<div class="row">
    <div class="col-lg-12">
        <h4 class="text-success">รายการขาย</h4>
    </div>
</div>
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
            'emptyText' => '<div style="color: red;text-align: center;"> <b>ไม่พบรายการไดๆ</b></div>',
            'columns' => [
                [
                    'class' => 'yii\grid\SerialColumn',
                    'headerOptions' => ['style' => 'text-align: center'],
                    'contentOptions' => ['style' => 'text-align: center'],
                ],
                'code',
                'name',
                [
                    'attribute' => 'qty',
                    'headerOptions' => ['style' => 'text-align: right'],
                    'contentOptions' => ['style' => 'text-align: right'],
                    'value' => function ($data) {
                        return number_format($data->qty);
                    }
                ],
                [
                    'attribute' => 'line_total',
                    'headerOptions' => ['style' => 'text-align: right'],
                    'contentOptions' => ['style' => 'text-align: right'],
                    'value' => function ($data) {
                        return number_format($data->line_total);
                    },
                    'format' => ['decimal', 0],
                    'pageSummary' => true,
                    'pageSummaryFunc' => GridView::F_SUM
                ],
            ],
            'pager' => ['class' => LinkPager::className()],
        ]); ?>
    </div>
</div>

<br>
<div class="row">
    <div class="col-lg-12">
        <h4 class="text-success">ประเภทชำระเงิน</h4>
    </div>
</div>
<div class="row">
    <div class="col-lg-4">
        <?= GridView::widget([
            'dataProvider' => $dataProvider2,
            // 'filterModel' => $searchModel,
            'emptyCell' => '-',
            'layout' => "{items}\n{summary}\n<div class='text-center'>{pager}</div>",
            'summary' => "แสดง {begin} - {end} ของทั้งหมด {totalCount} รายการ",
            'showOnEmpty' => false,
            //    'bordered' => true,
            //     'striped' => false,
            //    'hover' => true,
            'id' => 'pos-pay',
            //'tableOptions' => ['class' => 'table table-hover'],
            'emptyText' => '<div style="color: red;text-align: center;"> <b>ไม่พบรายการไดๆ</b></div>',
            'columns' => [
                [
                    'class' => 'yii\grid\SerialColumn',
                    'headerOptions' => ['style' => 'text-align: center'],
                    'contentOptions' => ['style' => 'text-align: center'],
                ],
                'code',
                [
                    'attribute' => 'payment_amount',
                    'headerOptions' => ['style' => 'text-align: right'],
                    'contentOptions' => ['style' => 'text-align: right'],
                    'value' => function ($data) {
                        return number_format($data->payment_amount);
                    }
                ]
            ],
            'pager' => ['class' => LinkPager::className()],
        ]); ?>
    </div>
    <div class="col-lg-2"></div>
    <div class="col-lg-6">
        <div class="btn btn-success"><i class="fa fa-check"></i> ตรวจสอบยืนยันรายการ</div>
        <p><small>หมายเหตุ: </small><small class="text-danger">กรุณาตรวจสอบข้อมูลให้ครบถ้วนก่อนการยืนยันยอดการทำรายการก่อนส่งยอด</small></p>
    </div>
</div>
