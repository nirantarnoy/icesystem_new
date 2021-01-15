<?php

use kartik\grid\GridView;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;

$this->title = 'รายงานยอดขาย';

?>


<?php
echo GridView::widget([
    'dataProvider' => $dataProvider,
    'filterModel' => $searchModel,
    'showPageSummary' => true,
    'pjax' => true,
    'striped' => true,
    'hover' => true,
    'options' => [
        'style' => 'font-size: 14px;'
    ],
    'toolbar' => [
//        [
//            'content' =>
//               '<input type="text" class="form-control">' . ' '.
//                Html::a('<i class="fas fa-search"></i>', '', [
//                    'class' => 'btn btn-outline-secondary',
//                    'title'=>Yii::t('app', 'Reset Grid'),
//                    'data-pjax' => 0,
//                ]),
//            'options' => ['class' => 'btn-group mr-2']
//        ],
        '{toggleData}',
        '{export}',

    ],
    'panel' => ['type' => 'info', 'heading' => 'รายงานแสดงยอดขายแยกตามสายส่ง'],
    'toggleDataContainer' => ['class' => 'btn-group mr-2'],
    'columns' => [
        ['class' => 'kartik\grid\SerialColumn'],
//        [
//            'class' => '\kartik\grid\ExpandRowColumn',
//            'value' => function ($model, $key, $index, $column) {
//                return GridView::ROW_COLLAPSED;
//            },
//            //'detailUrl' => Yii::$app->request->getBaseUrl() . '..../expand-view',
//            'detail' => function ($model, $key, $index, $column) {
//                return Yii::$app->controller->renderPartial('_expand-row-details', ['model' => $model]);
//            },
//            'headerOptions' => ['class' => 'kartik-sheet-style'],
//            'expandOneOnly' => true
//        ],
        [
            'attribute' => 'route_code',
            'width' => '10%',
            'value' => function ($model, $key, $index, $widget) {
                return 'สายส่ง ' . $model->route_code;
            },
            'filterType' => GridView::FILTER_SELECT2,
            'filter' => ArrayHelper::map(\backend\models\Deliveryroute::find()->orderBy('name')->asArray()->all(), 'id', 'name'),
            'filterWidgetOptions' => [
                'pluginOptions' => ['allowClear' => true],
            ],
            'filterInputOptions' => ['placeholder' => '--เลือกลูกค้า--'],
            'group' => true,  // enable grouping,
            'groupHeader' => function ($model, $key, $index, $widget) { // Closure method
                return [
                    'mergeColumns' => [[1, 3]], // columns to merge in summary
                    'content' => [             // content to show in each summary cell
                        1 => 'ยอดรวมสายส่ง (' . $model->route_code . ')',
                        4 => GridView::F_SUM,
                        6 => GridView::F_SUM,
//                        7 => GridView::F_SUM,
                    ],
                    'contentFormats' => [      // content reformatting for each summary cell
                        4 => ['format' => 'number', 'decimals' => 0],
                        5 => ['format' => 'number', 'decimals' => 0],
                        6 => ['format' => 'number', 'decimals' => 0],
//                        7 => ['format' => 'number', 'decimals' => 0],
                    ],
                    'contentOptions' => [      // content html attributes for each summary cell
                        1 => ['style' => 'font-variant:small-caps'],
                        4 => ['style' => 'text-align:right'],
                        5 => ['style' => 'text-align:right'],
                        6 => ['style' => 'text-align:right'],
//                        7 => ['style' => 'text-align:right'],
                    ],
                    // html attributes for group summary row
                    'options' => ['class' => 'info table-info', 'style' => 'font-weight:bold;']
                ];
            },
//            'groupedRow' => true,                    // move grouped column to a single grouped row
//            'groupOddCssClass' => 'kv-grouped-row',  // configure odd group cell css class
//            'groupEvenCssClass' => 'kv-grouped-row', // configure even group cell css class
        ],
        [
            'attribute' => 'customer_id',
            'width' => '25%',
            'value' => function ($model, $key, $index, $widget) {
                return \backend\models\Customer::findName($model->customer_id);
            },
            'filterType' => GridView::FILTER_SELECT2,
            'filter' => ArrayHelper::map(\backend\models\Customer::find()->orderBy('name')->asArray()->all(), 'id', 'name'),
            'filterWidgetOptions' => [
                'pluginOptions' => ['allowClear' => true],
            ],
            'filterInputOptions' => ['placeholder' => '--ค้นหาลูกค้า--'],
            'group' => true,  // enable grouping
            'subGroupOf' => 1 // supplier column index is the parent group
        ],
//        [
//            'class' => '\kartik\grid\ExpandRowColumn',
//            'value' => function ($model, $key, $index, $column) {
//                return GridView::ROW_COLLAPSED;
//            },
//            //'detailUrl' => Yii::$app->request->getBaseUrl() . '..../expand-view',
//            'detail' => function ($model, $key, $index, $column) {
//                return Yii::$app->controller->renderPartial('_expand-row-details', ['model' => $model]);
//            },
//            'headerOptions' => ['class' => 'kartik-sheet-style'],
//            'expandOneOnly' => true
//        ],
        [
            'attribute' => 'product_id',
            'value' => function ($model, $key, $index, $widget) {
                return \backend\models\Product::findName($model->product_id);
            },
            'filterType' => GridView::FILTER_SELECT2,
            'filter' => ArrayHelper::map(\backend\models\Product::find()->orderBy('name')->asArray()->all(), 'id', 'name'),
            'filterWidgetOptions' => [
                'pluginOptions' => ['allowClear' => true],
            ],
            'filterInputOptions' => ['placeholder' => '--ค้นสินค้า--'],
            'group' => true,  // enable grouping
            'subGroupOf' => 2 // supplier column index is the parent group
        ],
        [
            'attribute' => 'qty',
            'value' => function ($data) {
                return $data->qty == null ? 0 : $data->qty;
            },
            'headerOptions' => ['style' => 'text-align: right'],
            'contentOptions' => ['style' => 'text-align: right'],
            // 'pageSummary' => 'Page Summary',
            'pageSummaryOptions' => ['class' => 'text-right'],
            'pageSummary' => true,
            'pageSummaryFunc' => GridView::F_SUM
        ],
        [
            'attribute' => 'price',
            'headerOptions' => ['style' => 'text-align: right'],
            'contentOptions' => ['style' => 'text-align: right'],
            'width' => '150px',
            'hAlign' => 'right',
            'format' => ['decimal', 2],
//            'pageSummary' => true,
//            'pageSummaryFunc' => GridView::F_AVG
        ],
        [
            'attribute' => 'line_total',
            'headerOptions' => ['style' => 'text-align: right'],
            'contentOptions' => ['style' => 'text-align: right'],
            'value' => function ($model, $key, $index, $widget) {
                return $model->qty * $model->price;
            },
            'width' => '150px',
            'hAlign' => 'right',
            'format' => ['decimal', 0],
            'pageSummary' => true,
            'pageSummaryFunc' => GridView::F_SUM
        ],
//        [
//            'class' => 'kartik\grid\FormulaColumn',
//            'header' => 'Amount In Stock',
//            'value' => function ($model, $key, $index, $widget) {
//                $p = compact('model', 'key', 'index');
//                return $widget->col(4, $p) * $widget->col(5, $p);
//            },
//            'mergeHeader' => true,
//            'width' => '150px',
//            'hAlign' => 'right',
//            'format' => ['decimal', 2],
//            'pageSummary' => true
//        ],
    ],
]);
?>
