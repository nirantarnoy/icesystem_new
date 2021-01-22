<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

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
            <?= $form->field($model, 'customer_group_id')->Widget(\kartik\select2\Select2::className(), [
                'data' => \yii\helpers\ArrayHelper::map(\backend\models\Customergroup::find()->all(), 'id', function ($data) {
                    return $data->code . ' ' . $data->name;
                }),
                'options' => [
                    'placeholder' => '--เลือกกลุ่มลูกค้า--'
                ]
            ]) ?>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-4">
            <?= $form->field($model, 'delivery_route_id')->Widget(\kartik\select2\Select2::className(), [
                'data' => \yii\helpers\ArrayHelper::map(\backend\models\Deliveryroute::find()->all(), 'id', function ($data) {
                    return $data->code . ' ' . $data->name;
                }),
                'options' => [
                    'placeholder' => '--เลือกเส้นทางขนส่ง--'
                ]
            ]) ?>
        </div>
        <div class="col-lg-4">
            <?= $form->field($model, 'customer_type_id')->Widget(\kartik\select2\Select2::className(), [
                'data' => \yii\helpers\ArrayHelper::map(\backend\models\Customertype::find()->all(), 'id', function ($data) {
                    return $data->code . ' ' . $data->name;
                }),
                'options' => [
                    'placeholder' => '--เลือกประเภทลูกค้า--'
                ]
            ]) ?>
        </div>
        <div class="col-lg-4">
            <?= $form->field($model, 'location_info')->textInput(['maxlength' => true]) ?>
        </div>

    </div>
    <div class="row">
        <div class="col-lg-3">
            <?= $form->field($model, 'branch_no')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-lg-3">
            <?= $form->field($model, 'phone')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-lg-3">
            <?= $form->field($model, 'active_date')->textInput() ?>
        </div>
        <div class="col-lg-3">
            <?= $form->field($model, 'payment_method_id')->widget(\kartik\select2\Select2::className(),[
                    'data' => \yii\helpers\ArrayHelper::map(\backend\models\Paymentmethod::find()->all(),'id','name'),
                'options' => [
                        'placeholder'=>'--วิธีชำระเงิน--'
                ]
            ]) ?>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-3">
            <?= $form->field($model, 'payment_term_id')->widget(\kartik\select2\Select2::className(),[
                'data' => \yii\helpers\ArrayHelper::map(\backend\models\Paymentterm::find()->all(),'id','name'),
                'options' => [
                    'placeholder'=>'--เงื่อนไขชำระเงิน--'
                ]
            ]) ?>
        </div>
        <div class="col-lg-3">
            <?= $form->field($model, 'contact_name')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-lg-3">
            <?= $form->field($model, 'description')->textarea(['maxlength' => true]) ?>
        </div>
        <div class="col-lg-3">
            <?= $form->field($model, 'address')->textarea(['maxlength' => true]) ?>
        </div>

    </div>
    <div class="row">
        <div class="col-lg-6">
            <?= $form->field($model, 'shop_photo')->fileInput(['maxlength' => true]) ?>
        </div>
        <div class="col-lg-4">
            <label for=""><?= $model->getAttributeLabel('status') ?></label>
            <?php echo $form->field($model, 'status')->widget(\toxor88\switchery\Switchery::className(), ['options' => ['label' => '', 'class' => 'form-control']])->label(false) ?>
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
