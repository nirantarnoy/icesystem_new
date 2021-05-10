<?php

namespace backend\controllers;

use backend\models\Cardaily;
use backend\models\Employee;
use backend\models\Orderline;

//use backend\models\WarehouseSearch;
use backend\models\Pricegroup;
use common\models\PriceCustomerType;
use Yii;
use backend\models\Orders;
use backend\models\OrdersSearch;
use yii\helpers\Json;
use yii\helpers\Url;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use kartik\date\DatePicker;
use kartik\time\TimePicker;


class OrdersController extends Controller
{
    public $enableCsrfValidation = false;

    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    public function actionIndex()
    {

//        $model = \backend\models\Orders::find()->where(['emp_count'=>null])->all();
//        foreach ($model as $value){
//            $x = \common\models\QueryCarDailyEmpCount::find()->where(['car_id'=>$value->car_ref_id,'date(trans_date)'=>date('Y-m-d',strtotime($value->order_date))])->one();
//            if($x){
//                echo $x->emp_qty.'<br />';
//                $model_update = \backend\models\Orders::find()->where(['id'=>$value->id])->one();
//                $model_update->emp_count = $x->emp_qty;
//                $model_update->save(false);
//            }
//        }

        $pageSize = \Yii::$app->request->post("perpage");
        $searchModel = new OrdersSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $dataProvider->query->limit(300);
        $dataProvider->setSort(['defaultOrder' => ['order_date' => SORT_DESC, 'order_no' => SORT_DESC]]);
        $dataProvider->pagination->defaultPageSize = 50;
        $dataProvider->pagination->pageSize = $pageSize;

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'perpage' => $pageSize,
        ]);
    }

    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    public function actionCreate()
    {
        $company_id = 1;
        $branch_id = 1;
        if (isset($_SESSION['user_company_id'])) {
            $company_id = $_SESSION['user_company_id'];
        }
        if (isset($_SESSION['user_branch_id'])) {
            $branch_id = $_SESSION['user_branch_id'];
        }

        $model = new Orders();
        if ($model->load(Yii::$app->request->post())) {
            set_time_limit(0);
            $price_group_list_arr = null;
            // $line_customer_id = \Yii::$app->request->post('line_customer_id');
            $line_price = \Yii::$app->request->post('line_qty_cal');
            $price_group_list = \Yii::$app->request->post('price_group_list');
            $price_group_list_arr = explode(',', $price_group_list);

            //  print_r($model->issue_id);return;

//            var_dump(Yii::$app->request->post());
//            return;
//             print_r($line_customer_id);return;
//            print "<pre>";
//            print_r(Yii::$app->request->post());
//            print "</pre>";
//            return;
            // print_r(\Yii::$app->request->post());
            // echo count($price_group_list_arr);return;

            //  echo $model->issue_id;return;

            $x_date = explode('/', $model->order_date);
            $sale_date = date('Y-m-d');
            if (count($x_date) > 1) {
                $sale_date = $x_date[2] . '/' . $x_date[1] . '/' . $x_date[0];
            }
            $model->order_no = $model::getLastNo($sale_date, $company_id, $branch_id);
            $model->order_date = date('Y-m-d', strtotime($sale_date));
            $model->status = 1;
            $model->sale_channel_id = 1;
            $model->company_id = $company_id;
            $model->branch_id = $branch_id;
            if ($model->save(false)) {
                $this->updateEmpqty($model->id);
                if ($price_group_list_arr != null) {
                    for ($x = 0; $x <= count($price_group_list_arr) - 1; $x++) {
                        if ($price_group_list_arr[$x] == '') {
                            continue;
                        }
                        //echo count($price_group_list_arr);return;
                        $customer_id = \Yii::$app->request->post('line_customer_id' . $price_group_list_arr[$x]);
                        $customer_line_bill = \Yii::$app->request->post('line_bill_no' . $price_group_list_arr[$x]);
                        if (count($customer_id) > 0) {
                            // echo "has data= ".count($customer_id);return;
                            $product_list = \backend\models\Product::find()->where(['company_id' => $company_id, 'branch_id' => $branch_id])->all();
                            for ($i = 0; $i <= count($customer_id) - 1; $i++) {
                                $cust_id = $customer_id[$i];
                                $x_id = -1;
                                $price_list_loop = $price_group_list_arr[$x];
                                foreach ($product_list as $prods) {
                                    if (\Yii::$app->request->post($prods->code . $price_list_loop) != null) {
                                        $x_id += 1;
                                        // $prod_line = \Yii::$app->request->post($prods->code);
                                        $prod_line_qty = \Yii::$app->request->post('line_qty_' . $prods->code . $price_list_loop);
                                        $line_sale_price = \Yii::$app->request->post('line_sale_price_' . $prods->code . $price_list_loop);
                                        //  print_r($prod_line_qty);return;

                                        //  if(count($prod_line) > 0){
                                        // for($x=0;$x<=count($prod_line)-1;$x++){

                                        $line_x_qty = $prod_line_qty[$i] == null ? 0 : $prod_line_qty[$i];
                                        $line_x_price = $line_sale_price[$i] == null ? 0 : $line_sale_price[$i];

                                        $model_line = new \backend\models\Orderline();
                                        $model_line->order_id = $model->id;
                                        $model_line->customer_id = $customer_id[$i];
                                        $model_line->bill_no = $customer_line_bill[$i];
                                        $model_line->product_id = $prods->id;
                                        $model_line->qty = $line_x_qty;
                                        $model_line->price = $line_x_price;
                                        $model_line->line_total = ($line_x_qty * $line_x_price);
                                        $model_line->price_group_id = $price_list_loop;
                                        $model_line->save(false);
                                        // }
                                        //  }

                                    }
                                }
                            }
                        } else {
                            echo "not have data";
                            return;
                        }
                    }
                } else {
                    echo "not have price group";
                    return;
                }
//                if (count($line_customer_id) > 0) {
//                    $product_list = \backend\models\Product::find()->all();
//                    for ($i = 0; $i <= count($line_customer_id) - 1; $i++) {
//                        $cust_id = $line_customer_id[$i];
//                        $x_id = -1;
//                        foreach ($product_list as $prods) {
//                            if (\Yii::$app->request->post($prods->code) != null) {
//                                $x_id += 1;
//                                // $prod_line = \Yii::$app->request->post($prods->code);
//                                $prod_line_qty = \Yii::$app->request->post('line_qty_' . $prods->code);
//                                $line_sale_price = \Yii::$app->request->post('line_sale_price_' . $prods->code);
//                                // print_r($prod_line_qty);return;
//
//                                //  if(count($prod_line) > 0){
//                                // for($x=0;$x<=count($prod_line)-1;$x++){
//                                $model_line = new \backend\models\Orderline();
//                                $model_line->order_id = $model->id;
//                                $model_line->customer_id = $line_customer_id[$i];
//                                $model_line->product_id = $prods->id;
//                                $model_line->qty = $prod_line_qty[$i];
//                                $model_line->price = $line_sale_price[$i];
//                                $model_line->line_total = $prod_line_qty[$i] * $line_sale_price[$i];
//                                $model_line->save(false);
//                                // }
//                                //  }
//
//                            }
//                        }
//
//                    }
//                }


                if ($model->issue_id != null) {
                    for ($i = 0; $i <= count($model->issue_id) - 1; $i++) {
                        $model_issue = \backend\models\Journalissue::find()->where(['id' => $model->issue_id[$i]])->one();
                        if ($model_issue) {
                            $model_issue->status = 2;
                            $model_issue->order_ref_id = $model->id;
                            $model_issue->save();
                        }
                        $model_loop_issue = \backend\models\Journalissueline::find()->where(['issue_id' => $model->issue_id[$i]])->all();
                        foreach ($model_loop_issue as $val2) {
                            $model_order_stock = new \common\models\OrderStock();
                            $model_order_stock->issue_id = $model_issue->id;
                            $model_order_stock->product_id = 1;
                            $model_order_stock->qty = $val2->qty;
                            $model_order_stock->used_qty = 0;
                            $model_order_stock->avl_qty = $val2->qty;
                            $model_order_stock->order_id = $model->id;
                            $model_order_stock->save();
                        }
                    }
                }

//                if ($model->issue_id > 0) {
//                    $model_issue = \backend\models\Journalissue::find()->where(['id' => $model->issue_id])->one();
//                    if ($model_issue) {
//                        $model_issue->status = 2;
//                        $model_issue->order_ref_id = $model->id;
//                        $model_issue->save();
//                    }
//                }

                $session = Yii::$app->session;
                $session->setFlash('msg', 'บันทึกรายการเรียบร้อย');
                //   return $this->redirect(['index']);
                return $this->redirect(['orders/update', 'id' => $model->id]);
            }
        }
        return $this->render('create', [
            'model' => $model,

        ]);
    }

    public function updateEmpqty($order_id)
    {
        $model = \backend\models\Orders::find()->where(['id' => $order_id])->one();
        if ($model) {
            $x = \common\models\QueryCarDailyEmpCount::find()->where(['car_id' => $model->car_ref_id, 'date(trans_date)' => date('Y-m-d', strtotime($model->order_date))])->one();
            if ($x) {
                echo $x->emp_qty . '<br />';
                $model_update = \backend\models\Orders::find()->where(['id' => $order_id])->one();
                $model_update->emp_count = $x->emp_qty;
                $model_update->save(false);
            }
        }
    }

    public function actionUpdate($id)
    {
        $company_id = 1;
        $branch_id = 1;
        if (isset($_SESSION['user_company_id'])) {
            $company_id = $_SESSION['user_company_id'];
        }
        if (isset($_SESSION['user_branch_id'])) {
            $branch_id = $_SESSION['user_branch_id'];
        }

        $model = $this->findModel($id);
        $model_line = \backend\models\Orderline::find()->where(['order_id' => $id])->all();

        $model_has_transfer = \backend\models\Journaltransfer::find()->where(['order_target_id' => $id, 'status' => 1])->one();
        $order_issue_list = \common\models\OrderStock::find()->where(['order_id' => $id])->all();
        //$model_car_emp  = \common\models\CarDaily::find()->where()->all();

        if ($model->load(Yii::$app->request->post())) {
//            $prod_id = \Yii::$app->request->post('product_id');
//            $qty = \Yii::$app->request->post('line_qty');
//            $price = \Yii::$app->request->post('line_price');
            $removelist = Yii::$app->request->post('removelist');
            $line_customer_id = \Yii::$app->request->post('line_customer_id');
            $line_price = \Yii::$app->request->post('line_qty_cal');

            $price_group_list = \Yii::$app->request->post('price_group_list');
            $price_group_list_arr = explode(',', $price_group_list);

            $x_date = explode('/', $model->order_date);
            $sale_date = date('Y-m-d');
            if (count($x_date) > 1) {
                $sale_date = $x_date[2] . '/' . $x_date[1] . '/' . $x_date[0];
            }
            $model->order_date = date('Y-m-d', strtotime($sale_date));
            $model->status = 1;
            if ($model->save()) {

                if (count($price_group_list_arr) > 0) {
                    for ($x = 0; $x <= count($price_group_list_arr) - 1; $x++) {
                        if ($price_group_list_arr[$x] == '') {
                            continue;
                        }
                        $customer_id = \Yii::$app->request->post('line_customer_id' . $price_group_list_arr[$x]);
                        $customer_line_bill = \Yii::$app->request->post('line_bill_no' . $price_group_list_arr[$x]);
                        if (count($customer_id) > 0) {
                            $product_list = \backend\models\Product::find()->where(['company_id' => $company_id, 'branch_id' => $branch_id])->all();
                            for ($i = 0; $i <= count($customer_id) - 1; $i++) {
                                $cust_id = $customer_id[$i];
                                $x_id = -1;
                                $price_list_loop = $price_group_list_arr[$x];
                                foreach ($product_list as $prods) {
                                    if (\Yii::$app->request->post($prods->code . $price_list_loop) != null) {
                                        $x_id += 1;
                                        // $prod_line = \Yii::$app->request->post($prods->code);
                                        $prod_line_qty = \Yii::$app->request->post('line_qty_' . $prods->code . $price_list_loop);
                                        $line_sale_price = \Yii::$app->request->post('line_sale_price_' . $prods->code . $price_list_loop);
                                        // print_r($prod_line_qty);return;

                                        //  if(count($prod_line) > 0){
                                        // for($x=0;$x<=count($prod_line)-1;$x++){

                                        $line_x_qty = $prod_line_qty[$i] == null ? 0 : $prod_line_qty[$i];
                                        $line_x_price = $line_sale_price[$i] == null ? 0 : $line_sale_price[$i];

                                        $model_has = $this->check_has_line($id, $customer_id[$i], $prods->id, $price_list_loop);
                                        if ($model_has != null) {
                                            $model_has->qty = $line_x_qty;
                                            $model_has->price = $line_x_price;
                                            $model_has->bill_no = $customer_line_bill[$i];
                                            $model_has->line_total = ($line_x_qty * $line_x_price);
                                            $model_has->save(false);
                                        } else {
                                            $model_line_new = new \backend\models\Orderline();
                                            $model_line_new->order_id = $model->id;
                                            $model_line_new->customer_id = $customer_id[$i];
                                            $model_line_new->bill_no = $customer_line_bill[$i];
                                            $model_line_new->product_id = $prods->id;
                                            $model_line_new->qty = $line_x_qty;
                                            $model_line_new->price = $line_x_price;
                                            $model_line_new->line_total = ($line_x_qty * $line_x_price);
                                            $model_line_new->price_group_id = $price_list_loop;
                                            $model_line_new->save(false);
                                        }

                                        // }
                                        //  }

                                    }
                                }

                            }
                        }
                    }
                }

                if ($removelist != '') {
                    //print_r($removelist);return;
                    $rec_del = explode(',', $removelist);
//                    print_r($rec_del);return;
                    for ($i = 0; $i <= count($rec_del) - 1; $i++) {
                        \backend\models\Orderline::deleteAll(['order_id' => $model->id, 'customer_id' => $rec_del[$i]]);
                    }

                }
                $session = Yii::$app->session;
                $session->setFlash('msg', 'บันทึกข้อมูลค้าเรียบร้อย');
                return $this->redirect(['index']);
            }
        }

        return $this->render('update', [
            'model' => $model,
            'model_line' => $model_line,
            'model_has_transfer' => $model_has_transfer,
            'order_issue_list' => $order_issue_list
        ]);
    }

    public function check_has_line($order_id, $customer_id, $prod_id, $price_group_id)
    {
        $model = \backend\models\Orderline::find()->where(['order_id' => $order_id, 'customer_id' => $customer_id, 'product_id' => $prod_id, 'price_group_id' => $price_group_id])->one();
        return $model;
    }

    public function actionDelete($id)
    {
        Orderline::deleteAll(['order_id' => $id]);
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    protected function findModel($id)
    {
        if (($model = Orders::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }

    public function actionFindCustomer($id)
    {
        $model = \common\models\Customer::find()->where(['delivery_route_id' => $id])->all();
        if ($model != null) {
            foreach ($model as $value) {
                echo "<option value='" . $value->id . "'>$value->name</option>";
            }
        } else {
            echo "<option></option>";
        }
    }

    public function actionFindCarData()
    {
        $id = \Yii::$app->request->post('id');
        if ($id) {
            $model = \common\models\SaleGroup::find()->where(['delivery_route_id' => $id])->one();
            if ($model) {
                $model_car = \backend\models\Car::find()->where(['sale_group_id' => $model->id])->all();
                echo "<option value=''>--เลือกรถ--</option>";
                foreach ($model_car as $value) {
                    echo "<option value='" . $value->id . "'>$value->code $value->name</option>";
                }
            } else {
                echo "<option></option>";
            }
        } else {
            echo "<option></option>";
        }

    }

    public function actionFindIssueData()
    {
        $id = \Yii::$app->request->post('id');
        if ($id) {
            $model = \common\models\JournalIssue::find()->where(['delivery_route_id' => $id, 'status' => 1])->all();
            if ($model) {
//                $model_car = \backend\models\Car::find()->where(['sale_group_id' => $model->id])->all();
//                echo "<option value=''>--เลือกใบเบิก--</option>";
                foreach ($model as $value) {
                    echo "<option value='" . $value->id . "'>$value->name</option>";
                }
            } else {
                echo "<option></option>";
            }
        } else {
            echo "<option></option>";
        }

    }

    public function actionFindTermData()
    {
        $id = \Yii::$app->request->post('id');
        if ($id) {
            $model = \common\models\PaymentTerm::find()->where(['payment_method_id' => $id])->all();
            if ($model) {
                echo "<option value=''>--เงื่อนไขชำระเงิน--</option>";
                foreach ($model as $value) {
                    echo "<option value='" . $value->id . "'>$value->name</option>";
                }
            } else {
                echo "<option></option>";
            }
        } else {
            echo "<option></option>";
        }

    }

    public function actionFindPricegroup()
    {
        $html = '';
        $route_id = \Yii::$app->request->post('route_id');
        $price_group_list = [];

        if ($route_id > 0) {
            $model = \backend\models\Customer::find()->select(['customer_type_id'])->where(['delivery_route_id' => $route_id])->groupBy('customer_type_id')->all();
            if ($model) {
                $html .= '
                <ul class="nav nav-tabs" id="custom-tabs-one-tab" role="tablist">
               ';
                $x = 0;

                foreach ($model as $value_) {
                    $is_active = '';
                    if ($x == 0) {
                        $is_active = 'active';
                        $x += 1;
                    }
                    $model_type = PriceCustomerType::find()->where(['customer_type_id' => $value_->customer_type_id])->groupBy('price_group_id')->one();
                    if ($model_type) {
                        $pricegroup_name = Pricegroup::findName($model_type->price_group_id);
                        array_push($price_group_list, $model_type->price_group_id);
                        $html .= '
                       <li class="nav-item">
                            <a class="nav-link ' . $is_active . '" id="custom-tabs-one-home-tab' . $model_type->price_group_id . '" data-toggle="pill"
                               href="#custom-tabs-one-home' . $model_type->price_group_id . '" role="tab" aria-controls="custom-tabs-one-home"
                               aria-selected="true" data-var="' . $model_type->price_group_id . '" onclick="updatetab($(this))">' . $pricegroup_name . '</a>
                        </li>
                       ';

                    }
                }
                $html .= '</ul>';

//               $html.='
//                  <div class="tab-content" id="custom-tabs-one-tabContent">
//                        <div class="tab-pane fade show active" id="custom-tabs-one-home" role="tabpanel"
//                             aria-labelledby="custom-tabs-one-home-tab">
//                            <table class="table" id="table-sale-list">
//                        </div>
//                    </div>
//               ';

                if (count($price_group_list) > 0) {

                    $html .= '<div class="tab-content" id="custom-tabs-one-tabContent">';
                    $list = '';
                    for ($i = 0; $i <= count($price_group_list) - 1; $i++) {
                        $is_active2 = '';
                        if ($i == 0) {
                            $is_active2 = 'active';
                        }
                        $list = $list . $price_group_list[$i] . ',';
                        $html .= '
                            <div class="tab-pane fade show ' . $is_active2 . '" id="custom-tabs-one-home' . $price_group_list[$i] . '" role="tabpanel"
                             aria-labelledby="custom-tabs-one-home-tab">';
                        $html .= '<input type="hidden" name="price_group_list" value="' . $list . '">';
                        $html .= '<table class="table" id="table-sale-list' . $price_group_list[$i] . '">';
                        $html .= $this->gettablelist($price_group_list[$i]);
                        $html .= '</table>
                            </div>
                       ';
                    }
//                    $html .= '<input type="hidden" name="price_group_list" value="' . $list . '">';
                    $html .= '</div>';
                }
            }
        }
        return $html;
    }

    public function gettablelist($price_group_id)
    {
        $html = '';
        if ($price_group_id > 0) {
            $model_customer_type = PriceCustomerType::find()->where(['price_group_id' => $price_group_id])->all();
            $html .= '<thead>';
            $html .= '<tr>';
            $html .= '<th style="width: 5%;text-align: center"><input type="checkbox" class="selected-all-item"></th>';
            $html .= '<th style="width: 5%;text-align: center">#</th>';
//            $html .= '<th style="width: 8%">รหัสลูกค้า</th>';
            $html .= '<th style="width: 10%">ชื่อลูกค้า</th>';
            $html .= '<th style="width: 8%;text-align: center">เลขที่บิล</th>';
            $html .= $this->getProductcolumn2($price_group_id);
            $html .= '<th style="width: 8%;text-align: right">รวมจำนวน</th>';
            $html .= '<th style="text-align: right">รวมเงิน</th>';
            $html .= '<th style="text-align: center">-</th>';
            $html .= '</tr>';
            $html .= '</thead>';

            foreach ($model_customer_type as $value) {
                $model = \backend\models\Customer::find()->where(['customer_type_id' => $value->customer_type_id])->all();
                if (count($model) > 0) {
                    $html .= '<tbody>';
                    $i = 0;
                    foreach ($model as $val) {
                        $i += 1;
                        $html .= '<tr>';
                        $html .= '<td style="text-align: center"><input type="checkbox" class="selected-all-item"></td>';
                        $html .= '<td style="text-align: center">' . $i . '</td>';
//                        $html .= '<td>' . \backend\models\Customer::findCode($val->id) . '<input type="hidden" class="line-customer-id" name="line_customer_id' . $price_group_id . '[]" value="' . $val->id . '"></td>';
                        $html .= '<td>' . \backend\models\Customer::findName($val->id) . '<input type="hidden" class="line-customer-id" name="line_customer_id' . $price_group_id . '[]" value="' . $val->id . '"></td>';
                        //      $html .= '<td>' . \backend\models\Customer::findName($val->id) . '</td>';
                        $html .= '<td><input type="text" style="background-color: #258faf;color: white" class="form-control" name="line_bill_no' . $price_group_id . '[]" value=""></td>';
                        $html .= $this->getProducttextfield2($price_group_id);
                        $html .= '<td style="text-align: right"><input type="text" disabled class="form-control line-qty-cal" name="line_qty_cal[]" style="text-align: right"></td>';
                        $html .= '<td style="text-align: right"><input type="text" disabled class="form-control line-total-price" style="text-align: right"><input type="hidden" class="form-control line-total-price-cal" style="text-align: right"></td>';
                        $html .= '<td style="text-align: center"></td>';
                        $html .= '</tr>';
                    }
                    $html .= '</tbody>';
                }
            }
        }

        return $html;
    }

    public function getProductcolumn2($price_group_id)
    {
        $html = '';
        $model = \common\models\PriceGroupLine::find()->where(['price_group_id' => $price_group_id])->all();
        foreach ($model as $value) {
            $new_price = '<span style="color: red">' . $value->sale_price . '</span>';
            $html .= '<th style="text-align: center">' . \backend\models\Product::findCode($value->product_id) . ' ( ' . $new_price . ' ) ' . '</th>';
        }
        return $html;
    }

    public function getProductcolumn22($order_id, $price_group_id)
    {
        $html = '';
        $model_price = \common\models\PriceGroupLine::find()->where(['price_group_id' => $price_group_id])->all();
        $sql = 'SELECT COUNT(DISTINCT product_id) as cnt FROM order_line WHERE order_id=' . $order_id . ' AND price_group_id=' . $price_group_id;
        $query = \Yii::$app->db->createCommand($sql)->queryAll();
        $order_prod_cnt = $query[0]['cnt'];
        if (count($model_price) > $order_prod_cnt) {
            foreach ($model_price as $value) {
                $new_price = '<span style="color: red">' . $value->sale_price . '</span>';
                $html .= '<th style="text-align: center">' . \backend\models\Product::findCode($value->product_id) . ' ( ' . $new_price . ' ) ' . '</th>';
            }
        } else {
            $modelx = \common\models\OrderLine::find()->where(['price_group_id' => $price_group_id, 'order_id' => $order_id])->distinct('product_id', 'price')->groupBy('product_id')->all();
            foreach ($modelx as $value) {
                $new_price = '<span style="color: red">' . $value->price . '</span>';
                $html .= '<th style="text-align: center">' . \backend\models\Product::findCode($value->product_id) . ' ( ' . $new_price . ' ) ' . '</th>';
            }
        }


        return $html;
    }

    public function getProducttextfield2($price_group_id)
    {
        $html = '';
        $model = \common\models\QueryProductByPriceGroup::find()->where(['price_group_id' => $price_group_id])->all();
        $i = 0;
        foreach ($model as $value) {
            $i += 1;
            $input_name = "line_qty_" . $value->code . $price_group_id . "[]";
            $input_name_price = "line_sale_price_" . $value->code . $price_group_id . "[]";
            $input_name_price_cal = "line_sale_price_cal" . $value->code . $price_group_id . "[]";
            $line_prod_code = $value->code . $price_group_id . '[]';
            $line_prod_onhand = "line_product_onhand" . $value->code . "[]";

            //$issue_avl_qty = getAvlqty($value->product_id,$issue_id);

            $line_onhand_qty = 100;
            $html .= '<td>
                       <input type="hidden" class="line-qty-' . $i . '">
                       <input type="hidden" class="line-product-code" name="' . $line_prod_code . '" value="' . $value->code . '">
                       <input type="hidden" class="line-sale-price" name="' . $input_name_price . '" value="' . $value->sale_price . '">
                       <input type="hidden" class="line-sale-price-cal" name="' . $input_name_price_cal . '" value="' . $value->sale_price . '">
                       <input type="hidden" class="line-product-onhand" name="' . $line_prod_onhand . '" value="' . $line_onhand_qty . '">
                       <input type="number" name="' . $input_name . '" data-var="' . $value->sale_price . '" style="text-align: center" class="form-control" min="0" value="0" onchange="line_qty_cal($(this))">
                  </td>';
        }
        return $html;
    }

    public function getAvlqty($product_id, $issue_id)
    {
        $qty = 0;
        if ($product_id && $issue_id) {
            $model = \common\models\OrderStock::find()->where(['issue_id' => $issue_id, 'product_id' => $product_id])->one();
            if ($model) {
                $qty = $model->avl_qty;
            }
        }
        return $qty;
    }

    public function actionOrderstockqtyUpdate($product_id, $issue_id, $qty)
    {
        $qty = 0;
        if ($product_id && $issue_id && $qty > 0) {
            $model = \common\models\OrderStock::find()->where(['issue_id' => $issue_id, 'product_id' => $product_id])->one();
            if ($model) {
                $model->used_qty = $qty;
                $model->avl_qty = $model->qty - $model->used_qty;
                $model->save(false);
            }
        }
        return true;
    }

    public function actionFindSaledata()
    {
        $id = \Yii::$app->request->post('id');
        $html = '';
        $model = \common\models\Customer::find()->where(['delivery_route_id' => $id])->all();
        $html .= '<thead>';
        $html .= '<tr>';
        $html .= '<th style="width: 5%;text-align: center"><input type="checkbox" class="selected-all-item"></th>';
        $html .= '<th style="width: 5%;text-align: center">#</th>';
        //$html .= '<th style="width: 8%">รหัสลูกค้า</th>';
        $html .= '<th style="width: 10%">ชื่อลูกค้า</th>';
        $html .= $this->getProductcolumn($id);
        $html .= '<th style="width: 8%;text-align: right">รวมจำนวน</th>';
        $html .= '<th style="text-align: right">รวมเงิน</th>';
        $html .= '<th style="text-align: center">-</th>';
        $html .= '</tr>';
        $html .= '</thead>';

        if (1 > 0) {
            $html .= '<tbody>';
            $i = 0;
            foreach ($model as $value) {
                $i += 1;
                $html .= '<tr>';
                $html .= '<td style="text-align: center"><input type="checkbox" class="selected-all-item"></td>';
                $html .= '<td style="text-align: center">' . $i . '</td>';
                // $html .= '<td>' . \backend\models\Customer::findCode($value->id) . '<input type="hidden" class="line-customer-id" name="line_customer_id[]" value="' . $value->id . '"></td>';
                $html .= '<td>' . \backend\models\Customer::findName($value->id) . '<input type="hidden" class="line-customer-id" name="line_customer_id[]" value="' . $value->id . '"></td>';
                //$html .= '<td>' . \backend\models\Customer::findName($value->id) . '</td>';
                $html .= $this->getProducttextfield($id);
                $html .= '<td style="text-align: right"><input type="text" disabled class="form-control line-qty-cal" name="line_qty_cal[]" style="text-align: right"></td>';
                $html .= '<td style="text-align: right"><input type="text" disabled class="form-control line-total-price" style="text-align: right"><input type="hidden" class="form-control line-total-price-cal" style="text-align: right"></td>';
                $html .= '<td style="text-align: center"><div class="btn btn-danger btn-sm" data-var="" onclick="removeorderline($(this))">ลบ</div></td>';
                $html .= '</tr>';
            }
            $html .= '</tbody>';
        }
        // $html = '<tr><td><input type="text" name="line_customer_id[]" value="niran"></td></tr>';
        echo $html;
    }

    public function getProductcolumn($route_id)
    {
        $html = '';
        $model = \common\models\QueryProductFromRoute::find()->where(['delivery_route_id' => $route_id])->all();
        foreach ($model as $value) {
            $new_price = '<span style="color: red">' . $value->sale_price . '</span>';
            $html .= '<th style="text-align: center">' . $value->code . ' ( ' . $new_price . ' ) ' . '</th>';
        }
        return $html;
    }

    public function getProducttextfield($route_id)
    {
        $html = '';
        $model = \common\models\QueryProductFromRoute::find()->where(['delivery_route_id' => $route_id])->all();
        $i = 0;
        foreach ($model as $value) {

            $i += 1;
            $input_name = "line_qty_" . $value->code . "[]";
            $input_name_price = "line_sale_price_" . $value->code . "[]";
            $input_name_price_cal = "line_sale_price_cal" . $value->code . "[]";
            $line_prod_code = $value->code . '[]';
            $line_prod_onhand = "line_product_onhand" . $value->code . "[]";
            $line_onhand_qty = 100;
            $html .= '<td>
                       <input type="hidden" class="line-qty-' . $i . '">
                       <input type="hidden" class="line-product-code" name="' . $line_prod_code . '" value="' . $value->code . '">
                       <input type="hidden" class="line-sale-price" name="' . $input_name_price . '" value="' . $value->sale_price . '">
                       <input type="hidden" class="line-sale-price-cal" name="' . $input_name_price_cal . '" value="' . $value->sale_price . '">
                       <input type="hidden" class="line-product-onhand" name="' . $line_prod_onhand . '" value="' . $line_onhand_qty . '">
                       <input type="number" name="' . $input_name . '" data-var="' . $value->sale_price . '" style="text-align: center" class="form-control" min="0" value="0" onchange="line_qty_cal($(this))">
                  </td>';
        }
        return $html;
    }

    public function actionFindSaledataUpdate()
    {
        $id = \Yii::$app->request->post('id');
        $price_group_list = [];
        $html = '';
        if ($id) {
            $model_price_group = \backend\models\Orderline::find()->select('price_group_id')->where(['order_id' => $id])->groupBy('price_group_id')->all();
            if ($model_price_group) {

                $html .= '
                <ul class="nav nav-tabs" id="custom-tabs-one-tab" role="tablist">
               ';
                $x = 0;

                foreach ($model_price_group as $value) {
                    if ($value->price_group_id == null) continue;

                    $is_active = '';
                    if ($x == 0) {
                        $is_active = 'active';
                        $x += 1;
                    }

                    $pricegroup_name = Pricegroup::findName($value->price_group_id);
                    array_push($price_group_list, $value->price_group_id);
                    $html .= '
                       <li class="nav-item">
                            <a class="nav-link cur-tab ' . $is_active . '" id="custom-tabs-one-home-tab' . $value->price_group_id . '" data-toggle="pill"
                               href="#custom-tabs-one-home' . $value->price_group_id . '" role="tab" aria-controls="custom-tabs-one-home"
                               aria-selected="true" data-var="' . $value->price_group_id . '" onclick="updatetab($(this))">' . $pricegroup_name . '</a>
                        </li>
                       ';
                }
                $html .= '</ul>';

                if (count($price_group_list) > 0) {

                    $html .= '<div class="tab-content" id="custom-tabs-one-tabContent">';
                    $list = '';
                    for ($i = 0; $i <= count($price_group_list) - 1; $i++) {
                        $is_active2 = '';
                        if ($i == 0) {
                            $is_active2 = 'active';
                        }
                        $list = $list . $price_group_list[$i] . ',';
                        $html .= '
                            <div class="tab-pane fade show ' . $is_active2 . '" id="custom-tabs-one-home' . $price_group_list[$i] . '" role="tabpanel"
                             aria-labelledby="custom-tabs-one-home-tab">';
                        $html .= '<table class="table" id="table-sale-list' . $price_group_list[$i] . '">';
                        $html .= $this->gettablelistupdate($price_group_list[$i], $id);
                        // $html.=$price_group_list[$i];
                        $html .= '</table>
                            </div>
                       ';
                    }
                    $html .= '<input type="hidden" name="price_group_list" value="' . $list . '">';
                    $html .= '</div>';
                }


            }
        }
//        $html = '';
//        $model = \common\models\QueryOrderUpdate::find()->where(['order_id' => $id])->all();
//        $html .= '<thead>';
//        $html .= '<tr>';
//        $html .= '<th style="text-align: center"><input type="checkbox" class="selected-all-item"></th>';
//        $html .= '<th style="width: 5%;text-align: center">#</th>';
//        $html .= '<th style="width: 8%">รหัสลูกค้า</th>';
//        $html .= '<th style="width: 15%">ชื่อลูกค้า</th>';
//        $html .= $this->getProductcolumnUpdate($id);
//        $html .= '<th style="width: 8%;text-align: right">รวมจำนวน</th>';
//        $html .= '<th style="text-align: right">รวมเงิน</th>';
//        $html .= '<th style="text-align: center">-</th>';
//        $html .= '</tr>';
//        $html .= '</thead>';
//
//        if (1 > 0) {
//            $html .= '<tbody>';
//            $i = 0;
//            foreach ($model as $value) {
//                $i += 1;
//                $html .= '<tr>';
//                $html .= '<td style="text-align: center"><input type="checkbox" data-var="' . $value->order_id . '" class="selected-line-item" onchange="showselectpayment($(this))"></td>';
//                $html .= '<td style="text-align: center">' . $i . '</td>';
//                $html .= '<td>' . $value->code . '<input type="hidden" class="line-customer-id" name="line_customer_id[]" value="' . $value->customer_id . '"></td>';
//                $html .= '<td>' . $value->name . '</td>';
//                $html .= $this->getProducttextfieldUpdate($id, $value->customer_id);
//                $html .= '</tr>';
//            }
//            $html .= '</tbody>';
//        }
        // $html = '<tr><td><input type="text" name="line_customer_id[]" value="niran"></td></tr>';
        return $html;
    }

    public function gettablelistupdate($price_group_id, $order_id)
    {
        $html = '';
        if ($price_group_id > 0 && $order_id > 0) {
            $model = \common\models\QueryOrderUpdate::find()->where(['order_id' => $order_id, 'price_group_id' => $price_group_id])->all();
            $html .= '<thead>';
            $html .= '<tr>';
            $html .= '<th style="width: 5%;text-align: center"><input type="checkbox" onchange="showselectpaymentall($(this))" class="selected-all-item"></th>';
            $html .= '<th style="width: 5%;text-align: center">#</th>';
//            $html .= '<th style="width: 8%">รหัสลูกค้า</th>';
            $html .= '<th style="width: 15%">ชื่อลูกค้า</th>';
            $html .= '<th style="width: 10%">เลขที่บิล</th>';
            $html .= $this->getProductcolumn22($order_id, $price_group_id); // getProductcolumn2
//            $html .= $this->getProductcolumn2($price_group_id); // getProductcolumn2
            $html .= '<th style="width: 8%;text-align: right">รวมจำนวน</th>';
            $html .= '<th style="text-align: right">รวมเงิน</th>';
            $html .= '<th style="text-align: center">-</th>';
            $html .= '</tr>';
            $html .= '</thead>';

            if (1 > 0) {
                $html .= '<tbody>';
                $i = 0;

                foreach ($model as $value) {
                    $payment_color = '';
                    $has_payment = $this->haspayment($value->order_id, $value->customer_id);
                    if ($has_payment) {
                        $payment_color = ';background-color: pink';
                    }
                    $i += 1;
                    $html .= '<tr>';
                    $html .= '<td style="text-align: center"><input type="checkbox" data-var="' . $value->customer_id . '" class="selected-line-item" onchange="showselectpayment($(this))"></td>';
                    $html .= '<td style="text-align: center' . $payment_color . '">' . $i . '</td>';
//                    $html .= '<td style="' . $payment_color . '"><a href="' . Url::to(['customer/view', 'id' => $value->customer_id], true) . '">' . $value->code . '</a><input type="hidden" class="line-customer-id" name="line_customer_id' . $price_group_id . '[]" value="' . $value->customer_id . '"></td>';
                    $html .= '<td style="' . $payment_color . '"><a href="' . Url::to(['customer/view', 'id' => $value->customer_id], true) . '">' . $value->name . '</a><input type="hidden" class="line-customer-id" name="line_customer_id' . $price_group_id . '[]" value="' . $value->customer_id . '"></td>';
//                    $html .= '<td style="' . $payment_color . '">' . $value->name . '</td>';
                    $html .= '<td><input type="text" style="background-color: #258faf;color: white" class="form-control" name="line_bill_no' . $price_group_id . '[]" value="' . $value->bill_no . '"></td>';
                    $html .= $this->getProducttextfieldUpdate2($order_id, $value->customer_id, $price_group_id, $has_payment);
                    $html .= '</tr>';
                }
                $html .= '</tbody>';
            }
        }

        return $html;
    }

    public function getProducttextfieldUpdate2($order_id, $customer_id, $price_group_id, $has_payment)
    {
        $html = '';

        $model_price = \common\models\PriceGroupLine::find()->where(['price_group_id' => $price_group_id])->all();
//        $model_order_product = \common\models\OrderLine::find()->where(['order_id' => $order_id, 'price_group_id' => $price_group_id])->distinct('product_id')->count();
        $sql = 'SELECT COUNT(DISTINCT product_id) as cnt FROM order_line WHERE order_id=' . $order_id . ' AND price_group_id=' . $price_group_id;
        $query = \Yii::$app->db->createCommand($sql)->queryAll();
        $model_order_product = $query[0]['cnt'];
        if (count($model_price) > $model_order_product) {
            if ($model_price) {
                $i = 0;
                $line_total_qty = 0;
                $line_total_price = 0;
                foreach ($model_price as $price_value) {
                    // for after add product_id to price group
                    $std_price = $price_value->sale_price;
                    $line_prod_code = \backend\models\Product::findCode($price_value->product_id) . $price_group_id . "[]";
                    $input_name = "line_qty_" . $line_prod_code;
                    $input_name_price = "line_sale_price_" . $line_prod_code;
                    $bg_color = ';background-color:white;color: black';

                    //  $model = \common\models\OrderLine::find()->where(['order_id' => $order_id, 'customer_id' => $customer_id, 'price_group_id' => $price_group_id])->all();
                    $model = \common\models\OrderLine::find()->where(['order_id' => $order_id, 'customer_id' => $customer_id, 'price_group_id' => $price_group_id, 'product_id' => $price_value->product_id])->one();
                    if ($model) {
                        //  foreach ($model as $value) {
                        $i += 1;
//                    $line_prod_code = \backend\models\Product::findCode($model->product_id) . $price_group_id . "[]";
//                    $input_name = "line_qty_" . $line_prod_code . $price_group_id . "[]";
//                    $input_name_price = "line_sale_price_" . $line_prod_code . $price_group_id . "[]";

                        $line_total_qty = $line_total_qty + $model->qty;
                        $line_total_price = $line_total_price + ($model->qty * $model->price);

                        $bg_color = '';
                        $btn_edit = '';

                        if ($model->qty > 0) {
                            $bg_color = ';background-color:#33CC00;color: black';
                        } else {
                            $bg_color = ';background-color:white;color: black';
                        }

                        if ($has_payment) {
                            $btn_edit = '<div class="btn btn-info btn-sm" data-id="' . $order_id . '" data-var="' . $model->customer_id . '" onclick="showeditpayment($(this))">แก้ไข</div>';
                        }

                        $html .= '<td>
                       <input type="hidden" class="line-qty-">
                       <input type="hidden" class="line-product-code" name="' . $line_prod_code . '" value="' . $line_prod_code . '">
                       <input type="hidden" class="line-sale-price" name="' . $input_name_price . '" value="' . $model->price . '">
                       <input type="number" name="' . $input_name . '" data-var="' . $model->price . '" style="text-align: center' . $bg_color . '" value="' . $model->qty . '" class="form-control" min="0" onchange="line_qty_cal($(this))">
                  </td>';
                        //  }

                    } else {
                        $html .= '<td>
                       <input type="hidden" class="line-qty-">
                       <input type="hidden" class="line-product-code" name="' . $line_prod_code . '" value="' . $line_prod_code . '">
                       <input type="hidden" class="line-sale-price" name="' . $input_name_price . '" value="' . $std_price . '">
                       <input type="number" name="' . $input_name . '" data-var="' . $std_price . '" style="text-align: center' . $bg_color . '" value="0" class="form-control" min="0" onchange="line_qty_cal($(this))">
                  </td>';
                    }
                }
                $html .= '<td style="text-align: right"><input type="text" disabled class="form-control line-qty-cal" name="line_qty_cal[]" style="text-align: right" value="' . number_format($line_total_qty) . '"></td>';
                $html .= '<td style="text-align: right"><input type="text" disabled class="form-control line-total-price" style="text-align: right"  value="' . number_format($line_total_price) . '"><input type="hidden" class="form-control line-total-price-cal" style="text-align: right" value="' . $line_total_price . '"></td>';
                $html .= '<td style="text-align: center">' . $btn_edit . '</td>';
            }
        } else {
            $model = \common\models\OrderLine::find()->where(['order_id' => $order_id, 'customer_id' => $customer_id, 'price_group_id' => $price_group_id])->all();
            $i = 0;
            $line_total_qty = 0;
            $line_total_price = 0;
            foreach ($model as $value) {
                $i += 1;
                $line_prod_code = \backend\models\Product::findCode($value->product_id) . $price_group_id . "[]";
                $input_name = "line_qty_" . $line_prod_code . $price_group_id . "[]";
                $input_name_price = "line_sale_price_" . $line_prod_code . $price_group_id . "[]";

                $line_total_qty = $line_total_qty + $value->qty;
                $line_total_price = $line_total_price + ($value->qty * $value->price);

                $bg_color = '';
                $btn_edit = '';

                if ($value->qty > 0) {
                    $bg_color = ';background-color:#33CC00;color: black';
                } else {
                    $bg_color = ';background-color:white;color: black';
                }

                if ($has_payment) {
                    $btn_edit = '<div class="btn btn-info btn-sm" data-id="' . $order_id . '" data-var="' . $value->customer_id . '" onclick="showeditpayment($(this))">แก้ไข</div>';
                }

                $html .= '<td>
                       <input type="hidden" class="line-qty-' . $i . '">
                       <input type="hidden" class="line-product-code" name="' . $line_prod_code . '" value="' . $line_prod_code . '">
                       <input type="hidden" class="line-sale-price" name="' . $input_name_price . '" value="' . $value->price . '">
                       <input type="number" name="' . $input_name . '" data-var="' . $value->price . '" style="text-align: center' . $bg_color . '" value="' . $value->qty . '" class="form-control" min="0" onchange="line_qty_cal($(this))">
                  </td>';
            }
            $html .= '<td style="text-align: right"><input type="text" disabled class="form-control line-qty-cal" name="line_qty_cal[]" style="text-align: right" value="' . number_format($line_total_qty) . '"></td>';
            $html .= '<td style="text-align: right"><input type="text" disabled class="form-control line-total-price" style="text-align: right"  value="' . number_format($line_total_price) . '"><input type="hidden" class="form-control line-total-price-cal" style="text-align: right" value="' . $line_total_price . '"></td>';
            $html .= '<td style="text-align: center">' . $btn_edit . '</td>';

        }


        return $html;
    }

    public function haspayment($order_id, $customer_id)
    {
        $model = \common\models\QueryPayment::find()->where(['order_id' => $order_id, 'customer_id' => $customer_id])->count();
        return $model;
    }
//    public function actionFindSaledataUpdate()
//    {
//        $id = \Yii::$app->request->post('id');
//        $html = '';
//        $model = \common\models\QueryOrderUpdate::find()->where(['order_id' => $id])->all();
//        $html .= '<thead>';
//        $html .= '<tr>';
//        $html .= '<th style="text-align: center"><input type="checkbox" class="selected-all-item"></th>';
//        $html .= '<th style="width: 5%;text-align: center">#</th>';
//        $html .= '<th style="width: 8%">รหัสลูกค้า</th>';
//        $html .= '<th style="width: 15%">ชื่อลูกค้า</th>';
//        $html .= $this->getProductcolumnUpdate($id);
//        $html .= '<th style="width: 8%;text-align: right">รวมจำนวน</th>';
//        $html .= '<th style="text-align: right">รวมเงิน</th>';
//        $html .= '<th style="text-align: center">-</th>';
//        $html .= '</tr>';
//        $html .= '</thead>';
//
//        if (1 > 0) {
//            $html .= '<tbody>';
//            $i = 0;
//            foreach ($model as $value) {
//                $i += 1;
//                $html .= '<tr>';
//                $html .= '<td style="text-align: center"><input type="checkbox" data-var="' . $value->order_id . '" class="selected-line-item" onchange="showselectpayment($(this))"></td>';
//                $html .= '<td style="text-align: center">' . $i . '</td>';
//                $html .= '<td>' . $value->code . '<input type="hidden" class="line-customer-id" name="line_customer_id[]" value="' . $value->customer_id . '"></td>';
//                $html .= '<td>' . $value->name . '</td>';
//                $html .= $this->getProducttextfieldUpdate($id, $value->customer_id);
//                $html .= '</tr>';
//            }
//            $html .= '</tbody>';
//        }
//        // $html = '<tr><td><input type="text" name="line_customer_id[]" value="niran"></td></tr>';
//        echo $html;
//    }

    public function getProductcolumnUpdate($order_id)
    {
        $html = '';
        $model = \common\models\OrderLine::find()->select(['product_id', 'price'])->where(['order_id' => $order_id])->groupBy(['product_id'])->all();
        foreach ($model as $value) {
            $new_price = '<span style="color: red">' . $value->price . '</span>';
            $html .= '<th style="text-align: center">' . \backend\models\Product::findCode($value->product_id) . ' ( ' . $new_price . ' ) ' . '</th>';
            //  $html .= '<th style="text-align: center">' . \backend\models\Product::findCode($value->product_id) . '</th>';
        }
        return $html;
    }

    public function getProducttextfieldUpdate($order_id, $customer_id)
    {
        $html = '';
        $model = \common\models\OrderLine::find()->where(['order_id' => $order_id, 'customer_id' => $customer_id])->all();
        $i = 0;
        $line_total_qty = 0;
        $line_total_price = 0;
        foreach ($model as $value) {
            $i += 1;
            $line_prod_code = \backend\models\Product::findCode($value->product_id) . "[]";
            $input_name = "line_qty_" . $line_prod_code;
            $input_name_price = "line_sale_price_" . $line_prod_code;

            $line_total_qty = $line_total_qty + $value->qty;
            $line_total_price = $line_total_price + ($value->qty * $value->price);

            $html .= '<td>
                       <input type="hidden" class="line-qty-' . $i . '">
                       <input type="hidden" class="line-product-code" name="' . $line_prod_code . '" value="' . $line_prod_code . '">
                       <input type="hidden" class="line-sale-price" name="' . $input_name_price . '" value="' . $value->price . '">
                       <input type="number" name="' . $input_name . '" data-var="' . $value->price . '" style="text-align: center" value="' . $value->qty . '" class="form-control" min="0" onchange="line_qty_cal($(this))">
                  </td>';
        }
        $html .= '<td style="text-align: right"><input type="text" disabled class="form-control line-qty-cal" name="line_qty_cal[]" style="text-align: right" value="' . number_format($line_total_qty) . '"></td>';
        $html .= '<td style="text-align: right"><input type="text" disabled class="form-control line-total-price" style="text-align: right"  value="' . number_format($line_total_price) . '"><input type="hidden" class="form-control line-total-price-cal" style="text-align: right" value="' . $line_total_price . '"></td>';
        $html .= '<td style="text-align: center"><div class="btn btn-danger btn-sm" data-var="' . $value->customer_id . '" onclick="removeorderline($(this))">แก้ไข</div></td>';
        return $html;
    }


    public function actionEmpdata()
    {
        $company_id = 1;
        $branch_id = 1;
        if (isset($_SESSION['user_company_id'])) {
            $company_id = $_SESSION['user_company_id'];
        }
        if (isset($_SESSION['user_branch_id'])) {
            $branch_id = $_SESSION['user_branch_id'];
        }

        $txt = \Yii::$app->request->post('txt_search');
        $html = '';
        $model = null;
        if ($txt != '') {
            $model = Employee::find()->where(['OR', ['LIKE', 'code', $txt], ['LIKE', 'fname', $txt], ['LIKE', 'lname', $txt]])->andFilterWhere(['company_id' => $company_id, 'branch_id' => $branch_id])->all();
        } else {
            $model = Employee::find()->where(['company_id' => $company_id, 'branch_id' => $branch_id])->all();
        }
        foreach ($model as $value) {
            $html .= '<tr>';
            $html .= '<td style="text-align: center">
                        <div class="btn btn-outline-success btn-sm" onclick="addselecteditem($(this))" data-var="' . $value->id . '">เลือก</div>
                        <input type="hidden" class="line-find-emp-code" value="' . $value->code . '">
                        <input type="hidden" class="line-find-emp-name" value="' . $value->fname . ' ' . $value->lname . '">
                       </td>';
            $html .= '<td>' . $value->code . '</td>';
            $html .= '<td>' . $value->fname . ' ' . $value->lname . '</td>';
            $html .= '</tr>';
        }
        echo $html;
    }

    public function actionFindempdata()
    {
        $company_id = 1;
        $branch_id = 1;
        if (isset($_SESSION['user_company_id'])) {
            $company_id = $_SESSION['user_company_id'];
        }
        if (isset($_SESSION['user_branch_id'])) {
            $branch_id = $_SESSION['user_branch_id'];
        }

        $id = \Yii::$app->request->post('car_id');
        $trans_date = \Yii::$app->request->post('trans_date');

        $html = '';
        $model = null;
        $t_date = null;
        if ($id) {
            $x_date = explode('/', $trans_date);
            $t_date = date('Y-m-d');
            if (count($x_date) > 1) {
                $t_date = $x_date[2] . '/' . $x_date[1] . '/' . $x_date[0];
            }
            $t_date = date('Y-m-d', strtotime($t_date));

            $model = Cardaily::find()->where(['car_id' => $id, 'trans_date' => $t_date])->andFilterWhere(['company_id' => $company_id, 'branch_id' => $branch_id])->all();
            $i = 0;
            if ($model) {
                foreach ($model as $value) {
                    $i += 1;
                    $selected = '';
                    if ($value->is_driver == 1) {
                        $selected = 'selected';
                    } else {
                        $selected = '';
                    }
                    $selected2 = '';
                    if ($value->is_driver == 0) {
                        $selected2 = 'selected';
                    } else {
                        $selected2 = '';
                    }
                    $emp_code = Employee::findCode($value->employee_id);
                    $emp_fullname = Employee::findFullName($value->employee_id);
                    $html .= '<tr>';
                    $html .= '<td style="text-align: center">' . $i . '</td>';
                    $html .= '<td><input type="text" class="form-control line-car-emp-code" name="line_car_emp_code[]" value="' . $emp_code . '" readonly></td>';
                    $html .= '<td><input type="text" class="form-control line-car-emp-name" name="line_car_emp_name[]" value="' . $emp_fullname . '" readonly></td>';
                    $html .= ' <td>
                                        <select name="line_car_driver[]" class="form-control line-car-driver" id="">
                                            <option value="1" ' . $selected . '>YES</option>
                                            <option value="0" ' . $selected2 . '>NO</option>
                                        </select>
                                    </td>';
                    $html .= '<td>
                               <input type="hidden" class="line-car-emp-id" value="' . $value->employee_id . '" name="line_car_emp_id[]">
                               <input type="hidden" class="line-car-daily-id" value="' . $value->id . '" name="line_car_daily_id[]">
                               <div class="btn btn-danger btn-sm" onclick="removeline($(this))"><i class="fa fa-trash"></i></div>
                          </td>';
                    $html .= '</tr>';


                }
            } else {
                $html .= '
                    <tr>
                                       <td style="text-align: center"></td>
                                       <td>
                                           <input type="text" class="form-control line-car-emp-code" name="line_car_emp_code[]" value="" readonly>
                                       </td>
                                       <td>
                                           <input type="text" class="form-control line-car-emp-name" name="line_car_emp_name[]" value="" readonly>
                                       </td>
                                         <td>
                                        <select name="line_car_driver[]" class="form-control line-car-driver" id="">
                                            <option value="1">YES</option>
                                            <option value="0">NO</option>
                                        </select>
                                    </td>
                                       <td>
                                           <input type="hidden" class="line-car-emp-id" value="" name="line_car_emp_id[]">
                                           <input type="hidden" class="line-car-daily-id" value="" name="line_car_daily_id[]">
                                           <div class="btn btn-danger btn-sm" onclick="removeline($(this))"><i class="fa fa-trash"></i></div>
                                       </td>
                                   </tr>
                ';
            }

        }

        echo $html;
    }

    public function actionFindcarempdaily()
    {
        $id = \Yii::$app->request->post('id');
        $trans_date = \Yii::$app->request->post('order_date');

        $data = [];
        // $emp_count = 0;
        $html = '';
        if ($id) {
            $x_date = explode('/', $trans_date);
            $t_date = date('Y-m-d');
            if (count($x_date) > 1) {
                $t_date = $x_date[2] . '/' . $x_date[1] . '/' . $x_date[0];
            }
            $t_date = date('Y-m-d', strtotime($t_date));

            $model = Cardaily::find()->where(['car_id' => $id, 'date(trans_date)' => $t_date])->all();
            $i = 0;
            foreach ($model as $value) {
                $i += 1;
                //$emp_count += 1;
                $emp_code = Employee::findCode($value->employee_id);
                $emp_fullname = Employee::findFullName($value->employee_id);

                $html .= $emp_fullname . ' , ';

            }
        }
        echo $html;
        //  array_push($data, ['emp_count' => $emp_count, 'html' => $html]);
        // return json_encode($data);

    }

    public function actionDeletecaremp()
    {
        $id = \Yii::$app->request->post('id');
        $res = 0;
        if ($id) {
            if (Cardaily::deleteAll(['id' => $id])) {
                $res += 1;
            }
        }
        echo $res;
    }

    public function actionFindPaymentList()
    {
        $company_id = 1;
        $branch_id = 1;
        if (isset($_SESSION['user_company_id'])) {
            $company_id = $_SESSION['user_company_id'];
        }
        if (isset($_SESSION['user_branch_id'])) {
            $branch_id = $_SESSION['user_branch_id'];
        }

        $order_id = \Yii::$app->request->post('id');
        $price_group_id = \Yii::$app->request->post('price_group_id');
        $customer_paylist_id = \Yii::$app->request->post('order_id');
        $html = '';
        if (count($customer_paylist_id) > 0 && $order_id > 0) {
            for ($i = 0; $i <= count($customer_paylist_id) - 1; $i++) {
                //   $model = \common\models\QuerySaleTransData::find()->select(['order_id','customer_id', 'cus_name', 'SUM(qty) as qty', 'SUM(price) as price'])->where(['order_id' => $order_id, 'price_group_id' => $price_group_id, 'customer_id' => $customer_paylist_id[$i]])->andFilterWhere(['>', 'qty', 0])->groupBy('order_id','customer_id', 'price_group_id')->all();
                $model = \common\models\QuerySaleTransData::find()->select(['order_id', 'customer_id', 'cus_name', 'SUM(qty) as qty', 'SUM(line_total_amt) as line_total_amt'])->where(['order_id' => $order_id, 'price_group_id' => $price_group_id, 'customer_id' => $customer_paylist_id[$i]])->andFilterWhere(['>', 'qty', 0])->groupBy('order_id', 'customer_id', 'price_group_id')->all();
                if ($model != null) {
                    foreach ($model as $value) {
                        //$line_total_price = $value->qty * $value->price;
                        $line_total_price = $value->line_total_amt;
                        if ($line_total_price <= 0 && $value->qty <= 0) continue;
                        $customer_pay_amount = $this->checkpaymentsum($order_id, $value->customer_id);
                        $line_remain_pay = $line_total_price - $customer_pay_amount;
                        $customer_success_pay = '';
                        if ($line_remain_pay == 0) {
                            $customer_success_pay = 'readonly';
                        }
                        $cust_pay_type = $this->getCuspaymenttype($value->customer_id);
                        $show_order_pay = 0;

                        $xx = substr($cust_pay_type, 3, 2);

                        if ($xx == 'สด') {
                            $show_order_pay = $line_remain_pay;
                        }
                        $html .= '<tr>
                                <td>' . \backend\models\Customer::findCode($value->customer_id) . '<input type="hidden" class="line-customer-id" name="line_pay_customer_id[]" value="' . $value->customer_id . '"> </td>
                                <td>' . $value->cus_name . '</td>
                                <td style="width: 10%">
                                    <input type="text" class="form-control" readonly value="' . number_format($line_total_price) . '">
                                </td>
                                <td>
                                    <select name="line_payment_id[]" class="form-control" id="" onchange="getCondition($(this))" required>
                                        <option value="">--วิธีชำระเงิน--</option>
                                        ' . $this->showpayoption($value->customer_id, $company_id, $branch_id) . '
                                    </select>
                                </td>
                                <td>
                                    <select name="line_payment_term_id[]" class="form-control select-condition" id="" required>
                                        <option value="0" selected>--เงื่อนไข--</option>
                                         ' . $this->showconoption($value->customer_id) . '
                                    </select>
                                </td>
                                <td style="width: 10%">
                                    <input type="text" class="form-control" name="line_pay_amount[]" value="' . $show_order_pay . '" ' . $customer_success_pay . '>
                                </td>
                                <td style="width: 10%">
                                    <input type="text" class="form-control" readonly value="' . number_format($line_remain_pay) . '">
                                </td>
                              
                            </tr>';
                    }
                }
            }
        }
        return $html;
    }

    public function getCuspaymenttype($customer_id)
    {
        $name = '';
        if ($customer_id > 0) {
            $model = \backend\models\Customer::find()->where(['id' => $customer_id])->one();
            if ($model) {
                $name = $model->findPayMethod($model->payment_method_id);
            }
        }
        return $name;
    }

    public function showpayoption($customer_id, $company_id, $branch_id)
    {
        $model_cus = \backend\models\Customer::findPayMethod($customer_id);
        $html = '';
        $model = \backend\models\Paymentmethod::find()->where(['company_id' => $company_id, 'branch_id' => $branch_id])->all();
        if ($model) {
            foreach ($model as $value) {
                $selected = '';
                if ($value->id == $model_cus) {
                    $selected = 'selected';
                }

                $html .= '<option value="' . $value->id . '" ' . $selected . '>' . $value->name . '</option>';
            }

        }
        return $html;
    }

    public function showconoption($customer_id)
    {
        $method_id = \backend\models\Customer::findPayMethod($customer_id);
        $model_cus = \backend\models\Customer::findPayTerm($customer_id);
        $html = '';
        $model = \backend\models\Paymentterm::find()->where(['payment_method_id' => $method_id])->all();
        if ($model) {
            foreach ($model as $value) {
                $selected = '';
                if ($value->id == $model_cus) {
                    $selected = 'selected';
                }

                $html .= '<option value="' . $value->id . '" ' . $selected . '>' . $value->name . '</option>';
            }

        }
        return $html;
    }

    public function showpaycontidtion($pay_method_id)
    {
        $html = '';
        if ($pay_method_id) {
            $model = \backend\models\Paymentterm::find()->where(['payment_method_id' => $pay_method_id])->all();
            if ($model) {
                foreach ($model as $value) {
                    $html .= '<option value="' . $value->id . '">' . $value->name . '</option>';
                }
            }
        }

        return $html;
    }

    public function actionGetpaycondition()
    {
        $id = \Yii::$app->request->post('id');
        $html = '';
        if ($id) {
            $model = \backend\models\Paymentterm::find()->where(['payment_method_id' => $id])->all();
            if ($model) {
                foreach ($model as $value) {
                    $html .= '<option value="' . $value->id . '">' . $value->name . '</option>';
                }
            } else {
                $html .= '<option value="0">--</option>';
            }
        }

        return $html;
    }

    public function checkpaymentsum($order_id, $customer_id)
    {
        $total_pay = 0;
        if ($order_id) {
//            $model = \backend\models\Paymenttrans::find()->where(['order_id' => $order_id])->all();
//            if ($model) {
//                foreach ($model as $value) {
            $model_line = \backend\models\Paymenttransline::find()->where(['customer_id' => $customer_id, 'order_ref_id' => $order_id])->sum('payment_amount');
            if ($model_line > 0) {
                $total_pay = $model_line;
            }
//                }
//            }
        }
        return $total_pay;
    }

    public function actionAddpayment()
    {

        $company_id = 1;
        $branch_id = 1;
        if (isset($_SESSION['user_company_id'])) {
            $company_id = $_SESSION['user_company_id'];
        }
        if (isset($_SESSION['user_branch_id'])) {
            $branch_id = $_SESSION['user_branch_id'];
        }

        $order_id = \Yii::$app->request->post('payment_order_id');
        $customer_id = \Yii::$app->request->post('line_pay_customer_id');
        $pay_method = \Yii::$app->request->post('line_payment_id');
        $pay_term = \Yii::$app->request->post('line_payment_term_id');
        $pay_amount = \Yii::$app->request->post('line_pay_amount');
        $pay_date = \Yii::$app->request->post('payment_date');

        $order_pay_date = date('Y-m-d H:i:s');
        $x_date = explode('/', $pay_date);
        if (count($x_date) > 1) {
            $order_pay_date = $x_date[2] . '/' . $x_date[1] . '/' . $x_date[0] . ' ' . date('H:i:s');
        }

        // echo date('Y-m-d H:i:s',strtotime($order_pay_date));return;
        //    print_r(Yii::$app->request->post());
//        echo '<br />';
        //  print_r($pay_term);
//
        //   return false;

        $res = 0;
        if ($order_id > 0 && $customer_id != null) {
            $model = new \backend\models\Paymenttrans();
            $model->trans_no = $model->getLastNo($company_id, $branch_id);
            $model->trans_date = date('Y-m-d H:i:s', strtotime($order_pay_date));
            $model->order_id = $order_id;
            $model->status = 0;
            $model->company_id = $company_id;
            $model->branch_id = $branch_id;
            if ($model->save(false)) {
                if (count($customer_id) > 0) {
                    for ($i = 0; $i <= count($customer_id) - 1; $i++) {
                        if ($customer_id[$i] == '' || $customer_id[$i] == null) continue;
                        //$pay_method_name = \backend\models\Paymentmethod::findName($pay_method[$i]);
                        //  if ($pay_method_name == 'เงินสด' && ($pay_amount[$i] == null || $pay_amount[$i] == 0)) continue;
                        //if ($pay_method_name == 'เงินสด' && ($pay_amount[$i] == null || $pay_amount[$i] == 0)) continue;
                        $model_line = new \backend\models\Paymenttransline();
                        $model_line->trans_id = $model->id;
                        $model_line->customer_id = $customer_id[$i];
                        $model_line->payment_method_id = $pay_method[$i];
                        $model_line->payment_term_id = $pay_term[$i] == null ? 0 : $pay_term[$i];
                        $model_line->payment_date = date('Y-m-d H:i:s', strtotime($order_pay_date));
                        $model_line->payment_amount = $pay_amount[$i];
                        $model_line->total_amount = 0;
                        $model_line->order_ref_id = $order_id;
                        $model_line->status = 1;
                        $model_line->doc = '';
                        if ($model_line->save(false)) {
                            $res += 1;
                        }
                    }
                }
            } else {
                echo 'error2';
                return;
            }
        } else {
            echo "erorr";
            return false;
        }
        return $this->redirect(['orders/update', 'id' => $order_id]);

    }

    public function actionGetpaytrans()
    {
        $order_id = \Yii::$app->request->post('order_id');
        $customer_id = \Yii::$app->request->post('customer_id');
        $customer_name = '';
        $data = [];
        $html = '';
        if ($order_id > 0 && $customer_id > 0) {
            $customer_name = \backend\models\Customer::findName($customer_id);
            $model = \backend\models\Paymenttransline::find()->where(['order_ref_id' => $order_id, 'customer_id' => $customer_id])->all();
            if ($model) {
                foreach ($model as $value) {
                    $html .= '<tr>';
                    $html .= '<td style="text-align: center">' . date('d/m/Y', strtotime($value->payment_date)) . '</td>';
                    $html .= '<td style="text-align: center">' . \backend\models\Paymentmethod::findName($value->payment_method_id) . '</td>';
                    $html .= '<td style="text-align: center">' . \backend\models\Paymentterm::findName($value->payment_term_id) . '</td>';
                    $html .= '<td style="text-align: center"><input type="text" class="form-control" name="line_trans_amt[]" value="' . number_format($value->payment_amount) . '"> </td>';
                    $html .= '<td style="text-align: center">
                                <div class="btn btn-danger btn-sm" data-id="' . $value->id . '" onclick="removepayline($(this))">ลบ</div>
                                <input type="hidden" name="line_trans_id[]" value="' . $value->id . '">
                            </td>';
                    $html .= '</tr>';
                }
            }
        }
        array_push($data, ['customer_name' => $customer_name, 'data' => $html]);
        return json_encode($data);
    }

    public function actionUpdatepayment()
    {
        $order_id = \Yii::$app->request->post('payment_order_id');
        $id = \Yii::$app->request->post('line_trans_id');
        $amt = \Yii::$app->request->post('line_trans_amt');
        $removelist = \Yii::$app->request->post('payment_remove_list');
        if ($id != null) {
            for ($i = 0; $i <= count($id) - 1; $i++) {
                $model = \backend\models\Paymenttransline::find()->where(['id' => $id[$i]])->one();
                if ($model) {
                    $model->payment_amount = $amt[$i];
                    $model->save(false);
                }
            }
        }
        if ($removelist != null) {
            $x_ = explode(",", $removelist);
            for ($i = 0; $i <= count($x_) - 1; $i++) {
                \backend\models\Paymenttransline::deleteAll(['id' => $x_[$i]]);
            }
        }

        return $this->redirect(['orders/update', 'id' => $order_id]);
    }

    public function actionGetproductinorder()
    {
        $order_id = \Yii::$app->request->post('order_id');
        if ($order_id) {

        }
    }

    public function actionFindIssueDetail()
    {
        $id = \Yii::$app->request->post('issue_id');
        $html = '';
        $model = null;
        if ($id) {
            $model = \backend\models\Journalissueline::find()->where(['issue_id' => $id])->all();
            foreach ($model as $value) {
                $html .= '<tr>';
                $html .= '<td style="text-align: center">' . \backend\models\Product::findCode($value->product_id) . '</td>';
                $html .= '<td style="text-align: center">' . \backend\models\Product::findName($value->product_id) . '</td>';
                $html .= '<td style="text-align: center">' . number_format($value->sale_price) . '</td>';
                $html .= '<td>
                                <input type="text" class="line-issue-qty form-control" name="line_issue_qty[]" readonly value="' . $value->qty . '">
                                <input type="hidden" class="line-issue-product-id" name="line_issue_product_id[]" value="' . $value->product_id . '">
                          </td>';
//                $html .= '<td>
//                            <select name="line_route_id[]" class="form-control select-line-route-id">
//                                        <option value="0" selected>--สายส่งปลายทาง--</option>
//                                         ' . $this->showrouteoption() . '
//                                    </select>
//                          </td>';
                $html .= '<td><input type="number" class="line-trans-qty form-control" name="line_trans_qty[]" min="0" value="0" onchange="issueqtychange($(this))"></td>';
                $html .= '</tr>';
            }
        }
        echo $html;
    }

    public function showrouteoption()
    {
        $model_route = \backend\models\Deliveryroute::find()->all();
        $html = '';
        if ($model_route) {
            foreach ($model_route as $value) {
//                $selected = '';
//                if ($value->id == $model_cus) {
//                    $selected = 'selected';
//                }
                $html .= '<option value="' . $value->id . '" >' . $value->name . '</option>';
            }
        }
        return $html;
    }

    public function actionAddtransfer()
    {
        $order_id = \Yii::$app->request->post('transfer_order_id');
        $order_target_id = \Yii::$app->request->post('order_target');
        $line_prod = \Yii::$app->request->post('line_issue_product_id');
        $line_qty = \Yii::$app->request->post('line_trans_qty');

        if ($order_id && $order_target_id) {
            if ($line_prod != null) {
                $trans_date = date('d/m/Y');
                $model = new \backend\models\Journaltransfer();
                $model->journal_no = $model->getLastNo($trans_date);
                $model->trans_date = date('Y-m-d');
                $model->order_ref_id = $order_id;
                $model->order_target_id = $order_target_id;
                $model->status = 1;
                if ($model->save(false)) {
                    if (count($line_prod) > 0) {
                        for ($i = 0; $i <= count($line_prod) - 1; $i++) {
                            if ($line_qty[$i] <= 0) continue;
                            $model_line = new \backend\models\Transferline();
                            $model_line->transfer_id = $model->id;
                            $model_line->product_id = $line_prod[$i];
                            $model_line->sale_price = 0;
                            $model_line->qty = $line_qty[$i];
                            $model_line->status = 1;
                            $model_line->save();
                        }
                    }
                }
            }
        }
        return $this->redirect(['orders/update', 'id' => $order_id]);
    }

    public function actionGettransferSaleItem()
    {
        $order_id = \Yii::$app->request->post('order_id');
        $html = '';
        if ($order_id) {
            $model = \backend\models\Journaltransfer::find()->where(['order_target_id' => $order_id, 'status' => 1])->one();
            if ($model) {
                $model_line = \backend\models\Transferline::find()->where(['transfer_id' => $model->id])->all();
                foreach ($model_line as $value) {
                    $a_qty = $value->qty;
                    $s_qty = $this->checkTransferOnhand($model->id, $value->product_id);
                    $a_qty = $a_qty - $s_qty;

                    $html .= '<tr>';
                    $html .= '<td>
                           <input type="hidden" class="line-transfer-order-id" name="line_transfer_order_id[]" value="' . $model->id . '">
                           <input type="hidden" class="line-transfer-sale-line-id" name="line_transfer_sale_line_id[]" value="' . $value->id . '">
                           ' . \backend\models\Product::findCode($value->product_id) . '
                            <input type="hidden" class="line-transfer-sale-product-id" name="line_transfer_sale_product_id[]" value="' . $value->id . '">
                    </td>';
                    $html .= '<td><input type="text" class="form-control line-transfer-issue-qty" name="line_transfer_issue_qty[]" value="' . number_format($a_qty) . '" readonly></td>';
                    $html .= '<td><select class="form-control select-transfer-sale-customer-id" name="transfer_sale_customer_id[]">
                            <option value="0">--เลือกลูกค้า--</option>
                            ' . $this->getCustomerOption($order_id) . '
                     </select></td>';
                    $html .= '<td><input type="number" class="form-control line-transfer-sale-qty" name="line_transfer_sale_qty[]" value="0" min="0" onchange="transfersaleqtychange($(this))"></td>';
                    $html .= '</tr>';
                }
            }
        }

        return $html;
    }

    public function getCustomerOption($order_id)
    {
        $html = '';
        if ($order_id > 0) {
            $model = \common\models\QueryCustomerInOrder::find()->where(['order_id' => $order_id])->all();
            if ($model) {
                foreach ($model as $value) {
                    $html .= '<option value="' . $value->customer_id . '">' . \backend\models\Customer::findName($value->customer_id) . '</option>';
                }
            }
        }

        return $html;
    }

    public function checkTransferOnhand($tranfer_id, $product_id)
    {
        $sale_qty = 0;
        if ($tranfer_id && $product_id) {
            $model = \common\models\OrderTransferSale::find()->where(['transfer_id' => $tranfer_id, 'product_id' => $product_id])->sum('qty');
            if ($model != null) {
                $sale_qty = $model;
            }
        }
        return $sale_qty;
    }

    public function actionSavetransfersale()
    {
        $order_id = \Yii::$app->request->post('order_id');
        $transfer_id = \Yii::$app->request->post('line_transfer_order_id');
        $customer_list = \Yii::$app->request->post('transfer_sale_customer_id');
        $product_list = \Yii::$app->request->post('line_transfer_sale_product_id');
        $line_qty = \Yii::$app->request->post('line_transfer_sale_qty');

        $res = 0;

        if ($order_id) {
            if ($product_list != null) {
                for ($i = 0; $i <= count($product_list) - 1; $i++) {
                    if ($line_qty[$i] == 0 || $line_qty[$i] == null) continue;
                    $model = new \common\models\OrderTransferSale();
                    $model->order_id = $order_id;
                    $model->transfer_id = $transfer_id[$i];
                    $model->customer_id = $customer_list[$i];
                    $model->product_id = $product_list[$i];
                    $model->qty = $line_qty[$i];
                    if ($model->save()) {
                        $res += 1;
                    }
                }
            }
        }
        if ($res) {
            return $this->redirect(['orders/update', 'id' => $order_id]);
        }
    }

    public function actionRegisterissue()
    {

        $order_id = \Yii::$app->request->post('order_id');
        $issuelist = \Yii::$app->request->post('issue_list');

        if ($order_id != null && $issuelist != null) {
            //  $issue_data = explode(',', $issuelist);
//            print_r($issuelist[0]);
            if ($issuelist != null) {
                for ($i = 0; $i <= count($issuelist) - 1; $i++) {
                    $model_check_has_issue = \common\models\OrderStock::find()->where(['order_id' => $order_id, 'issue_id' => $issuelist[$i]])->count();
                    if ($model_check_has_issue) continue;
                    $model_issue_line = \backend\models\Journalissueline::find()->where(['issue_id' => $issuelist[$i]])->all();
                    foreach ($model_issue_line as $val2) {
                        if ($val2->qty <= 0 || $val2->qty != null) continue;
                        $model_order_stock = new \common\models\OrderStock();
                        $model_order_stock->issue_id = $issuelist[$i];
                        $model_order_stock->product_id = $val2->product_id;
                        $model_order_stock->qty = $val2->qty;
                        $model_order_stock->used_qty = 0;
                        $model_order_stock->avl_qty = $val2->qty;
                        $model_order_stock->order_id = $order_id;
                        if ($model_order_stock->save(false)) {
                            $model_update_issue_status = \common\models\JournalIssue::find()->where(['id' => $issuelist[$i]])->one();
                            if ($model_update_issue_status) {
                                $model_check_has_issue->status = 2;
                                $model_check_has_issue->save(false);
                            }
                            $this->updateStock($val2->product_id, $val2->qty, 6, '');
                        }
                    }
                }
            }
        }
    }

    public function updateStock($product_id, $qty, $wh_id, $journal_no)
    {
        if ($product_id != null && $qty > 0) {
            $model_trans = new \backend\models\Stocktrans();
            $model_trans->journal_no = $journal_no;
            $model_trans->trans_date = date('Y-m-d H:i:s');
            $model_trans->product_id = $product_id;
            $model_trans->qty = $qty;
            $model_trans->warehouse_id = 6;
            $model_trans->stock_type = 2; // 1 in 2 out
            $model_trans->activity_type_id = 6; // 6 issue car
            if ($model_trans->save(false)) {
                $model = \backend\models\Stocksum::find()->where(['warehouse_id' => 6, 'product_id' => $product_id])->one();
                if ($model) {
                    $model->qty = $model->qty - (int)$qty;
                    $model->save(false);
                }
            }
        }
    }
}
