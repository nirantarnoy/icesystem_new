<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

$company_id = 1;
$brach_id = 1;
if (isset($_SESSION['user_company_id'])) {
    $company_id = $_SESSION['user_company_id'];
}
if (isset($_SESSION['user_branch_id'])) {
    $brach_id = $_SESSION['user_branch_id'];
}

?>

<div class="customer-form">

    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>

    <div class="row">
        <div class="col-lg-3">
            <?= $form->field($model, 'code')->textInput(['maxlength' => true, 'readonly' => 'readonly', 'value' => $model->isNewRecord ? 'Draft' : $model->code]) ?>
        </div>
        <div class="col-lg-3">
            <?= $form->field($model, 'sort_name')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-lg-3">
            <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-lg-3">
            <?= $form->field($model, 'customer_group_id')->Widget(\kartik\select2\Select2::className(), [
                'data' => \yii\helpers\ArrayHelper::map(\backend\models\Customergroup::find()->where(['company_id' => $company_id, 'branch_id' => $brach_id])->all(), 'id', function ($data) {
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
                'data' => \yii\helpers\ArrayHelper::map(\backend\models\Deliveryroute::find()->where(['company_id' => $company_id, 'branch_id' => $brach_id])->all(), 'id', function ($data) {
                    return $data->code . ' ' . $data->name;
                }),
                'options' => [
                    'placeholder' => '--เลือกเส้นทางขนส่ง--'
                ]
            ]) ?>
        </div>
        <div class="col-lg-4">
            <?= $form->field($model, 'customer_type_id')->Widget(\kartik\select2\Select2::className(), [
                'data' => \yii\helpers\ArrayHelper::map(\backend\models\Customertype::find()->where(['company_id' => $company_id, 'branch_id' => $brach_id])->all(), 'id', function ($data) {
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
            <?= $form->field($model, 'payment_method_id')->widget(\kartik\select2\Select2::className(), [
                'data' => \yii\helpers\ArrayHelper::map(\backend\models\Paymentmethod::find()->where(['company_id' => $company_id, 'branch_id' => $brach_id])->all(), 'id', 'name'),
                'options' => [
                    'placeholder' => '--วิธีชำระเงิน--'
                ]
            ]) ?>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-3">
            <?= $form->field($model, 'payment_term_id')->widget(\kartik\select2\Select2::className(), [
                'data' => \yii\helpers\ArrayHelper::map(\backend\models\Paymentterm::find()->where(['company_id' => $company_id, 'branch_id' => $brach_id])->all(), 'id', 'name'),
                'options' => [
                    'placeholder' => '--เงื่อนไขชำระเงิน--'
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
            <?php //echo $form->field($model, 'shop_photo')->fileInput(['maxlength' => true]) ?>
            <br>
            <?php if ($model->shop_photo != ''): ?>
                <div class="row">
                    <div class="col-lg-4"></div>
                    <div class="col-lg-4">
                        <img src="../web/uploads/images/customer/<?= $model->shop_photo ?>"
                             width="100%"
                             alt="">
                    </div>
                    <div class="col-lg-4"></div>
                </div>
                <br>
                <div class="row">
                    <div class="col-lg-4"></div>
                    <div class="col-lg-4">
                        <div class="btn btn-danger btn-delete-photo"
                             data-var="<?= $model->id ?>">
                            ลบรูปภาพ
                        </div>
                    </div>
                    <div class="col-lg-4"></div>
                </div>
            <?php else: ?>
                <div class="row">
                    <div class="col-lg-4"></div>
                    <div class="col-lg-4">
                        <?= $form->field($model, 'shop_photo')->fileInput(['maxlength' => true]) ?>
                    </div>
                    <div class="col-lg-4"></div>
                </div>
            <?php endif; ?>
        </div>

        <div class="col-lg-4">
            <label for=""><?= $model->getAttributeLabel('status') ?></label>
            <?php echo $form->field($model, 'status')->widget(\toxor88\switchery\Switchery::className(), ['options' => ['label' => '', 'class' => 'form-control']])->label(false) ?>
        </div>
        <div class="col-lg-4">

        </div>
    </div>
    <br/>
    <div class="row">
        <div class="col-lg-12">
            <h3>
                รายการยืมถัง/กระสอบ</h3>
        </div>
        <table class="table table-bordered">
            <thead>
            <tr>
                <th style="text-align: center;width: 5%">
                    #
                </th>
                <th>
                    รหัสอุปกรณ์
                </th>
                <th>
                    ชื่ออุปกรณ์
                </th>
                <th>
                    จำนวน
                </th>
                <th>
                    วันที่เริ่ม
                </th>
                <th>
                    สถานะ
                </th>
                <th style="text-align: center;width: 5%">
                    -
                </th>
            </tr>
            </thead>
            <tbody>
            <?php if ($model->isNewRecord): ?>
                <tr>
                    <td style="text-align: center">
                        #
                    </td>
                    <td>
                        <input type="hidden"
                               name="line_product_id[]"
                               class="line-product-id">
                        <input type="text"
                               class="form-control line-product-code"
                               name="line_product_code[]"
                               readonly>
                    </td>
                    <td>
                        <input type="text"
                               class="form-control line-prod-name"
                               name="line_product_name[]">
                    </td>
                    <td>
                        <input type="number"
                               class="form-control line-qty"
                               name="line_qty[]">
                    </td>
                    <td>
                        <input type="text"
                               class="form-control line-start-date"
                               name="line_start_date[]">
                    </td>
                    <td>
                        <div class="btn btn-info">
                            รายละเอียด
                        </div>
                    </td>
                    <td style="text-align: center">
                        <div class="btn btn-danger btn-sm">
                            <i class="fa fa-minus"></i>
                        </div>
                    </td>
                </tr>
            <?php else: ?>
                <?php if (count($model_asset_list) > 0): ?>
                    <?php $i = 0; ?>
                    <?php foreach ($model_asset_list as $value): ?>
                        <?php $i += 1; ?>
                        <tr>
                            <td style="text-align: center">
                                <?= $i ?>
                            </td>
                            <td>
                                <input type="hidden"
                                       name="line_product_id[]"
                                       class="line-product-id">
                                <input type="text"
                                       class="form-control line-product-code"
                                       name="line_product_code[]"
                                       readonly>
                            </td>
                            <td>
                                <input type="text"
                                       class="form-control line-prod-name"
                                       name="line_product_name[]" readonly>
                            </td>
                            <td>
                                <input type="number"
                                       class="form-control line-qty"
                                       name="line_qty[]">
                            </td>
                            <td>
                                <input type="text"
                                       class="form-control line-start-date"
                                       name="line_start_date[]">
                            </td>
                            <td>
                                <div class="btn btn-info">
                                    รายละเอียด
                                </div>
                            </td>
                            <td style="text-align: center">
                                <div class="btn btn-danger btn-sm">
                                    <i class="fa fa-minus"></i>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td style="text-align: center">

                        </td>
                        <td>
                            <input type="hidden"
                                   name="line_product_id[]"
                                   class="line-product-id">
                            <input type="text"
                                   class="form-control line-product-code"
                                   name="line_product_code[]"
                                   readonly>
                        </td>
                        <td>
                            <input type="text"
                                   class="form-control line-prod-name"
                                   name="line_product_name[]">
                        </td>
                        <td>
                            <input type="number"
                                   class="form-control line-qty"
                                   name="line_qty[]">
                        </td>
                        <td>
                            <input type="text"
                                   class="form-control line-start-date"
                                   name="line_start_date[]">
                        </td>
                        <td>
                            <div class="btn btn-info">
                                รายละเอียด
                            </div>
                        </td>
                        <td style="text-align: center">
                            <div class="btn btn-danger btn-sm">
                                <i class="fa fa-minus"></i>
                            </div>
                        </td>
                    </tr>
                <?php endif; ?>
            <?php endif; ?>
            </tbody>
            <tfoot>
            <tr>
                <td>
                    <div class="btn btn-primary">
                        <i class="fa fa-plus-circle"></i>
                    </div>
                </td>
            </tr>
            </tfoot>
        </table>
    </div>
    <hr/>
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
<form id="form-delete-photo"
      action="<?= \yii\helpers\Url::to(['customer/deletephoto'], true) ?>"
      method="post">
    <input type="hidden"
           class="delete-photo-id"
           name="delete_id"
           value="">
</form>
<?php
$js = <<<JS
$(function(){
    
});
$(".btn-delete-photo").click(function (){
        var prodid = $(this).attr('data-var');
       //alert(prodid);
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
JS;

$this->registerJs($js, static::POS_END);

?>
