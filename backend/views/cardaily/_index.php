<?php

$this->title = 'จัดการข้อมูลรถประจำวัน';
$this->params['breadcrumbs'][] = $this->title;

$model = $dataProvider->getModels();
$model_new = null;
//if($model == null){
$model_new = \backend\models\Car::find()->all();
//}
//$emp_data = \common\models\USRPWOPERSON::find()->where(['WCID' => 'PTVB'])->all();

//print_r($model);return;
?>
<br/>
<div class="row">
    <div class="col-lg-9">
        <?php echo $this->render('_search', ['model' => $searchModel]); ?>
    </div>
    <div class="col-lg-3" style="text-align: right">
        <div class="btn btn-info" onclick="showcopy($(this))"><i class="fa fa-copy"></i> Copy ข้อมูล</div>
<!--        <div class="btn btn-info"><i class="fa fa-users-cog"></i> ย้ายเตาพนักงาน</div>-->
    </div>
</div>
<br/>
<?php if ($model_new != null): ?>
    <div class="row">
        <!--    <div class="col-lg-12">-->
        <?php $i = 0; ?>
        <?php foreach ($model_new as $value): ?>
            <?php $i += 1; ?>
            <?php
            $status_name = 'Close';
            $status_color = 'bg-white';
            $stream_status = 'Close';

            $assign_id = 0;
            $stream_assign_date = '';
            if ($i <= 10) $status_color = 'bg-success';
            // if (\backend\models\Streamer::getStatus($value->NAME)) $status_color = 'Open';

//            foreach ($model as $value2) {
//                if ($value2->STATUS == 1 && trim($value2->STREAM_NO) == trim($value->NAME)) {
//                    $assign_id = $value2->ID;
//                    $stream_assign_date = $value2->ASSIGN_DATE;
//                    $status_name = 'Open';
//                    $status_color = 'bg-success';
//                    $stream_status = 'Open';
//                }
//            }
            ?>
            <div class="col-lg-2 col-3">
                <!-- small box -->
                <div class="small-box <?= $status_color ?>">
                    <div class="inner">
                        <h6><b><?= $value->name ?></b></h6>
                        <p><?php //echo $status_name ?></p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-truck"></i>
                        <!--                       <img src="../web/uploads/images/streamer/streamer.jpg" width="50%" alt="">-->
                    </div>
                    <a href="#" onclick="showstreaminfo($(this))" class="small-box-footer"><i
                            class="fas fa-users"></i> จัดการข้อมูล </a>
                </div>
            </div>
        <?php endforeach; ?>
        <!--    </div>-->
    </div>
<?php endif; ?>
