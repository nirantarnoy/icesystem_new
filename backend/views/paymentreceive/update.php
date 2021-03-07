<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\Paymentreceive */

$this->title = 'แก้ไขรายการชำระ: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'ชำระหนี้', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="paymentreceive-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
