<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;

$unit_data = \backend\models\Unit::find()->all();
$prod_group_data = \backend\models\Productgroup::find()->all();
$prod_type_data = \backend\models\Producttype::find()->all();
$prod_status = \backend\helpers\ProductStatus::asArrayObject();
//print_r($prod_status);
?>

<div class="product-form">

    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>

    <div class="row">
        <div class="col-lg-4">
            <?= $form->field($model, 'code')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-lg-4">
            <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-lg-4">
            <?= $form->field($model, 'description')->textInput(['maxlength' => true]) ?>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-4">
            <label for=""><?= $model->getAttributeLabel('product_type_id') ?></label>
            <select name="product_type_id" class="form-control product-type-id" id=""
                    onchange="">
                <option value="0">--เลือกประเภทสินค้า-</option>
                <?php foreach ($prod_type_data as $val2): ?>
                    <?php
                    $selected = '';
                    if ($val2->id == $model->product_type_id)
                        $selected = 'selected';
                    ?>
                    <option value="<?= $val2->id ?>" <?= $selected ?>><?= $val2->name ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="col-lg-4">
            <label for=""><?= $model->getAttributeLabel('product_group_id') ?></label>
            <select name="product_group_id" class="form-control product-group-id" id=""
                    onchange="">
                <option value="0">--เลือกกลุ่มสินค้า-</option>
                <?php foreach ($prod_group_data as $val2): ?>
                    <?php
                    $selected = '';
                    if ($val2->id == $model->product_group_id)
                        $selected = 'selected';
                    ?>
                    <option value="<?= $val2->id ?>" <?= $selected ?>><?= $val2->name ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="col-lg-4">
            <label for=""><?= $model->getAttributeLabel('unit_id') ?></label>
            <select name="unit_id" class="form-control unit-id" id=""
                    onchange="">
                <option value="0">--เลือกหน่วยนับ-</option>
                <?php foreach ($unit_data as $val2): ?>
                    <?php
                    $selected = '';
                    if ($val2->id == $model->unit_id)
                        $selected = 'selected';
                    ?>
                    <option value="<?= $val2->id ?>" <?= $selected ?>><?= $val2->name ?></option>
                <?php endforeach; ?>
            </select>
        </div>
    </div>
    <br>
    <div class="row">
        <div class="col-lg-4">
            <?= $form->field($model, 'std_cost')->textInput() ?>
        </div>
        <div class="col-lg-4">
            <?= $form->field($model, 'sale_price')->textInput() ?>
        </div>

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
    </div>
    <hr style="border-top: 1px dashed black">
    <div class="row">
        <div class="col-lg-12">
            <label for="">แนบรูปสินค้า</label>
        </div>
    </div>
    <?php if ($model->photo != ''): ?>
        <div class="row">
            <div class="col-lg-4"></div>
            <div class="col-lg-4">
                <img src="../web/uploads/images/products/<?= $model->photo ?>" width="100%" alt="">
            </div>
            <div class="col-lg-4"></div>
        </div>
        <br>
        <div class="row">
            <div class="col-lg-4"></div>
            <div class="col-lg-4">
                <div class="btn btn-danger btn-delete-photo" data-var="<?= $model->id ?>">ลบรูปภาพ</div>
            </div>
            <div class="col-lg-4"></div>
        </div>
    <?php else: ?>
        <div class="row">
            <div class="col-lg-4"></div>
            <div class="col-lg-4">
                <?= $form->field($model, 'photo')->fileInput(['maxlength' => true]) ?>
            </div>
            <div class="col-lg-4"></div>
        </div>
    <?php endif; ?>
    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

<form id="form-delete-photo" action="<?=\yii\helpers\Url::to(['product/deletephoto'], true)?>" method="post">
    <input type="hidden" class="delete-photo-id" name="delete_id" value="">
</form>

<?php
//$url_to_delete_photo = \yii\helpers\Url::to(['product/deletephoto'], true);
$js = <<<JS
  $(function(){
     $(".product-type-id,.product-group-id").select2({
       'class': 'form-control'
     }); 
     
     $(".btn-delete-photo").click(function (){
        var prodid = $(this).attr('data-var');
      //  alert(prodid);
      swal({
                title: "ต้องการทำรายการนี้ใช่หรือไม่",
                text: "",
                type: "warning",
                showCancelButton: true,
                closeOnConfirm: true,
                showLoaderOnConfirm: true
               }, function () {
                  $(".delete-photo-id").val(prodid);
                  $("#form-delete-photo").submit();
         });
     });
  });
JS;
$this->registerJs($js, static::POS_END);
?>