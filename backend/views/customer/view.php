<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\Customer */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'ลูกค้า'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="customer-view">

    <p>
        <?= Html::a(Yii::t('app', 'Update'), ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a(Yii::t('app', 'Delete'), ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => Yii::t('app', 'Are you sure you want to delete this item?'),
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <div class="row">
        <div class="col-lg-6">
            <?= DetailView::widget([
                'model' => $model,
                'attributes' => [
                    //  'id',
                    'code',
                    'name',
                    'description',
                    [
                        'attribute' => 'customer_group_id',
                        'value' => function ($data) {
                            return \backend\models\Customergroup::findName($data->customer_group_id);
                        }
                    ],
                    [
                        'attribute' => 'customer_type_id',
                        'value' => function ($data) {
                            return \backend\models\Customertype::findName($data->customer_type_id);
                        },
                    ],
                    [
                        'attribute' => 'delivery_route_id',
                        'value' => function ($data) {
                            return \backend\models\Deliveryroute::findName($data->delivery_route_id);
                        }
                    ],

                ],
            ]) ?>
        </div>
        <div class="col-lg-6">
            <?= DetailView::widget([
                'model' => $model,
                'attributes' => [

                    'location_info',
                    'active_date',
                    'logo',
                    'shop_photo',
                    [
                        'attribute' => 'status',
                        'format' => 'raw',
                        'value' => function ($data) {
                            if ($data->status == 1) {
                                return '<div class="badge badge-success">ใช้งาน</div>';
                            } else {
                                return '<div class="badge badge-secondary">ไม่ใช้งาน</div>';
                            }
                        }
                    ],
//            'company_id',
//            'branch_id',
//            'created_at',
//            'updated_at',
//            'created_by',
//            'updated_by',
                ],
            ]) ?>
        </div>
    </div>
    <br />
    <div class="row">
        <div class="col-lg-12">
            <ul class="nav nav-tabs" id="custom-tabs-one-tab" role="tablist">
                <li class="nav-item">
                    <a class="nav-link active" id="custom-tabs-sale" data-toggle="pill"
                       href="#custom-tabs-one-home" role="tab" aria-controls="custom-tabs-one-home"
                       aria-selected="true" data-var="" onclick="updatetab($(this))">
                        ประวัติการขาย
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="custom-tabs-history" data-toggle="pill"
                       href="#custom-tabs-one-home" role="tab" aria-controls="custom-tabs-one-home"
                       aria-selected="true" data-var="" onclick="updatetab($(this))">
                        ประวัติการชำระเงิน
                    </a>
                </li>
            </ul>
        </div>
    </div>
</div>
