<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
$prod_status = \backend\helpers\ProductStatus::asArrayObject();
$company_data = \backend\models\Company::find()->all();
?>

<div class="branch-form">

    <?php $form = ActiveForm::begin(); ?>

    <div class="row">
        <div class="col-lg-1"></div>
        <div class="col-lg-10">
            <label for=""><?= $model->getAttributeLabel('company_id') ?></label>
            <select name="company_id" class="form-control company-id" id=""
                    onchange="">
                <option value="0">--เลือกบริษัท-</option>
                <?php foreach ($company_data as $val2): ?>
                    <?php
                    $selected = '';
                    if ($val2->id == $model->company_id)
                        $selected = 'selected';
                    ?>
                    <option value="<?= $val2->id ?>" <?= $selected ?>><?= $val2->name ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="col-lg-1"></div>
    </div>
    <div style="height: 10px;"></div>
    <div class="row">
        <div class="col-lg-1"></div>
        <div class="col-lg-10">
            <?= $form->field($model, 'code')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-lg-1"></div>
    </div>

    <div class="row">
        <div class="col-lg-1"></div>
        <div class="col-lg-10">
            <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-lg-1"></div>
    </div>
    <div class="row">
        <div class="col-lg-1"></div>
        <div class="col-lg-10">
            <?= $form->field($model, 'description')->textarea(['maxlength' => true]) ?>
        </div>
        <div class="col-lg-1"></div>
    </div>
    <div class="row">
        <div class="col-lg-1"></div>
        <div class="col-lg-3">
            <label for=""><?= $model->getAttributeLabel('status') ?></label>
            <select name="status" class="form-control status" id=""
                    onchange="">
                <?php for ($i = 0; $i <= count($prod_status) - 1; $i++): ?>
                    <?php
                    $selected = '';
                    if ($prod_status[$i]['id'] == $model->status)
                        $selected = 'selected';
                    ?>
                    <option value="<?= $prod_status[$i]['id'] ?>" <?= $selected ?>><?= $prod_status[$i]['name'] ?></option>
                <?php endfor; ?>
            </select>
        </div>
        <div class="col-lg-8"></div>
    </div>
    <br>
    <div class="row">
        <div class="col-lg-1"></div>
        <div class="col-lg-3">
            <?php if (1>0): ?>
                <div class="form-group">
                    <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success']) ?>
                </div>
            <?php endif; ?>

        </div>
        <div class="col-lg-8"></div>
    </div>


    <br>

    <?php ActiveForm::end(); ?>

</div>
