<?php

use kartik\select2;
use kartik\grid\GridView;
use yii\helpers\ArrayHelper;


$this->title = "ลูกค้าค้างชำระ";

$company_id = 1;
$branch_id = 1;
if (!empty(\Yii::$app->user->identity->company_id)) {
    $company_id = \Yii::$app->user->identity->company_id;
}
if (!empty(\Yii::$app->user->identity->branch_id)) {
    $branch_id = \Yii::$app->user->identity->branch_id;
}
?>

<br/>
<?php echo $this->render('_customerloan_search', ['model' => $searchModel, 'company_id'=>$company_id,'branch_id'=>$branch_id]); ?>

<div class="row">
    <div class="col-lg-12">
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
            'panel' => ['type' => 'info', 'heading' => 'แสดงรายการลูกค้าค้างชำระ'],
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
                    'attribute' => 'car_ref_id',
                    'label' => 'รถคันที่',
                    'width' => '10%',
                    'value' => function ($model, $key, $index, $widget) {
                        return $model->car_name;
                    },
                    'filterType' => GridView::FILTER_SELECT2,
                    'filter' => ArrayHelper::map(\backend\models\Car::find()->where(['company_id' => $company_id, 'branch_id' => $branch_id])->orderBy('name')->asArray()->all(), 'id', 'name'),
                    'filterWidgetOptions' => [
                        'pluginOptions' => ['allowClear' => true],
                    ],
                    'filterInputOptions' => ['placeholder' => '--เลือกรถ--'],
                    'group' => true,  // enable grouping,
                    'groupHeader' => function ($model, $key, $index, $widget) { // Closure method
                        return [
                            'mergeColumns' => [[1, 4]], // columns to merge in summary
                            'content' => [             // content to show in each summary cell
                                1 => 'ยอดรวมรถ (' . $model->car_name . ')',
                                4 => GridView::F_SUM,
                                5 => GridView::F_SUM,
                                6 => GridView::F_SUM,
                                7 => GridView::F_SUM,
                            ],
                            'contentFormats' => [      // content reformatting for each summary cell
                                //4 => ['format' => 'number', 'decimals' => 0],
                                4 => ['format' => 'number', 'decimals' => 0],
                                5 => ['format' => 'number', 'decimals' => 0],
                                6 => ['format' => 'number', 'decimals' => 0],
                                7 => ['format' => 'number', 'decimals' => 0],
                            ],
                            'contentOptions' => [      // content html attributes for each summary cell
                                1 => ['style' => 'font-variant:small-caps'],
                                //4 => ['style' => 'text-align:right'],
                                4 => ['style' => 'text-align:right'],
                                5 => ['style' => 'text-align:right'],
                                6 => ['style' => 'text-align:right'],
                                7 => ['style' => 'text-align:right'],
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
                    'label' => 'ลูกค้า',
                    'width' => '10%',
                    'value' => function ($model, $key, $index, $widget) {
                        return $model->cus_name;
                    },
                    'filterType' => GridView::FILTER_SELECT2,
                    'filter' => ArrayHelper::map(\backend\models\Customer::find()->where(['company_id' => $company_id, 'branch_id' => $branch_id])->orderBy('name')->asArray()->all(), 'id', 'name'),
                    'filterWidgetOptions' => [
                        'pluginOptions' => ['allowClear' => true],
                    ],
                    'filterInputOptions' => ['placeholder' => '--เลือกลูกค้า--'],

//            'groupedRow' => true,                    // move grouped column to a single grouped row
//            'groupOddCssClass' => 'kv-grouped-row',  // configure odd group cell css class
//            'groupEvenCssClass' => 'kv-grouped-row', // configure even group cell css class
                ],
//                [
//                    'attribute' => 'customer_type_id',
//                    'label' => 'ประเภทลูกค้า',
//                   // 'width' => '10%',
//                    'value' => function ($model, $key, $index, $widget) {
//                        return \backend\models\Customertype::findName($model->customer_type_id);
//                    },
//                    'filterType' => GridView::FILTER_SELECT2,
//                    'filter' => ArrayHelper::map(\backend\models\Customertype::find()->where(['company_id' => $company_id, 'branch_id' => $branch_id])->orderBy('name')->asArray()->all(), 'id', 'name'),
//                    'filterWidgetOptions' => [
//                        'pluginOptions' => ['allowClear' => true],
//                    ],
//                    'filterInputOptions' => ['placeholder' => '--เลือกประเภทลูกค้า--'],
//                    'group' => true,  // enable grouping
//                    'subGroupOf' => 2 // supplier column index is the parent group
//                ],
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
                    'attribute' => 'order_date',
                    'width' => '10%',
                    'value' => function ($model, $key, $index, $widget) {
                        return date('d/m/Y', strtotime($model->order_date));
                    },
                ],
                [
                    'attribute' => 'order_no',
                    'label' => 'เลขที่ขาย',
                    'width' => '10%',
                    'headerOptions' => ['style' => 'text-align: center'],
                    'contentOptions' => ['style' => 'text-align: center'],
                    // 'pageSummary' => 'Page Summary',
                ],
                [
                    'attribute' => 'line_total',
                    'label' => 'มูลค่า',
                    'headerOptions' => ['style' => 'text-align: right'],
                    'contentOptions' => ['style' => 'text-align: right'],
                    'width' => '150px',
                    'hAlign' => 'right',
                    'format' => ['decimal', 2],
                    'pageSummary' => true,
                    'pageSummaryFunc' => GridView::F_SUM
                ],
                [
                    'attribute' => 'payment_amount',
                    'label' => 'รับชำระ',
                    'headerOptions' => ['style' => 'text-align: right'],
                    'contentOptions' => ['style' => 'text-align: right'],
                    'width' => '150px',
                    'hAlign' => 'right',
                    'format' => ['decimal', 0],
                    'pageSummary' => true,
                    'pageSummaryFunc' => GridView::F_SUM
                ],
                [
                    'label' => 'ค้างชำระ',
                    'headerOptions' => ['style' => 'text-align: right'],
                    'contentOptions' => ['style' => 'text-align: right'],
                    'value' => function ($model, $key, $index, $widget) {
                        return ($model->line_total - $model->payment_amount);
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
    </div>
</div>
