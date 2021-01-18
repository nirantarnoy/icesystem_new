<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\Paymentterm */

$this->title = 'Create Paymentterm';
$this->params['breadcrumbs'][] = ['label' => 'Paymentterms', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="paymentterm-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
