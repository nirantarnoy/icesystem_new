<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use softark\duallistbox\DualListbox;

?>

<div class="car-form">

    <?php $form = ActiveForm::begin(); ?>

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
        <div class="col-lg-5">
            <?= $form->field($model, 'car_type_id')->Widget(\kartik\select2\Select2::className(), [
                'data' => \yii\helpers\ArrayHelper::map(\backend\models\Customergroup::find()->all(), 'id', 'name'),
                'options' => [
                    'placeholder' => '--เลือกประเภทรถ--'
                ]
            ]) ?>
        </div>
        <div class="col-lg-5">
            <?= $form->field($model, 'sale_group_id')->Widget(\kartik\select2\Select2::className(), [
                'data' => \yii\helpers\ArrayHelper::map(\backend\models\Salegroup::find()->all(), 'id', 'name'),
                'options' => [
                    'placeholder' => '--เลือกกลุ่มการขาย--'
                ]
            ]) ?>
        </div>
        <div class="col-lg-1"></div>
    </div>
    <br>
    <div class="row">
        <div class="col-lg-1"></div>
        <div class="col-lg-10">
            <?= $form->field($model, 'plate_number')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-lg-1"></div>
    </div>
    <div class="row">
        <div class="col-lg-1"></div>
        <div class="col-lg-10">
            <?= $form->field($model, 'photo')->fileInput(['maxlength' => true]) ?>
        </div>
        <div class="col-lg-1"></div>
    </div>
    <div class="row">
        <div class="col-lg-1"></div>
        <div class="col-lg-10">
            <label for=""><?= $model->getAttributeLabel('status') ?></label>
            <?php echo $form->field($model, 'status')->widget(\toxor88\switchery\Switchery::className(), ['options' => ['label' => '', 'class' => 'form-control']])->label(false) ?>
        </div>
        <div class="col-lg-1"></div>
    </div>
    <br>
    <div class="row">
        <div class="col-lg-1"></div>
        <div class="col-lg-10">
            <div class="form-group">
                <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success']) ?>
            </div>
        </div>
        <div class="col-lg-1"></div>
    </div>

    <hr>
    <div class="row">
        <div class="col-lg-1"></div>
        <div class="col-lg-10">
            <h4>พนักงานประจำรถ</h4>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-1"></div>
        <div class="col-lg-10">
            <?php
            $options = [
                'multiple' => true,
                'size' => 20,
            ];
            // echo Html::listBox($name, $selection, $items, $options);
            $model->emp_id = $emp_select_list;
            echo $form->field($model, 'emp_id')->widget(DualListbox::className(), [
                'items' => \yii\helpers\ArrayHelper::map(\backend\models\Employee::find()->all(), 'id', function($data){return $data->fname.' '.$data->lname;}),
                'options' => $options,
                'clientOptions' => [
                    'moveOnSelect' => false,
                    'selectedListLabel' => 'รายการที่เลือก',
                    'nonSelectedListLabel' => 'พนักงานทั้งหมด',
                    'filterPlaceHolder'=>'ค้นหารายชื่อพนักงาน',
                    'infoTextEmpty' => 'ไม่มีรายการที่เลือก',
                    'infoText' => 'รายการทั้งหมด {0}'
                ],
            ])->label(false);
            ?>
        </div>
        <div class="col-lg-1"></div>
    </div>

    <?php ActiveForm::end(); ?>

</div>
