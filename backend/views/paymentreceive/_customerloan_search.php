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


    <div class="input-group">
        <!--         <span class="input-group-addon" id="basic-addon1"><i class="fa fa-search"></i></span>-->
        <?= $form->field($model, 'car_ref_id')->widget(Select2::className(),[
            'data' => ArrayHelper::map(\backend\models\Car::find()->where(['company_id'=>$company_id,'branch_id'=>$branch_id])->all(),'id', 'code'),
            'options'=>[
                'placeholder'=>'เลือกรถ'
        ])->label(false) ?>
    </div>
    <?php ActiveForm::end(); ?>

</div>
