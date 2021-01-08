<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\Pricegroup */

$this->title = Yii::t('app', 'Create Pricegroup');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Pricegroups'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="pricegroup-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
