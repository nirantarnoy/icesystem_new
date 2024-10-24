<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

$company_id = 1;
$branch_id = 1;
if (isset($_SESSION['user_company_id'])) {
    $company_id = $_SESSION['user_company_id'];
}
if (isset($_SESSION['user_branch_id'])) {
    $branch_id = $_SESSION['user_branch_id'];
}
?>

<div class="customer-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
        'options' => [
            'data-pjax' => 1
        ],
    ]); ?>

    <div class="input-group">
        <!--         <span class="input-group-addon" id="basic-addon1"><i class="fa fa-search"></i></span>-->
        <?= $form->field($model, 'globalSearch')->textInput(['onchange' => 'this.form.submit();','placeholder' => 'ค้นหา', 'class' => 'form-control', 'aria-describedby' => 'basic-addon1'])->label(false) ?>
        <span style="margin-left: 5px;"></span>
        <?= $form->field($model, 'customer_group_id')->widget(\kartik\select2\Select2::className(), [
            'data' => \yii\helpers\ArrayHelper::map(\backend\models\Customergroup::find()->where(['company_id' => $company_id, 'branch_id' => $branch_id, 'status' => 1])->all(), 'id', function ($data) {
                return $data->code . ' ' . $data->name;
            }),
            'options' => [
                'placeholder' => '--เลือกกลุ่ม--',
                'onchange' => 'this.form.submit();'
            ],
            'pluginOptions' => [
                'allowClear' => true,
            ]
        ])->label(false) ?>
        <span style="margin-left: 5px;"></span>
        <?= $form->field($model, 'customer_type_id')->widget(\kartik\select2\Select2::className(), [
            'data' => \yii\helpers\ArrayHelper::map(\backend\models\Customertype::find()->where(['company_id' => $company_id, 'branch_id' => $branch_id, 'status' => 1])->all(), 'id', function ($data) {
                return $data->code . ' ' . $data->name;
            }),
            'options' => [
                'placeholder' => '--เลือกประเภท--',
                'onchange' => 'this.form.submit();'
            ],
            'pluginOptions' => [
                'allowClear' => true,
            ]
        ])->label(false) ?>
        <span style="margin-left: 5px;"></span>
        <?= $form->field($model, 'delivery_route_id')->widget(\kartik\select2\Select2::className(), [
            'data' => \yii\helpers\ArrayHelper::map(\backend\models\Deliveryroute::find()->where(['company_id' => $company_id, 'branch_id' => $branch_id, 'status' => 1])->all(), 'id', function ($data) {
                return $data->code . ' ' . $data->name;
            }),
            'options' => [
                'placeholder' => '--เลือกสายส่ง--',
                'onchange' => 'this.form.submit();'
            ],
            'pluginOptions' => [
                'allowClear' => true,
            ]
        ])->label(false) ?>
        <span style="margin-left: 5px;"></span>
        <?= $form->field($model, 'from_date')->widget(\kartik\date\DatePicker::className(), [
            'value' => date('Y-m-d'),
            'pluginOptions' => [
                'format' => 'dd-mm-yyyy',
            ]
        ])->label(false) ?>
        <span style="margin-left: 5px;"></span>
        <?= $form->field($model, 'to_date')->widget(\kartik\date\DatePicker::className(), [
            'value' => date('Y-m-d'),
            'options' => [
                'onchange' => 'this.form.submit();',
            ],
            'pluginOptions' => [
                'format' => 'dd-mm-yyyy',
            ]
        ])->label(false) ?>
        <span style="margin-left: 5px;"></span>
        <?php
        $check_role = \backend\models\User::checkhasrole(\Yii::$app->user->id, 'System Administrator');
        if ($check_role) {
            echo \kartik\select2\Select2::widget([
                'value' => $viewstatus,
                'name' => 'viewstatus',
                'data' => \yii\helpers\ArrayHelper::map(\backend\helpers\ViewstatusType::asArrayObject(), 'id', 'name'),
                'options' => [
                    'onchange' => 'this.form.submit();',
                ],
            ]);
        }

        ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
