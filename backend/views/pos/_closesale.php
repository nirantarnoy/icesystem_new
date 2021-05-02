<?php
$this->title = 'สรุปยอดขายประจำวัน';

$user_id = \Yii::$app->user->id;
$user_login_time = \backend\models\User::findLogintime($user_id);
$user_login_datetime = \backend\models\User::findLogindatetime($user_id);
$t_date = date('Y-m-d H:i:s');

//echo $user_login_datetime;
?>
<br/>
<form id="form-sale-end" action="<?= \yii\helpers\Url::to(['pos/saledailyend'], true) ?>" method="post">
    <input type="hidden" name="close_date" value="<?= date('Y-m-d') ?>">
    <input type="hidden" name="close_from_time" value="<?= \backend\models\User::findLogintime($user_id) ?>">
    <input type="hidden" name="close_to_time" value="<?= date('H:i') ?>">
    <div class="row">
        <div class="col-lg-3">
            <h4>วันที่ <span style="color: #ec4844"><?= date('d/m/Y') ?></span></h4>
        </div>
        <div class="col-lg-3">
            <h4>ช่วงเวลา <span
                        style="color: #ec4844"><?= \backend\models\User::findLogintime($user_id) ?> - <?= date('H:i') ?></span>
            </h4>
        </div>
        <div class="col-lg-3">
            <h4>พนักงาน <span style="color: #ec4844"><?= \backend\models\User::findName(\Yii::$app->user->id) ?></span>
            </h4>
        </div>
    </div>
    <hr/>
    <div class="row" style="text-align: right">
        <div class="col-lg-2"><h5>ยอดยกมา</h5></div>
        <div class="col-lg-2">
            <input type="text" class="form-control" value="0" readonly name="balance_in">
        </div>
        <div class="col-lg-2"><h5>ยอดผลิต</h5></div>
        <div class="col-lg-2">
            <input type="text" class="form-control" name="today_production_qty"
                   value="<?= number_format($production_qty) ?>" readonly>
        </div>
        <div class="col-lg-2"><h5>ยอดคืน</h5></div>
        <div class="col-lg-2">
            <input type="text" class="form-control" name="order_return_qty" value="<?= number_format(0) ?>" readonly>
        </div>
    </div>
    <div style="height: 10px;"></div>
    <div class="row" style="text-align: right">
        <div class="col-lg-2"><h5>ขายสด(จำนวน)</h5></div>
        <div class="col-lg-2">
            <input type="text" class="form-control" name="order_cash_qty" value="<?= number_format($order_cash_qty) ?>"
                   readonly>
        </div>
        <div class="col-lg-2"><h5>ขายสด(เงิน)</h5></div>
        <div class="col-lg-2">
            <input type="text" class="form-control" name="order_cash_amount"
                   value="<?= number_format($order_cash_amount) ?>" readonly>
        </div>
        <div class="col-lg-2"><h5>เบิกเติม</h5></div>
        <div class="col-lg-2">
            <input type="text" class="form-control" name="order_refill_qty"
                   value="<?= number_format($issue_refill_qty) ?>" readonly>
        </div>
    </div>
    <div style="height: 10px;"></div>
    <div class="row" style="text-align: right">
        <div class="col-lg-2"><h5>ขายเชื่อ(จำนวน)</h5></div>
        <div class="col-lg-2">
            <input type="text" class="form-control" name="order_credit_qty"
                   value="<?= number_format($order_credit_qty) ?>" readonly>
        </div>
        <div class="col-lg-2"><h5>ขายเชื่อ(เงิน)</h5></div>
        <div class="col-lg-2">
            <input type="text" class="form-control" name="order_credit_amount"
                   value="<?= number_format($order_credit_amount) ?>" readonly>
        </div>
    </div>
    <div style="height: 10px;"></div>
    <div class="row" style="text-align: right">
        <div class="col-lg-2"><h5>ขายทั้งหมด(จำนวน)</h5></div>
        <div class="col-lg-2">
            <input type="text" class="form-control" name="order_qty" value="<?= number_format($order_qty) ?>" readonly>
        </div>
        <div class="col-lg-2"><h5>ขายทั้งหมด(เงิน)</h5></div>
        <div class="col-lg-2">
            <input type="text" class="form-control" name="order_amount" value="<?= number_format($order_amount) ?>"
                   readonly>
        </div>
    </div>
    <div style="height: 10px;"></div>
    <div class="row" style="text-align: right">
        <div class="col-lg-2"><h5>ยอดยกไป</h5></div>
        <div class="col-lg-2">
            <input type="text" class="form-control" name="order_qty"
                   value="<?= number_format($production_qty - $order_qty) ?>" readonly>
        </div>
    </div>
    <br/>
    <hr/>

    <!--    <input type="submit" value="ok">-->


    <br/>
    <div class="row">
        <div class="col-lg-12">
            <table class="table table-striped table-bordered">
                <thead>
                <tr>
                    <th>สินค้า</th>
                    <th style="text-align: right">ยอดยกมา</th>
                    <th style="text-align: right">ยอดผลิต</th>
                    <th style="text-align: right">ขายสด(จำนวน)</th>
                    <th style="text-align: right">ขายเชื่อ(จำนวน)</th>
                    <th style="text-align: right">รวม</th>
                    <th style="text-align: right">ขายสด(เงิน)</th>
                    <th style="text-align: right">ขายเชื่อ(เงิน)</th>
                    <th style="text-align: right">รวม</th>
                    <th style="text-align: right">
                        ยอดยกไป
                    </th>
                </tr>
                </thead>
                <tbody>
                <?php
                $total_order_cash_qty = 0;
                $total_order_credit_qty = 0;
                $total_order_cash_amount = 0;
                $total_order_credit_amount = 0;
                $total_production_qty = 0;
                ?>
                <?php foreach ($order_product_item as $value): ?>
                    <?php
                    $production_rec_qty = getProdDaily($value->product_id, $user_login_datetime, $t_date);
                    $order_cash_qty = getOrderCashQty($value->product_id, $user_id, $user_login_datetime, $t_date);
                    $order_credit_qty = getOrderCreditQty($value->product_id, $user_id, $user_login_datetime, $t_date);

                    $total_order_cash_qty = $total_order_cash_qty + $order_cash_qty;
                    $total_order_credit_qty = $total_order_credit_qty + $order_credit_qty;
                    $total_production_qty = $total_production_qty + $production_rec_qty;

                    $balance_in = 0;
                    $order_cash_amount = 0;
                    $order_credit_amount = 0;

                    $balance_out = ($production_rec_qty - $order_cash_qty - $order_credit_qty);
                    ?>
                    <tr>
                        <td style="text-align: left">
                            <input type="hidden" name="line_prod_id[]" value="<?= $value->product_id ?>">
                            <?= \backend\models\Product::findName($value->product_id) ?>
                        </td>
                        <td style="text-align: right">
                            <input type="hidden" name="line_balance_in[]" value="<?= $balance_in ?>">
                            <?= $balance_in ?>
                        </td>
                        <td style="text-align: right">
                            <input type="hidden" name="line_production_qty[]" value="<?= $production_rec_qty ?>">
                            <?= number_format($production_rec_qty) ?>
                        </td>
                        <td style="text-align: right">
                            <input type="hidden" name="line_cash_qty[]" value="<?= $order_cash_qty ?>">
                            <?= number_format($order_cash_qty) ?>
                        </td>
                        <td style="text-align: right">
                            <input type="hidden" name="line_credit_qty[]" value="<?= $order_credit_qty ?>">
                            <?= number_format($order_credit_qty) ?>
                        </td>
                        <td style="text-align: right">
                            <?= number_format($order_cash_qty + $order_credit_qty) ?>
                        </td>
                        <td style="text-align: right">
                            <input type="hidden" name="line_cash_amount[]" value="<?= $order_cash_amount ?>">
                            <?= number_format($order_cash_amount) ?>
                        </td>
                        <td style="text-align: right">
                            <input type="hidden" name="line_credit_amount[]" value="<?= $order_credit_amount ?>">
                            <?= number_format($order_credit_amount) ?>
                        </td>
                        <td style="text-align: right">
                            <?= number_format($order_cash_amount + $order_credit_amount) ?>
                        </td>
                        <td style="text-align: right">
                            <input type="hidden" name="line_balance_out[]" value="<?= $balance_out ?>">
                            <?= number_format($balance_out) ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
                <tfoot>
                <tr style="background-color: #99c5de">
                    <td></td>
                    <td></td>
                    <td style="text-align: right;font-weight: bold">
                        <?=number_format($total_production_qty)?>
                    </td>
                    <td style="text-align: right;font-weight: bold">
                        <?=number_format($total_order_cash_qty)?>
                    </td>
                    <td style="text-align: right;font-weight: bold">
                        <?=number_format($total_order_credit_qty)?>
                    </td>
                    <td style="text-align: right;font-weight: bold">
                        <?=number_format($total_order_credit_qty + $total_order_cash_qty)?>
                    </td>
                    <td style="text-align: right;font-weight: bold">
                        <?=number_format($total_order_cash_amount)?>
                    </td>
                    <td style="text-align: right;font-weight: bold">
                        <?=number_format($total_order_credit_amount)?>
                    </td>
                    <td style="text-align: right;font-weight: bold">
                        <?=number_format($total_order_cash_amount + $total_order_credit_amount)?>
                    </td>
                    <td></td>
                </tr>
                </tfoot>
            </table>
        </div>
    </div>
    <br />
    <div class="row" style="text-align: center">
        <div class="col-lg-12">
            <div class="btn btn-success btn-lg" onclick="submittotal($(this));"><i class="fa fa-save"></i> บันทึกปิดการขาย</div>
        </div>
    </div>
</form>
<?php
function getProdDaily($product_id, $user_login_datetime, $t_date)
{
    $qty = 0;
    if ($product_id != null) {
        $qty = \backend\models\Stocktrans::find()->where(['activity_type_id' => 1])->andFilterWhere(['product_id' => $product_id])->andFilterWhere(['between', 'trans_date', $user_login_datetime, $t_date])->sum('qty');
    }

    return $qty;
}

function getOrderCashQty($product_id, $user_id, $user_login_datetime, $t_date)
{
    $qty = 0;
    if ($user_id != null) {
        $qty = \common\models\QuerySaleDataSummary::find()->where(['created_by' => $user_id, 'product_id' => $product_id])->andFilterWhere(['between', 'order_date', $user_login_datetime, $t_date])->andFilterWhere(['LIKE', 'name', 'สด'])->sum('qty');
    }

    return $qty;
}

function getOrderCreditQty($product_id, $user_id, $user_login_datetime, $t_date)
{
    $qty = 0;
    if ($user_id != null) {
        $qty = \common\models\QuerySaleDataSummary::find()->where(['created_by' => $user_id, 'product_id' => $product_id])->andFilterWhere(['between', 'order_date', $user_login_datetime, $t_date])->andFilterWhere(['NOT LIKE', 'name', 'สด'])->sum('qty');
    }

    return $qty;
}

function getOrderCashAmount($product_id, $user_id, $user_login_datetime, $t_date)
{
    $qty = 0;
    if ($user_id != null) {
        $qty = \common\models\QuerySalePosPayDaily::find()->where(['created_by' => $user_id])->andFilterWhere(['between', 'payment_date', $user_login_datetime, $t_date])->andFilterWhere(['LIKE', 'name', 'สด'])->sum('payment_amount');
    }

    return $qty;
}

?>

<?php
$js=<<<JS
  function submittotal(e){
    if(confirm('คุณต้องการทำรายการนี้ใช่หรือไม่ ?')){
        $("form#form-sale-end").submit();
    }
}
JS;

$this->registerJs($js,static::POS_END);
?>
