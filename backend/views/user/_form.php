<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\User */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="user-form">

    <?php $form = ActiveForm::begin(); ?>
    <div class="row">
        <div class="col-lg-1">

        </div>
        <div class="col-lg-10">
            <?= $form->field($model, 'username')->textInput() ?>

            <?php if ($model->isNewRecord): ?>
                <?= $form->field($model, 'pwd')->passwordInput()->label('Password') ?>
            <?php endif; ?>
            <?= $form->field($model, 'group_id')->widget(\kartik\select2\Select2::className(), [
                'data' => \yii\helpers\ArrayHelper::map(\backend\models\Usergroup::find()->all(), 'id', function ($data) {
                    return $data->name;
                }),
                'options' => [
                    'placeholder' => '--เลือกกลุ่มผู้ใช้งาน--'
                ]
            ])->label('กลุ่มผู้ใช้งาน') ?>
            <?= $form->field($model, 'employee_ref_id')->widget(\kartik\select2\Select2::className(), [
                'data' => \yii\helpers\ArrayHelper::map(\backend\models\Employee::find()->all(), 'id', function ($data) {
                    return $data->fname;
                }),
                'options' => [
                    'placeholder' => '--เลือกพนักงาน--'
                ]
            ])->label('พนักงาน') ?>
            <?= $form->field($model, 'status')->widget(\toxor88\switchery\Switchery::className())->label(false) ?>

            <?php //echo $form->field($model, 'roles')->checkboxList($model->getAllRoles())->label(false) ?>

            <div class="form-group">
                <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
            </div>
        </div>
        <div class="col-lg-1"></div>

        <?php ActiveForm::end(); ?>

    </div>
