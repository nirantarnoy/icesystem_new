<?php

namespace backend\controllers;

use backend\models\JournalissueSearch;
use backend\models\Orderline;
use backend\models\Orders;
use backend\models\OrdersposSearch;
use backend\models\WarehouseSearch;
use Yii;
use backend\models\Car;
use backend\models\CarSearch;
use yii\filters\AccessControl;
use yii\helpers\ArrayHelper;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use kartik\mpdf\Pdf;
use yii\web\Session;

/**
 * CarController implements the CRUD actions for Car model.
 */
class PosController extends Controller
{
    public $enableCsrfValidation = false;

    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['login', 'error'],
                        'allow' => true,
                    ],
                    [
                        'actions' => [
                            'logout', 'index', 'print', 'printindex', 'dailysum', 'getcustomerprice', 'getoriginprice', 'closesale',
                            'salehistory', 'getbasicprice', 'delete', 'orderedit', 'posupdate', 'posttrans','saledailyend'
                        ],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
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
//        if (file_exists('../web/uploads/slip/slip_index.pdf')) {
//            unlink('../web/uploads/slip/slip_index.pdf');
//        }
        $this->layout = 'main_pos';
        return $this->render('index', [
            'model' => null
        ]);
    }

    public function actionGetcustomerprice()
    {
        $data = [];
        $data_cus_price = [];
        $data_basic_price = [];
        $customer_id = \Yii::$app->request->post('customer_id');
        if ($customer_id) {
            $model = \common\models\QueryCustomerPrice::find()->where(['cus_id' => $customer_id])->all();
            if ($model != null) {
                foreach ($model as $value) {
                    array_push($data_cus_price, ['product_id' => $value->product_id, 'sale_price' => $value->sale_price, 'price_name' => $value->name]);
                }
            }
        }
        $model_basic_price = \backend\models\Product::find()->all();
        if ($model_basic_price) {
            foreach ($model_basic_price as $value2) {
                array_push($data_basic_price, ['product_id' => $value2->id, 'sale_price' => $value2->sale_price]);
            }
        }
        array_push($data, $data_cus_price, $data_basic_price);
        return json_encode($data);
    }

    public function actionGetoriginprice()
    {
        $data = [];
        $model_basic_price = \backend\models\Product::find()->where(['is_pos_item' => 1])->all();
        if ($model_basic_price) {
            foreach ($model_basic_price as $value) {
                array_push($data, ['product_id' => $value->id, 'sale_price' => $value->sale_price]);
            }
        }
        return json_encode($data);
    }

    public function actionGetbasicprice()
    {
        $customer_id = \Yii::$app->request->post('customer_id');
        $id = \Yii::$app->request->post('product_id');
        $data = [];
        $basic_price = 0;
        $sale_price = null;
        if ($id > 0 && $customer_id > 0) {
            $model_sale_price = \common\models\QueryCustomerPrice::find()->where(['cus_id' => $customer_id, 'product_id' => $id])->one();
            if ($model_sale_price) {
                $sale_price = $model_sale_price->sale_price;
            } else {
                $model = \backend\models\Product::find()->where(['id' => $id])->one();
                if ($model) {
                    $basic_price = $model->sale_price;
                }
            }
            array_push($data, ['sale_price' => $sale_price, 'basic_price' => $basic_price]);
        }
        //array_push($data, ['sale_price' => $sale_price, 'basic_price' => $basic_price]);

        return json_encode($data);
    }

    public function actionClosesale()
    {
        $pay_total_amount = \Yii::$app->request->post('sale_total_amount');
        $pay_amount = \Yii::$app->request->post('sale_pay_amount');
        $pay_change = \Yii::$app->request->post('sale_pay_change');
        $payment_type = \Yii::$app->request->post('sale_pay_type');

        $customer_id = \Yii::$app->request->post('customer_id');
        $product_list = \Yii::$app->request->post('cart_product_id');
        $line_qty = \Yii::$app->request->post('cart_qty');
        $line_price = \Yii::$app->request->post('cart_price');

        $print_type_doc = \Yii::$app->request->post('print_type_doc');

        $pos_date = \Yii::$app->request->post('sale_pay_date');

        //echo $customer_id;return;
        $sale_date = date('Y-m-d');
        $sale_time = date('H:i:s');
        $x_date = explode('/', $pos_date);
        if (count($x_date) > 1) {
            $sale_date = $x_date[2] . '/' . $x_date[1] . '/' . $x_date[0];
        }
        if ($customer_id) {
            $model_order = new \backend\models\Orders();
            $model_order->order_no = $model_order->getLastNo($sale_date);
            $model_order->order_date = date('Y-m-d H:i:s', strtotime($sale_date . ' ' . $sale_time));
            $model_order->customer_id = $customer_id;
            $model_order->sale_channel_id = 2; // pos
            $model_order->payment_status = 0;
            $model_order->order_total_amt = $pay_total_amount == null ? 0 : $pay_total_amount;
            $model_order->status = 1;
            if ($model_order->save(false)) {
                if (count($product_list) > 0) {
                    for ($i = 0; $i <= count($product_list) - 1; $i++) {
                        $model_order_line = new \backend\models\Orderline();
                        $model_order_line->order_id = $model_order->id;
                        $model_order_line->product_id = $product_list[$i];
                        $model_order_line->qty = $line_qty[$i];
                        $model_order_line->price = $line_price[$i];
                        $model_order_line->customer_id = $customer_id;
                        $model_order_line->price_group_id = 0;
                        $model_order_line->line_total = ($line_price[$i] * $line_qty[$i]);
                        $model_order_line->status = 1;
                        if($model_order_line->save(false)){

                            $model_stock = new \backend\models\Stocktrans();
                            $model_stock->journal_no = '';
                            $model_stock->trans_date = date('Y-m-d H:i:s');
                            $model_stock->product_id = $product_list[$i];
                            $model_stock->qty = $line_qty[$i];
                            $model_stock->warehouse_id = 6;
                            $model_stock->stock_type = 2;
                            $model_stock->activity_type_id = 5; // 1 prod rec 2 issue car
                            if($model_stock->save()){
                                $this->updateSummary($product_list[$i],6,$line_qty[$i]);
                            }
                        }
                    }
                }

                if ($pay_total_amount > 0 && $pay_amount > 0) {
//                      $model_pay = new \common\models\JournalPayment();
//                      $model_pay->journal_no = 'AX';
//                      $model_pay->order_id = $model_order->id;
//                      $model_pay->trans_date = date('Y-m-d');
//                      $model_pay->payment_method_id = $payment_type;
//                      $model_pay->total_amount = $pay_total_amount;
//                      $model_pay->pay_amount = $pay_amount;
//                      $model_pay->change_amount = $pay_change;
//                      $model_pay->save(false);


                    $model = new \backend\models\Paymenttrans();
                    $model->trans_no = $model->getLastNo();
                    $model->trans_date = date('Y-m-d H:i:s');
                    $model->order_id = $model_order->id;
                    $model->status = 0;
                    if ($model->save()) {
                        if ($customer_id > 0) {
                            //$pay_method_name = \backend\models\Paymentmethod::findName($pay_method[$i]);
                            $model_line = new \backend\models\Paymenttransline();
                            $model_line->trans_id = $model->id;
                            $model_line->customer_id = $customer_id;
                            $model_line->payment_method_id = $payment_type;
                            //   $model_line->payment_term_id = $pay_term[$i] == null ? 0 : $pay_term[$i];
                            $model_line->payment_date = date('Y-m-d H:i:s');
                            $model_line->payment_amount = $pay_amount == null?0:$pay_amount;
                            $model_line->total_amount = $pay_total_amount;
                            $model_line->change_amount = $pay_change;
                            $model_line->order_ref_id = $model_order->id;
                            $model_line->status = 1;
                            $model_line->doc = '';
                            if ($model_line->save(false)) {
                                //$res += 1;
                            }
                        }
                    }
                    $this->updateorderpayment($model_order->id, $pay_total_amount, $pay_amount);
                }else{
                    $model = new \backend\models\Paymenttrans();
                    $model->trans_no = $model->getLastNo();
                    $model->trans_date = date('Y-m-d H:i:s');
                    $model->order_id = $model_order->id;
                    $model->status = 0;
                    if ($model->save()) {
                        if ($customer_id > 0) {
                            //$pay_method_name = \backend\models\Paymentmethod::findName($pay_method[$i]);
                            $model_line = new \backend\models\Paymenttransline();
                            $model_line->trans_id = $model->id;
                            $model_line->customer_id = $customer_id;
                            $model_line->payment_method_id = $payment_type;
                            //   $model_line->payment_term_id = $pay_term[$i] == null ? 0 : $pay_term[$i];
                            $model_line->payment_date = date('Y-m-d H:i:s');
                            $model_line->payment_amount = $pay_amount;
                            $model_line->total_amount = $pay_total_amount;
                            $model_line->change_amount = $pay_change;
                            $model_line->order_ref_id = $model_order->id;
                            $model_line->status = 1;
                            $model_line->doc = '';
                            if ($model_line->save(false)) {
                                //$res += 1;
                            }
                        }
                    }
                   // $this->updateorderpayment($model_order->id, $pay_total_amount, $pay_amount);
                }

                //  if($this->printindex(31)){
                if ($model_order->id != null) {
                    $model = \backend\models\Orders::find()->where(['id' => $model_order->id])->one();
                    $model_line = \backend\models\Orderline::find()->where(['order_id' => $model_order->id])->all();
                    $change_amt = \backend\models\Paymenttransline::find()->where(['order_ref_id' => $model_order->id])->one();
                    $ch_amt = 0;
                    if ($change_amt != null) {
                        $ch_amt = $change_amt->change_amount;
                    }
                    $this->render('_printtoindex', ['model' => $model, 'model_line' => $model_line, 'change_amount' => $ch_amt,$print_type_doc]);
                    if($print_type_doc == 2){
                        if(file_exists('../web/uploads/slip/slip_index_do.pdf')){
                            unlink('../web/uploads/slip/slip_index_do.pdf');
                        }
                       $this->render('_printtoindex2', ['model' => $model, 'model_line' => $model_line, 'change_amount' => $ch_amt,$print_type_doc]);
                    }
//
                    $session = \Yii::$app->session;
                    $session->setFlash('msg-index', 'slip_index.pdf');
                    $session->setFlash('msg-index-do', 'slip_index_do.pdf');
                    $session->setFlash('after-save', true);
                    if($print_type_doc == 2){
                        $session->setFlash('msg-is-do', $print_type_doc);
                    }
                }
            }
        }
        $session = \Yii::$app->session;
        $session->setFlash('msg', 'บันทึกรายการเรียบร้อย');
        return $this->redirect(['pos/index']);
    }

    public function updateSummary($product_id, $wh_id, $qty){
        if($wh_id != null && $product_id != null && $qty > 0){
            $model = \backend\models\Stocksum::find()->where(['warehouse_id'=>$wh_id,'product_id'=>$product_id])->one();
            if($model){
                $model->qty = ($model->qty - (int)$qty);
                $model->save(false);
            }else{
                $model_new = new \backend\models\Stocksum();
                $model_new->warehouse_id = $wh_id;
                $model_new->product_id = $product_id;
                $model_new->qty = $qty;
                $model_new->save(false);
            }
        }
    }

    public function updateorderpayment($order_id, $order_amt, $pay_amt)
    {
        if ($order_id) {
            if ($pay_amt >= $order_amt) {
                $model = \backend\models\Orders::find()->where(['id' => $order_id])->one();
                if ($model) {
                    $model->payment_status = 1;
                    $model->save();
                }
            }
        }
    }

    public function actionSalehistory()
    {
        if (file_exists('../web/uploads/slip/slip.pdf')) {
            //  unlink('../web/uploads/slip/slip.pdf');
        }


        $searchModel = new OrdersposSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $dataProvider->query->andFilterWhere(['sale_channel_id' => 2]);
        $dataProvider->setSort(['defaultOrder' => ['id' => SORT_DESC]]);
        //  $dataProvider->pagination->pageSize = $pageSize;

        return $this->render('_history', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionDelete($id)
    {
        Orderline::deleteAll(['order_id' => $id]);
        $this->findModel($id)->delete();

        return $this->redirect(['pos/salehistory']);
    }

    protected function findModel($id)
    {
        if (($model = Orders::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }

    public function actionOrderedit()
    {
        $id = \Yii::$app->request->post('order_id');
        $data = [];
        $html = '';

        if ($id) {
            $model = \backend\models\Orderline::find()->where(['order_id' => $id])->all();
            if ($model) {
                foreach ($model as $value) {
                    $html .= '<tr>';
                    $html .= '<td style="text-align: center"><input type="hidden" class="order-line-id" name="order_line_id[]" value="' . $value->id . '">' . \backend\models\Product::findCode($value->product_id) . '</td>';
                    $html .= '<td>' . \backend\models\Product::findName($value->product_id) . '</td>';
                    $html .= '<td><input type="number" min="0" style="text-align: right" class="form-control line-qty" name="line_qty[]" onchange="calline($(this))" value="' . $value->qty . '"></td>';
                    $html .= '<td style="text-align: right"><input type="number" min="0" style="text-align: right" class="form-control line-price" name="line_price[]" onchange="calline($(this))" value="' . $value->price . '"></td>';
                    $html .= '<td style="text-align: right"><input type="hidden" class="line-total" value="' . $value->qty * $value->price . '">' . number_format($value->qty * $value->price) . '</td>';
                    $html .= '</tr>';
                }
            }
        }
        $model_order = \backend\models\Orders::find()->where(['id' => $id])->one();
        if ($model_order) {
            $customer_name = \backend\models\Customer::findName($model_order->customer_id);
            $payment_data = \backend\models\Paymentmethod::findName($model_order->payment_method_id);
            array_push($data, ['order_id' => $id, 'order_no' => $model_order->order_no, 'order_date' => $model_order->order_date, 'customer_name' => $customer_name, 'payment_method' => $payment_data, 'html' => $html]);
        }
        return json_encode($data);
    }

    public function actionPosupdate()
    {
        $order_id = \Yii::$app->request->post('order_id');
        $line_id = \Yii::$app->request->post('order_line_id');
        $line_qty = \Yii::$app->request->post('line_qty');
        $line_price = \Yii::$app->request->post('line_price');

        if ($order_id && $line_id != null) {
            $new_total = 0;
            for ($i = 0; $i <= count($line_id) - 1; $i++) {
                $model = \backend\models\Orderline::find()->where(['id' => $line_id[$i]])->one();
                if ($model) {
                    // echo "hol";return;
                    $new_total = $new_total + ($line_qty[$i] * $line_price[$i]);
                    $model->qty = $line_qty[$i] == null ? 0 : $line_qty[$i];
                    $model->price = $line_price[$i] == null ? 0 : $line_price[$i];
                    $model->save(false);
                }
            }
            $this->updateOrder($order_id, $new_total);
        }
        return $this->redirect(['pos/salehistory']);
    }

    public function updateOrder($id, $total)
    {
        if ($id) {
            $model = \backend\models\Orders::find()->where(['id' => $id])->one();
            if ($model) {
                $model->order_total_amt = $total;
                $model->save(false);
            }
        }
    }

    public function actionPrint($id)
    {
        if ($id) {
//            $model = \backend\models\Orders::find()->where(['id' => $id])->one();
//            $model_line = \backend\models\Orderline::find()->where(['order_id' => $id])->all();
//            $this->renderPartial('_print', ['model' => $model, 'model_line' => $model_line]);
//            //   $content =  $this->renderPartial('_print', ['model' => $model, 'model_line' => $model_line]);
//            $session = \Yii::$app->session;
//            $session->setFlash('msg-index', 'slip.pdf');
//            $session->setFlash('after-print', true);
//            $this->redirect(['pos/salehistory']);
        }

    }

    public function printindex($id)
    {
        if ($id) {
            $model = \backend\models\Orders::find()->where(['id' => $id])->one();
            $model_line = \backend\models\Orderline::find()->where(['order_id' => $id])->all();
            $change_amt = \backend\models\Paymenttransline::find()->where(['order_ref_id' => $id])->one();
            $this->render('_printtoindex', [
                'model' => $model,
                'model_line' => $model_line,
                'change_amount' => $change_amt->change_amount
            ]);
//            $session = \Yii::$app->session;
//            $session->setFlash('msg', 'slip_index.pdf');
            //$this->redirect(['pos/index']);
            return true;
        }
        return false;

    }

    public function actionDailysum()
    {
        // $x = '2021-03-03';
        // $t_date = date('Y-m-d',strtotime($x));

        $pos_date = \Yii::$app->request->post('pos_date');

        $t_date = date('Y-m-d');

        $x_date = explode('/', $pos_date);
        if (count($x_date) > 1) {
            $t_date = $x_date[2] . '-' . $x_date[1] . '-' . $x_date[0];
        }

        $searchModel = new \backend\models\SaleposdataSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $dataProvider->query->select(['code', 'name', 'price', 'SUM(qty) as qty', 'SUM(line_total) as line_total']);
        $dataProvider->query->andFilterWhere(['>', 'qty', 0]);
        $dataProvider->query->andFilterWhere(['=', 'date(order_date)', $t_date]);

        $dataProvider->query->groupBy(['code', 'name', 'price']);
        $dataProvider->setSort([
            'defaultOrder' => ['item_pos_seq' => SORT_ASC]
        ]);

        $searchModel2 = new \backend\models\SalepospaySearch();
        $dataProvider2 = $searchModel2->search(Yii::$app->request->queryParams);
        $dataProvider2->query->select(['code', 'name', 'SUM(payment_amount) as payment_amount']);
        $dataProvider2->query->andFilterWhere(['>', 'payment_amount', 0]);
        $dataProvider2->query->andFilterWhere(['date(order_date)' => $t_date]);
        $dataProvider2->query->groupBy(['code', 'name', 'sale_channel_id']);
        $dataProvider2->setSort([
            'defaultOrder' => ['code' => SORT_ASC]
        ]);
//        $searchModel2 = new \backend\models\SalepospaySearch();
//        $dataProvider2 = $searchModel2->search(Yii::$app->request->queryParams);
//        $dataProvider2->query->select(['code', 'name', 'SUM(payment_amount) as payment_amount']);
//        $dataProvider2->query->andFilterWhere(['>', 'payment_amount', 0]);
//        $dataProvider2->query->andFilterWhere(['date(payment_date)' => $t_date]);
//        $dataProvider2->query->groupBy(['code', 'name']);
//        $dataProvider2->setSort([
//            'defaultOrder' => ['code' => SORT_ASC]
//        ]);

        return $this->render('_dailysum', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'searchModel2' => $searchModel2,
            'dataProvider2' => $dataProvider2,
            'show_pos_date' => $t_date
        ]);
    }

    public function actionPosttrans(){
        $user_id = \Yii::$app->user->id;
        $user_login_time = \backend\models\User::findLogintime($user_id);
        $user_login_datetime = \backend\models\User::findLogindatetime($user_id);
        $t_date = date('Y-m-d H:i');

//        $x_date = explode('/', $pos_date);
//        if (count($x_date) > 1) {
//            $t_date = $x_date[2] . '-' . $x_date[1] . '-' . $x_date[0];
//        }
        $order_qty = 0;
        $order_amount = 0;
        $production_qty = 0;

//        $model_order = \backend\models\Orders::find()->where(['date(order_date)'=>$t_date])->all();
//        if($model_order){
//            foreach ($model_order as $value){
//                $model_sale_qty = \backend\models\Orderline::find()->where(['order_id'=>$value->id])->sum('qty');
//                $order_qty = $order_qty + $model_sale_qty;
//            }
//            foreach ($model_order as $value){
//                $model_sale_amount = \backend\models\Orderline::find()->where(['order_id'=>$value->id])->sum('line_total');
//                $order_amount = $order_amount + $model_sale_amount;
//            }
//        }

        $order_qty = \common\models\QuerySalePosData::find()->where(['created_by'=>$user_id])->andFilterWhere(['between','order_date',$user_login_datetime,$t_date])->sum('qty');
        $order_amount = \common\models\QuerySalePosData::find()->where(['created_by'=>$user_id])->andFilterWhere(['between','order_date',$user_login_datetime,$t_date])->sum('line_total');
        $order_cash_qty = \common\models\QuerySalePosData::find()->where(['created_by'=>$user_id])->andFilterWhere(['between','order_date',$user_login_datetime,$t_date])->sum('qty');
        $order_credit_qty = \common\models\QuerySalePosData::find()->where(['created_by'=>$user_id])->andFilterWhere(['between','order_date',$user_login_datetime,$t_date])->sum('qty');

        $order_cash_amount = \common\models\QuerySalePosPayDaily::find()->where(['created_by'=>$user_id])->andFilterWhere(['between','payment_date',$user_login_datetime,$t_date])->sum('payment_amount');
        $order_credit_amount = \common\models\QuerySalePosPayDaily::find()->where(['created_by'=>$user_id])->andFilterWhere(['between','payment_date',$user_login_datetime,$t_date])->sum('payment_amount');
        $production_qty = \backend\models\Stocktrans::find()->where(['activity_type_id'=>1])->andFilterWhere(['between','trans_date',$user_login_datetime,$t_date])->sum('qty');
        return $this->render('_closesale',[
            'order_qty' => $order_qty,
            'order_amount' => $order_amount,
            'order_cash_qty' => $order_cash_qty,
            'order_credit_qty' => $order_credit_qty,
            'order_cash_amount' => $order_cash_amount,
            'order_credit_amount' => $order_credit_amount,
            'production_qty' => $production_qty
        ]);
    }

    public function actionSaledailyend(){
        $user_id = \Yii::$app->user->id;
        $t_date = date('Y-m-d');

        $total_qty = \Yii::$app->request->post('order_qty');
        $total_amount = \Yii::$app->request->post('order_amount');
        $total_cash_qty = \Yii::$app->request->post('order_cash_qty');
        $total_credit_qty = \Yii::$app->request->post('order_credit_qty');
        $total_cash_amount = \Yii::$app->request->post('order_cash_amount');
        $total_credit_amount = \Yii::$app->request->post('order_credit_amount');
        $total_production_qty = \Yii::$app->request->post('total_production_qty');

        if($user_id != null){
            $model = new \common\models\SaleDailySum();
            $model->emp_id = $user_id;
            $model->trans_date = date('Y-m-d H:i:s');
            $model->total_cash_qty = 0;
            $model->total_credit_qty = 0;
            $model->total_cash_price = 0;
            $model->total_credit_price = 0;
            $model->total_prod_qty = 0;
            $model->trans_shift = 0;
            $model->balance_in = 0;
            $model->status = 1; // close and cannot edit everything
            $model->save();
        }

    }

}
