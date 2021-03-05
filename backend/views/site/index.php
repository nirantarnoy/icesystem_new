<?php

use yii\helpers\Url;
use miloschuman\highcharts\Highcharts;

$this->title = 'ภาพรวมระบบ';
?>
<br/>
<div class="site-index">
    <div class="body-content">
        <div class="row">
            <div class="col-lg-4">
                <div class="label">เลือกดูตามช่วงวันที่</div>
                <?php
                echo \kartik\daterange\DateRangePicker::widget([
                    'name' => 'dashboard_date',
                    'pluginOptions' => [

                    ]
                ]);
                ?>
            </div>
        </div>
        <br>
        <div class="row">
            <div class="col-lg-3 col-6">
                <!-- small box -->
                <div class="small-box bg-info">
                    <div class="inner">
                        <h3><?= number_format($prod_cnt) ?></h3>

                        <p>จำนวนสินค้าทั้งหมด</p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-bag"></i>
                    </div>
                    <a href="<?= Url::to(['product/index'], true) ?>" class="small-box-footer">ไปยังสินค้า <i
                                class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>
            <!-- ./col -->
            <div class="col-lg-3 col-6">
                <!-- small box -->
                <div class="small-box bg-success">
                    <div class="inner">
                        <h3><?= number_format($route_cnt) ?></h3>
                        <!--                        <sup style="font-size: 20px">%</sup>-->
                        <p>จำนวนสายส่ง</p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-stats-bars"></i>
                    </div>
                    <a href="<?= Url::to(['deliveryroute/index'], true) ?>" class="small-box-footer">ไปยังสายส่ง <i
                                class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>
            <!-- ./col -->
            <div class="col-lg-3 col-6">
                <!-- small box -->
                <div class="small-box bg-warning">
                    <div class="inner">
                        <h3><?= number_format($car_cnt) ?></h3>
                        <p>จำนวนรถ</p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-person-add"></i>
                    </div>
                    <a href="<?= Url::to(['car/index'], true) ?>" class="small-box-footer">ไปยังข้อมูลรถ <i
                                class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>
            <!-- ./col -->
            <div class="col-lg-3 col-6">
                <!-- small box -->
                <div class="small-box bg-fuchsia">
                    <div class="inner">
                        <h3><?= number_format($order_cnt) ?></h3>
                        <p>จำนวนใบสั่งขาย</p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-pie-graph"></i>
                    </div>
                    <a href="<?= Url::to(['orders/index'], true) ?>" class="small-box-footer">ไปยังรายการขาย <i
                                class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>
            <!-- ./col -->
        </div>

    </div>
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-6">
<!--                    <div class="card">-->
<!--                        <div class="card-header border-0">-->
<!--                            <div class="d-flex justify-content-between">-->
<!--                                <h3 class="card-title">กราฟแสดงรายรับ-รายจ่าย</h3>-->
<!--                                <a href="javascript:void(0);">รายละเอียด</a>-->
<!--                            </div>-->
<!--                        </div>-->
<!--                        <div class="card-body">-->
<!--                            <div class="d-flex">-->
<!--                                <p class="d-flex flex-column">-->
<!--                                    <span class="text-bold text-lg">82,000</span>-->
<!--                                    <span>มูลค่า</span>-->
<!--                                </p>-->
<!--                                <p class="ml-auto d-flex flex-column text-right">-->
<!--                    <span class="text-success">-->
<!--                      <i class="fas fa-arrow-up"></i> 12.5%-->
<!--                    </span>-->
<!--                                    <span class="text-muted">Since last week</span>-->
<!--                                </p>-->
<!--                            </div>-->
<!--                            <!-- /.d-flex -->
<!---->
<!--                            <div class="position-relative mb-4">-->
<!--                                <canvas id="visitors-chart" height="200"></canvas>-->
<!--                            </div>-->
<!---->
<!--                            <div class="d-flex flex-row justify-content-end">-->
<!--                  <span class="mr-2">-->
<!--                    <i class="fas fa-square text-primary"></i> เดือนนี้-->
<!--                  </span>-->
<!---->
<!--                                <span>-->
<!--                    <i class="fas fa-square text-gray"></i> เดือนที่แล้ว-->
<!--                  </span>-->
<!--                            </div>-->
<!--                        </div>-->
<!--                    </div>-->
                    <!-- /.card -->
                    <div class="card">
                        <div class="card-header border-0">
                            <div class="d-flex justify-content-between">
                                <h3 class="card-title">ยอดขายแยกประเภทขาย</h3>
                                <a href="javascript:void(0);">รายละเอียด</a>
                            </div>
                        </div>
                        <div class="card-body">
<!--                            <div class="d-flex">-->
<!--                                <p class="d-flex flex-column">-->
<!--                                    <span class="text-bold text-lg">18,230.00</span>-->
<!--                                    <span>มูลค่า</span>-->
<!--                                </p>-->
<!--                            </div>-->
                            <!-- /.d-flex -->

                            <div class="position-relative mb-12">
                                <?php
                                echo Highcharts::widget([
                                    'options' => [
                                        'title' => ['text' => ''],
                                        'subtitle'=>['text'=>''],
                                        'xAxis' => [
                                            'categories' => $category
                                        ],
                                        'yAxis' => [
                                            'title' => ['text' => 'ยอดเงิน']
                                        ],
                                        'series' => $data_by_type
                                    ]
                                ]);
                                ?>
                            </div>

                        </div>
                    </div>

                    <!--                     -------->

                    <div class="card">
                        <div class="card-header border-0">
                            <h3 class="card-title">แนวโน้วยอดขายเปรียบเทียบรายเดือน</h3>
                            <div class="card-tools">
                                <a href="#" class="btn btn-tool btn-sm">
                                    <i class="fas fa-download"></i>
                                </a>
                                <a href="#" class="btn btn-tool btn-sm">
                                    <i class="fas fa-bars"></i>
                                </a>
                            </div>
                        </div>
                        <div class="card-body table-responsive p-0">
                            <table class="table table-striped table-valign-middle">
                                <thead>
                                <tr>
                                    <th>รหัสสินค้า</th>
                                    <th>จำนวนเงิน</th>
                                    <th>Sales</th>
                                    <th>More</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr>
                                    <td>
                                        <img src="dist/img/default-150x150.png" alt="Product 1"
                                             class="img-circle img-size-32 mr-2">
                                        PB หลอดใหญ่
                                    </td>
                                    <td>1,300</td>
                                    <td>
                                        <small class="text-success mr-1">
                                            <i class="fas fa-arrow-up"></i>
                                            12%
                                        </small>
                                    </td>
                                    <td>
                                        <a href="#" class="text-muted">
                                            <i class="fas fa-search"></i>
                                        </a>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <img src="dist/img/default-150x150.png" alt="Product 1"
                                             class="img-circle img-size-32 mr-2">
                                        PB หลอดเล็ก
                                    </td>
                                    <td>29,000</td>
                                    <td>
                                        <small class="text-warning mr-1">
                                            <i class="fas fa-arrow-down"></i>
                                            0.5%
                                        </small>
                                    </td>
                                    <td>
                                        <a href="#" class="text-muted">
                                            <i class="fas fa-search"></i>
                                        </a>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <img src="dist/img/default-150x150.png" alt="Product 1"
                                             class="img-circle img-size-32 mr-2">
                                        PC แพ็คโม่
                                    </td>
                                    <td>1,230</td>
                                    <td>
                                        <small class="text-danger mr-1">
                                            <i class="fas fa-arrow-down"></i>
                                            3%
                                        </small>
                                    </td>
                                    <td>
                                        <a href="#" class="text-muted">
                                            <i class="fas fa-search"></i>
                                        </a>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <img src="dist/img/default-150x150.png" alt="Product 1"
                                             class="img-circle img-size-32 mr-2">
                                        P2KG น้ำแข็งแพ็ค2กก.
                                        <span class="badge bg-danger">สินค้าขายดี</span>
                                    </td>
                                    <td>19,900</td>
                                    <td>
                                        <small class="text-success mr-1">
                                            <i class="fas fa-arrow-up"></i>
                                            63%
                                        </small>
                                    </td>
                                    <td>
                                        <a href="#" class="text-muted">
                                            <i class="fas fa-search"></i>
                                        </a>
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <!-- /.card -->
                </div>
                <!-- /.col-md-6 -->
                <div class="col-lg-6">
                    <div class="card">
                        <div class="card-header border-0">
                            <div class="d-flex justify-content-between">
                                <h3 class="card-title">ยอดขายแยกตามประเภทสินค้า</h3>
                                <a href="javascript:void(0);">รายละเอียด</a>
                            </div>
                        </div>
                        <div class="card-body">
<!--                            <div class="d-flex">-->
<!--                                <p class="d-flex flex-column">-->
<!--                                    <span class="text-bold text-lg">18,230.00</span>-->
<!--                                    <span>มูลค่า</span>-->
<!--                                </p>-->
<!--                                <p class="ml-auto d-flex flex-column text-right">-->
<!--                    <span class="text-success">-->
<!--                      <i class="fas fa-arrow-up"></i> 33.1%-->
<!--                    </span>-->
<!--                                    <span class="text-muted">Since last month</span>-->
<!--                                </p>-->
<!--                            </div>-->
                            <!-- /.d-flex -->

                            <div class="position-relative mb-4">
                                <?php
                                echo Highcharts::widget([
                                    'options' => [
                                        'chart' => [
                                            'type' => 'column',
                                        ],
                                        'title' => ['text' => ''],
                                        'subtitle'=>['text'=>''],
                                        'xAxis' => [
                                            'categories' => ''
                                        ],
                                        'yAxis' => [
                                            'title' => ['text' => 'ยอดเงิน']
                                        ],
                                        'series' => $data_by_type
                                    ]
                                ]);
                                ?>
                            </div>

                        </div>
                    </div>
                    <!-- /.card -->

                    <div class="card">
                        <div class="card-header border-0">
                            <h3 class="card-title">ยอดขายแสดงตามช่องทางการขาย</h3>
                            <div class="card-tools">
                                <a href="#" class="btn btn-sm btn-tool">
                                    <i class="fas fa-download"></i>
                                </a>
                                <a href="#" class="btn btn-sm btn-tool">
                                    <i class="fas fa-bars"></i>
                                </a>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center border-bottom mb-3">
                                <p class="text-success text-xl">
                                    <i class="ion ion-ios-refresh-empty"></i>
                                </p>
                                <p class="d-flex flex-column text-right">
                    <span class="font-weight-bold">
                      <i class="ion ion-android-arrow-up text-success"></i> <?= number_format($order_pos_cnt) ?>
                    </span>
                                    <span class="text-muted">POS</span>
                                </p>
                            </div>
                            <!-- /.d-flex -->
                            <div class="d-flex justify-content-between align-items-center border-bottom mb-3">
                                <p class="text-warning text-xl">
                                    <i class="ion ion-ios-cart-outline"></i>
                                </p>
                                <p class="d-flex flex-column text-right">
                    <span class="font-weight-bold">
                      <i class="ion ion-android-arrow-up text-warning"></i> <?= number_format($order_normal_cnt) ?>
                    </span>
                                    <span class="text-muted">ขายหน่วยรถ</span>
                                </p>
                            </div>
                            <!-- /.d-flex -->
                        </div>
                    </div>
                </div>
                <!-- /.col-md-6 -->
            </div>
            <!-- /.row -->
        </div>
        <!-- /.container-fluid -->
    </div>
</div>
<br/>

<?php

$js = <<<JS
$(function(){
    aleret();
})
JS;

$this->registerJs($js, static::POS_END);
?>
