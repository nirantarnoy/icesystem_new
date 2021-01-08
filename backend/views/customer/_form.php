<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

$prod_status = \backend\helpers\ProductStatus::asArrayObject();
$customer_group_data = \backend\models\Customergroup::find()->all();
$customer_type_data= \backend\models\Customertype::find()->all();
$route_data = \backend\models\Deliveryroute::find()->all();
?>

<div class="customer-form">

    <?php $form = ActiveForm::begin(); ?>

    <div class="row">
        <div class="col-lg-4">
            <?= $form->field($model, 'code')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-lg-4">
            <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-lg-4">
            <label for=""><?= $model->getAttributeLabel('customer_group_id') ?></label>
            <select name="customer_group_id" class="form-control customer-group-id" id=""
                    onchange="">
                <option value="0">--เลือกกลุ่มลูกค้า-</option>
                <?php foreach ($customer_group_data as $val2): ?>
                    <?php
                    $selected = '';
                    if ($val2->id == $model->customer_group_id)
                        $selected = 'selected';
                    ?>
                    <option value="<?= $val2->id ?>" <?= $selected ?>><?= $val2->name ?></option>
                <?php endforeach; ?>
            </select>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-4">
            <label for=""><?= $model->getAttributeLabel('customer_type_id') ?></label>
            <select name="customer_type_id" class="form-control customer-type-id" id=""
                    onchange="">
                <option value="0">--เลือกประเภทลูกค้า-</option>
                <?php foreach ($customer_type_data as $val2): ?>
                    <?php
                    $selected = '';
                    if ($val2->id == $model->customer_type_id)
                        $selected = 'selected';
                    ?>
                    <option value="<?= $val2->id ?>" <?= $selected ?>><?= $val2->name ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="col-lg-4">
            <label for=""><?= $model->getAttributeLabel('deivery_route_id') ?></label>
            <select name="deivery_route_id" class="form-control deivery-route-id" id=""
                    onchange="">
                <option value="0">--เลือกเส้นทางขนส่ง-</option>
                <?php foreach ($route_data as $val2): ?>
                    <?php
                    $selected = '';
                    if ($val2->id == $model->delivery_route_id)
                        $selected = 'selected';
                    ?>
                    <option value="<?= $val2->id ?>" <?= $selected ?>><?= $val2->name ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="col-lg-4">
            <?= $form->field($model, 'location_info')->textInput(['maxlength' => true]) ?>
        </div>

    </div>
    <div class="row">
        <div class="col-lg-4">
            <?= $form->field($model, 'active_date')->textInput() ?>
        </div>
        <div class="col-lg-6">
            <?= $form->field($model, 'contact_name')->textInput(['maxlength' => true]) ?>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-6">
            <?= $form->field($model, 'description')->textarea(['maxlength' => true]) ?>
        </div>
        <div class="col-lg-6">
            <?= $form->field($model, 'shop_photo')->fileInput(['maxlength' => true]) ?>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-4">
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
        <div class="col-lg-4">

        </div>
    </div>
    <br>
    <div class="row">
        <div class="col-lg-4">
            <div class="form-group">
                <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success']) ?>
            </div>

        </div>
        <div class="col-lg-4">

        </div>
    </div>







    <?php ActiveForm::end(); ?>

</div>
