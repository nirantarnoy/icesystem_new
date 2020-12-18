<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\Warehouse */

$this->title = Yii::t('app', 'แก้ไขข้อมูล: {name}', [
    'name' => $model->name,
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Warehouses'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="warehouse-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
