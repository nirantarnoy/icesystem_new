<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\StocksumSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="stocksum-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
        'options' => [
            'data-pjax' => 1
        ],
    ]); ?>

    <div class="input-group">

        <?= $form->field($model, 'warehouse_id')->widget(\kartik\select2\Select2::className(), [
            'data' => \yii\helpers\ArrayHelper::map(\backend\models\Warehouse::find()->all(), 'id', function ($data) {
                return $data->code . ' ' . $data->name;
            }),
            'options' => [
                'placeholder' => '--เลือกคลังสินค้า--',
                'onchange' => 'this.form.submit();'
            ],
            'pluginOptions' => [
                'allowClear' => true,
            ]
        ])->label(false) ?>
        <span style="margin-left: 5px;"></span>
        <?= $form->field($model, 'product_id')->widget(\kartik\select2\Select2::className(), [
            'data' => \yii\helpers\ArrayHelper::map(\backend\models\Product::find()->all(), 'id', function ($data) {
                return $data->code . ' ' . $data->name;
            }),
            'options' => [
                'placeholder' => '--เลือกสินค้า--',
                'onchange' => 'this.form.submit();'
            ],
            'pluginOptions' => [
                'allowClear' => true,
            ]
        ])->label(false) ?>
    </div>
    <?php ActiveForm::end(); ?>

</div>
