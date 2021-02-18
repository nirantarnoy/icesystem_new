<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;


$prod_data = \backend\models\Product::find()->all();

?>

<div class="journalissue-form">

    <?php $form = ActiveForm::begin(); ?>

    <div class="row">
        <div class="col-lg-3">
            <?= $form->field($model, 'journal_no')->textInput(['maxlength' => true, 'readonly' => 'readonly']) ?>
        </div>
        <div class="col-lg-3">
            <?php $model->trans_date = $model->isNewRecord ? date('d/m/Y') : date('d/m/Y', strtotime($model->trans_date)); ?>
            <?= $form->field($model, 'trans_date')->widget(\kartik\date\DatePicker::className(),
                [
                    'pluginOptions' => [
                        'format' => 'dd/mm/yyyy',
                        'todayHighlight' => true
                    ],
                ]) ?>
        </div>
        <div class="col-lg-3">
            <?= $form->field($model, 'delivery_route_id')->widget(Select2::className(), [
                'data' => \yii\helpers\ArrayHelper::map(\backend\models\Deliveryroute::find()->all(), 'id', 'name'),
                'options' => [
                    'placeholder' => '--เลือกสายส่ง--'
                ]
            ]) ?>
        </div>
        <div class="col-lg-3">
            <?= $form->field($model, 'status')->textInput(['readonly' => 'readonly', 'value' => $model->isNewRecord ? 'Open' : \backend\helpers\IssueStatus::getTypeById($model->status)]) ?>
        </div>
    </div>
    <br>
    <h5>รายการสินค้าเบิก</h5>
    <!--    <hr>-->
    <div class="row">
        <div class="col-lg-12">
            <table class="table table-bordered">
                <thead>
                <tr>
                    <th>รหัสสินค้า</th>
                    <th>ชื่อสินค้า</th>
                    <th style="width: 15%">จำนวนเบิก</th>
                    <th style="width: 10%"></th>
                </tr>
                </thead>
                <tbody>
                <?php foreach ($prod_data as $value): ?>
                    <?php if ($model->isNewRecord): ?>
                        <tr>
                            <td>
                                <input type="hidden" class="line-prod-id" name="line_prod_id[]"
                                       value="<?= $value->id; ?>">
                                <?= $value->code ?>
                            </td>
                            <td>
                                <?= $value->name ?>
                            </td>
                            <td>
                                <input type="number" class="line-qty form-control" name="line_qty[]" value="0" min="0">
                            </td>
                            <td style="text-align: center">
                                <div class="btn btn-danger btn-sm" onclick="deleteline($(this))"><i
                                            class="fa fa-trash"></i>
                                </div>
                            </td>
                        </tr>
                    <?php else: ?>
                    <?php foreach ($model_line as $value2):?>
                          <?php if($value->id == $value2->product_id):?>
                            <tr>
                                <td>
                                    <input type="hidden" class="line-prod-id" name="line_prod_id[]" value="<?= $value2->product_id; ?>">
                                    <?= \backend\models\Product::findCode($value2->product_id); ?>
                                </td>
                                <td>
                                    <?= \backend\models\Product::findName($value2->product_id); ?>
                                </td>
                                <td>
                                    <input type="number" class="line-qty form-control" name="line_qty[]" value="<?=$value2->qty?>" min="0">
                                </td>
                                <td style="text-align: center">
                                    <div class="btn btn-danger btn-sm" onclick="deleteline($(this))"><i
                                                class="fa fa-trash"></i>
                                    </div>
                                </td>
                            </tr>
                        <?php endif;?>
                    <?php endforeach;?>
                    <?php endif; ?>
                <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
    <br>
    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
