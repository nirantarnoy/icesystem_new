<?php
$this->title = 'สรุปยอดขายประจำวัน';
?>
<div class="row">
    <div class="col-lg-3">
        <h4>วันที่ <span><?=date('d/m/Y')?></span></h4>
    </div>
    <div class="col-lg-3">
        <h4>ช่วงเวลา</h4>
    </div>
    <div class="col-lg-3">
        <h4>พนักงาน <span><?= \backend\models\User::findName(\Yii::$app->user->id)?></span></h4>
    </div>
</div>
<br />
<div class="row">
    <div class="col-lg-2"><h5>ยอดยกมา</h5></div>
    <div class="col-lg-2">
        <input type="text" class="form-control" value="0" readonly>
    </div>
    <div class="col-lg-2"><h5>ยอดผลิต</h5></div>
    <div class="col-lg-2">
        <input type="text" class="form-control" value="<?=number_format($production_qty)?>" readonly>
    </div>
</div>
<div style="height: 5px;"></div>
<div class="row">
    <div class="col-lg-2"><h5>ขายสด(จำนวน)</h5></div>
    <div class="col-lg-2">
        <input type="text" class="form-control" value="<?=number_format($order_qty)?>" readonly>
    </div>
    <div class="col-lg-2"><h5>ขายสด(เงิน)</h5></div>
    <div class="col-lg-2">
        <input type="text" class="form-control" value="<?=number_format($order_amount)?>" readonly>
    </div>
</div>
<div style="height: 5px;"></div>
<div class="row">
    <div class="col-lg-2"><h5>ขายเชื่อ(จำนวน)</h5></div>
    <div class="col-lg-2">
        <input type="text" class="form-control" value="0" readonly>
    </div>
    <div class="col-lg-2"><h5>ขายเชื่อ(เงิน)</h5></div>
    <div class="col-lg-2">
        <input type="text" class="form-control" value="0" readonly>
    </div>
</div>
<br />
<div class="row">
    <div class="col-lg-3">
        <div class="btn btn-success">ตกลง</div>
    </div>
</div>


