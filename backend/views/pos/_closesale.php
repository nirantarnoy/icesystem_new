<?php
$this->title = 'สรุปยอดขายประจำวัน';
$user_id = \Yii::$app->user->id;
?>
<br/>
<form id="form-sale-end" action="<?=\yii\helpers\Url::to(['pos/saledailyend'],true)?>" method="post">
    <input type="hidden" name="close_date" value="<?=date('Y-m-d')?>">
    <input type="hidden" name="close_from_time" value="<?=\backend\models\User::findLogintime($user_id)?>">
    <input type="hidden" name="close_to_time" value="<?=date('H:i')?>">
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
            <input type="text" class="form-control" name="today_production_qty" value="<?= number_format($production_qty) ?>" readonly>
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
            <input type="text" class="form-control" name="order_cash_qty" value="<?= number_format($order_cash_qty) ?>" readonly>
        </div>
        <div class="col-lg-2"><h5>ขายสด(เงิน)</h5></div>
        <div class="col-lg-2">
            <input type="text" class="form-control" name="order_cash_amount" value="<?= number_format($order_cash_amount) ?>" readonly>
        </div>
        <div class="col-lg-2"><h5>เบิกเติม</h5></div>
        <div class="col-lg-2">
            <input type="text" class="form-control" name="order_refill_qty" value="<?= number_format($issue_refill_qty) ?>" readonly>
        </div>
    </div>
    <div style="height: 10px;"></div>
    <div class="row" style="text-align: right">
        <div class="col-lg-2"><h5>ขายเชื่อ(จำนวน)</h5></div>
        <div class="col-lg-2">
            <input type="text" class="form-control" name="order_credit_qty" value="<?= number_format($order_credit_qty) ?>" readonly>
        </div>
        <div class="col-lg-2"><h5>ขายเชื่อ(เงิน)</h5></div>
        <div class="col-lg-2">
            <input type="text" class="form-control" name="order_credit_amount" value="<?= number_format($order_credit_amount) ?>" readonly>
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
            <input type="text" class="form-control" name="order_amount" value="<?= number_format($order_amount) ?>" readonly>
        </div>
    </div>
    <div style="height: 10px;"></div>
    <div class="row" style="text-align: right">
        <div class="col-lg-2"><h5>ยอดยกไป</h5></div>
        <div class="col-lg-2">
            <input type="text" class="form-control" name="order_qty" value="<?= number_format($production_qty-$order_qty) ?>" readonly>
        </div>
    </div>
    <br/>
    <hr/>
    <div class="row" style="text-align: center">
        <div class="col-lg-12">
            <div class="btn btn-success btn-lg"><i class="fa fa-save"></i> บันทึกปิดการขาย</div>
        </div>
    </div>
    <input type="submit" value="ok">
</form>
