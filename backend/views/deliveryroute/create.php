<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\Deliveryroute */

$this->title = Yii::t('app', 'Create Deliveryroute');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Deliveryroutes'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="deliveryroute-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
