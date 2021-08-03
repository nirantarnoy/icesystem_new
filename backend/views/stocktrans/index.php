<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\StocktransSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'ประวัติรับสินค้าเข้า-ออก คลัง';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="stocktrans-index">
    <?php Pjax::begin(); ?>
    <?php echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        //'filterModel' => $searchModel,
        'showPageSummary' => true,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn',
                'headerOptions' => ['style' => 'text-align: center'],
                'contentOptions' => ['style' => 'text-align: center'],],
            //  'id',
//            'company_id',
//            'branch_id',
            'journal_no',
            [
                'attribute' => 'trans_date',
                'value' => function ($data) {
                    return date('d/m/Y H:i:s', strtotime($data->trans_date));
                }
            ],
            [
                'attribute' => 'product_id',
                'value' => function ($data) {
                    return \backend\models\Product::findName($data->product_id);
                }
            ],
            [
                'attribute' => 'warehouse_id',
                'value' => function ($data) {
                    return \backend\models\Warehouse::findName($data->warehouse_id);
                }
            ],
            //'location_id',
            //'lot_no',
            [
                'attribute' => 'qty',
                'headerOptions' => ['style' => 'text-align: right'],
                'contentOptions' => ['style' => 'text-align: right'],
                'value' => function ($data) {
                    return number_format($data->qty);
                },
                'pageSummary' => true,
                'pageSummaryFunc' => GridView::F_SUM
            ],
            [
                'attribute' => 'stock_type',
                'format' => 'html',
                'headerOptions' => ['style' => 'text-align: center'],
                'contentOptions' => ['style' => 'text-align: center'],
                'value' => function ($data) {
                    if ($data->stock_type == 1) {
                        return '<div class="badge badge-success">IN</div>';
                    } else if ($data->stock_type == 2) {
                        return '<div class="badge badge-danger">OUT</div>';
                    }
                }
            ],
            [
                'attribute' => 'activity_type_id',
                'headerOptions' => ['style' => 'text-align: left'],
                'contentOptions' => ['style' => 'text-align: left'],
                'value' => function ($data) {
                   // return \backend\helpers\ActivityType::getTypeById($data->activity_type_id);
                    return \backend\helpers\RunnoTitle::getTypeById($data->activity_type_id);
                }
            ],
            [
                'attribute' => 'created_by',
                'label'=>'พนักงาน',
                'headerOptions' => ['style' => 'text-align: center'],
                'contentOptions' => ['style' => 'text-align: center'],
                'value' => function ($data) {
                    return \backend\models\User::findName($data->created_by);
                }
            ],

            //'location_id',
            //'lot_no',
//            [
//                'attribute' => 'updated_at',
//                'value' => function ($data) {
//                    return date('d/m/Y H:i:s');
//                }
//            ],
            //'created_by',

            // ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

    <?php Pjax::end(); ?>

</div>
