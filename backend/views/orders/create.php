<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\Orders */

$this->title = Yii::t('app', 'สร้างใบขาย');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'ใบสั่งขาย'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="orders-create">
    <?= $this->render('_form', [
        'model' => $model,
        'model_line' => null
    ]) ?>

</div>
