<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel backend\models\StocksumSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'สินค้าคงคลัง';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="stocksum-index">
<!--    <p>-->
<!--        --><?php ////echo Html::a('Create Stocksum', ['create'], ['class' => 'btn btn-success']) ?>
<!--    </p>-->

    <?php Pjax::begin(); ?>
    <?php  echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
       // 'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

           // 'id',
//            'company_id',
//            'branch_id',
            [
                    'attribute' => 'product_id',
                    'value' => function($data){
                      return \backend\models\Product::findName();
                    }
            ],
            'warehouse_id',
            'qty',
            //'location_id',
            //'lot_no',
            'updated_at',
            //'created_at',

         //   ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

    <?php Pjax::end(); ?>

</div>
