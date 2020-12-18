<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\Customergroup */

$this->title = Yii::t('app', 'Create Customergroup');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Customergroups'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="customergroup-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
