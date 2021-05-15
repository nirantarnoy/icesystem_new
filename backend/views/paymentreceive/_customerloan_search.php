<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use kartik\select2\Select2;

?>

<div class="paymentreceive-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
        'options' => [
            'data-pjax' => 1
        ],
    ]); ?>

    <div class="row">
        <div class="col-lg-3">
            <?= $form->field($model, 'car_ref_id')->widget(Select2::className(), [
                'data' => ArrayHelper::map(\backend\models\Car::find()->where(['company_id' => $company_id, 'branch_id' => $branch_id])->all(), 'id', 'code'),
                'options' => [
                    'placeholder' => 'เลือกรถ'
                ],
                'pluginOptions' => [
                        'multiple'=> true,
                ]
            ])->label() ?>
        </div>
        <div class="col-lg-3"></div>
        <div class="col-lg-3"></div>
        <div class="col-lg-3">
            <input type="submit" class="btn btn-primary" value="ค้นหา">
        </div>
    </div>
    <div class="input-group">
        <!--         <span class="input-group-addon" id="basic-addon1"><i class="fa fa-search"></i></span>-->

    </div>
    <?php ActiveForm::end(); ?>

</div>
