<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\Cartype */

$this->title = Yii::t('app', 'Create Cartype');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Cartypes'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="cartype-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
