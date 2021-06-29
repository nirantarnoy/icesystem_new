<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\widgets\Pjax;
use yii\helpers\Url;
use yii\widgets\LinkPager;

$this->title = 'สรุปแผนผลิต';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="plan-index">
    <?php Pjax::begin(); ?>
    <div class="row">
        <div class="col-lg-10">
            <p>
                <?= Html::a(Yii::t('app', '<i class="fa fa-plus"></i> สร้างใหม่'), ['create'], ['class' => 'btn btn-success']) ?>
            </p>
        </div>
        <div class="col-lg-2"
             style="text-align: right">
            <form id="form-perpage"
                  class="form-inline"
                  action="<?= Url::to(['plan/calsummary'], true) ?>"
                  method="post">
                <div class="form-group">
                    <label>แสดง </label>
                    <select class="form-control"
                            name="perpage"
                            id="perpage">
                        <option value="20" <?= $perpage == '20' ? 'selected' : '' ?>>
                            20
                        </option>
                        <option value="50" <?= $perpage == '50' ? 'selected' : '' ?> >
                            50
                        </option>
                        <option value="100" <?= $perpage == '100' ? 'selected' : '' ?>>
                            100
                        </option>
                    </select>
                    <label>
                        รายการ</label>
                </div>
            </form>
        </div>
    </div>
    <?php echo $this->render('_summary_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        // 'filterModel' => $searchModel,
        'showPageSummary' => true,
        'pjax' => true,
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
        'toggleDataContainer' => ['class' => 'btn-group mr-2'],
        'emptyText' => '<div style="color: red;text-align: center;"> <b>ไม่พบรายการไดๆ</b> <span> เพิ่มรายการโดยการคลิกที่ปุ่ม </span><span class="text-success">"สร้างใหม่"</span></div>',
        'columns' => [
//            [
//                'attribute' => 'trans_date',
//                'width' => '10%',
//                'value' => function ($model, $key, $index, $widget) {
//                    return date('d/m/Y', strtotime($model->trans_date));
//                },
//                'group' => true,
//            ],
            [
                'attribute' => 'code',
                'group' => true,
            ],
            'name',

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
                'class' => '\kartik\grid\ExpandRowColumn',
                'value' => function ($model, $key, $index, $column) {
                    return GridView::ROW_EXPANDED;
                },
                //'detailUrl' => Yii::$app->request->getBaseUrl() . '..../expand-view',
                'detail' => function ($model, $key, $index, $column) {
                    return Yii::$app->controller->renderPartial('_expand-row-details', ['product_id' => $model->product_id]);
                },
                'headerOptions' => ['class' => 'kartik-sheet-style'],
                'expandOneOnly' => true
            ],

        ],
        'pager' => ['class' => LinkPager::className()],
    ]); ?>

    <?php Pjax::end(); ?>

</div>
