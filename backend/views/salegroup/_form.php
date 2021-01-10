<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

$prod_status = \backend\helpers\ProductStatus::asArrayObject();
?>

<div class="salegroup-form">

    <?php $form = ActiveForm::begin(); ?>

    <div class="row">
        <div class="col-lg-1">

        </div>
        <div class="col-lg-10">
            <?= $form->field($model, 'code')->textInput(['maxlength' => true]) ?>

            <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

            <label for=""><?= $model->getAttributeLabel('status') ?></label>
            <select name="status" class="form-control status" id=""
                    onchange="">
                <?php for($i=0;$i<=count($prod_status)-1;$i++): ?>
                    <?php
                    $selected = '';
                    if ($prod_status[$i]['id'] == $model->status)
                        $selected = 'selected';
                    ?>
                    <option value="<?= $prod_status[$i]['id'] ?>" <?= $selected ?>><?= $prod_status[$i]['name'] ?></option>
                <?php endfor; ?>
            </select>
            <br>
            <div class="form-group">
                <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success']) ?>
            </div>
        </div>
    </div>
    <?php ActiveForm::end(); ?>

</div>
