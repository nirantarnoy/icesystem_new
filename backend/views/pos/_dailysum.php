<?php

use kartik\grid\GridView;
use yii\helpers\Html;
use yii\widgets\LinkPager;

$this->title = 'สรุปยอดขายประจำวัน';

?>
<form action="<?=\yii\helpers\Url::to(['pos/dailysum'],true)?>" method="post">
    <div class="row">

        <div class="col-lg-3">
            <div class="label">เลือกดูตามวันที่</div>
            <div class="input-group">
                <?php
                echo \kartik\date\DatePicker::widget([
                    'name' => 'pos_date',
                    'value' => date('d/m/Y'),
                    'pluginOptions' => [
                        'format' => 'dd/mm/yyyy',
                        'todayHighlight' => true
                    ]
                ]);
                ?>
            </div>

        </div>
        <div class="col-lg-2">
            <div class="label" style="color: white">ค้นหา</div>
            <input type="submit" class="btn btn-primary" value="ค้นหา"></input>
        </div>

    </div>
</form>
<br/>
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
            'showPageSummary' => true,
            'striped' => true,
            'hover' => true,
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
                [
                    'attribute' => 'code',
                    'label' => 'รหัสสินค้า'
                ],
                [
                    'attribute' => 'name',
                    'label' => 'ชื่อสินค้า'
                ],
                [
                    'attribute' => 'qty',
                    'label' => 'รวมจำนวน',
                    'headerOptions' => ['style' => 'text-align: right'],
                    'contentOptions' => ['style' => 'text-align: right'],
                    'value' => function ($data) {
                        return $data->qty;
                    },
                    'format' => ['decimal', 0],
                    'pageSummary' => true,
                    'pageSummaryFunc' => GridView::F_SUM,
                    'pageSummaryOptions' => ['class' => 'text-right', 'style' => 'background-color: #6699FF'],
                ],
                [
                    'attribute' => 'line_total',
                    'label' => 'ยอดขายรวม',
                    'headerOptions' => ['style' => 'text-align: right'],
                    'contentOptions' => ['style' => 'text-align: right'],
                    'value' => function ($data) {
                        return $data->line_total;
                    },
                    'format' => ['decimal', 0],
                    'pageSummary' => true,
                    'pageSummaryFunc' => GridView::F_SUM,
                    'pageSummaryOptions' => ['class' => 'text-right', 'style' => 'background-color: #6699FF'],
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
            'showPageSummary' => true,
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
                    'contentOptions' => ['style' => 'text-align: center;'],
                    'footerOptions' => ['style' => 'background: white'],
                ],
                [
                    'attribute' => 'code',
                    'label' => 'รหัส',
                    'pageSummaryOptions' => ['class' => 'text-right', 'style' => 'background-color: '],
                ],
                [
                    'attribute' => 'name',
                    'label' => 'ประเภทชำระเงิน',
                    'pageSummary' => false,
                    'pageSummaryOptions' => ['class' => 'text-right', 'style' => 'background-color: '],
                ],
                [
                    'attribute' => 'payment_amount',
                    'label' => 'ยอดขายรวม',
                    'headerOptions' => ['style' => 'text-align: right'],
                    'contentOptions' => ['style' => 'text-align: right'],
                    'value' => function ($data) {
                        return $data->payment_amount;
                    },
                    'format' => ['decimal', 0],
                    'pageSummary' => true,
                    'pageSummaryFunc' => GridView::F_SUM,
                    'pageSummaryOptions' => ['class' => 'text-right', 'style' => 'background-color: #6699FF'],
                ]
            ],
            'pager' => ['class' => LinkPager::className()],
        ]); ?>
    </div>
    <div class="col-lg-2"></div>
    <div class="col-lg-6">
        <div class="btn btn-success"><i class="fa fa-check"></i> ตรวจสอบยืนยันรายการ</div>
        <p><small>หมายเหตุ: </small><small class="text-danger">กรุณาตรวจสอบข้อมูลให้ครบถ้วนก่อนการยืนยันยอดการทำรายการก่อนส่งยอด</small>
        </p>
    </div>
</div>
