<?php

namespace frontend\modules\api\controllers;

use yii\filters\VerbFilter;
use yii\web\Controller;

date_default_timezone_set('Asia/Bangkok');

class OrderController extends Controller
{
    public $enableCsrfValidation = false;

    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'addorder' => ['POST'],
                    'addordernew' => ['POST'],
                    'addordertransfer' => ['POST'],
                    'list' => ['POST'],
                    'listnew' => ['POST'],
                    'listbycustomer' => ['POST'],
                    'deleteorder' => ['POST'],
                    'deleteorderline' => ['POST'],
                    'deleteordercustomer' => ['POST'],
                    'customercredit' => ['POST'],
                    'closeorder' => ['POST'],
                    'cancelorer' => ['POST']
                ],
            ],
        ];
    }

    public function actionAddordernew()
    {
        $customer_id = null;
        $status = false;
        $user_id = 0;
        $issue_id = 0;
        $route_id = 0;
        $car_id = 0;
        $company_id = 0;
        $branch_id = 0;
        $datalist = null;

        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $req_data = \Yii::$app->request->getBodyParams();
        if ($req_data != null) {
            $customer_id = $req_data['customer_id'];
            $user_id = $req_data['user_id'] == null ? 0 : $req_data['user_id'];
            //  $issue_id = $req_data['issue_id'];
            $route_id = $req_data['route_id'];
            $car_id = $req_data['car_id'];
            $payment_type_id = $req_data['payment_type_id'];
            $company_id = $req_data['company_id'];
            $branch_id = $req_data['branch_id'];
            $datalist = $req_data['data'];
        }

        $data = [];
        $is_free = 0;
        if ($payment_type_id == 3) {
            $is_free = 1;
        }
        if ($customer_id && $route_id && $car_id) {
            //  $sale_date = date('Y/m/d');
            $sale_date = date('Y/m/d');

           // $sale_time = date('H:i:s');
            $order_total_all = 0;
            $has_order = $this->hasOrder($sale_date, $route_id, $car_id);
            if ($has_order != null) {
                $has_order_id = $has_order->id;
                if ($has_order_id) {
                    if (count($datalist) > 0) {
                        for ($i = 0; $i <= count($datalist) - 1; $i++) {
                            if ($datalist[$i]['qty'] <= 0) continue;

                            // $price_group_id = $this->findCustomerpricgroup($customer_id, $datalist[$i]['product_id'], $route_id);

                            $line_total = ($datalist[$i]['qty'] * $datalist[$i]['price']);

                            $model_line_trans = new \backend\models\Orderlinetrans();
                            $model_line_trans->order_id = $has_order_id;
                            $model_line_trans->customer_id = $customer_id;
                            $model_line_trans->product_id = $datalist[$i]['product_id'];
                            $model_line_trans->qty = $datalist[$i]['qty'];
                            $model_line_trans->price = $payment_type_id == 3 ? 0 : $datalist[$i]['price'];
                            $model_line_trans->line_total = $payment_type_id == 3 ? 0 : $line_total;
                            $model_line_trans->price_group_id = $datalist[$i]['price_group_id'];//$price_group_id;
                            $model_line_trans->sale_payment_method_id = $payment_type_id;
                            $model_line_trans->issue_ref_id = $issue_id;
                            $model_line_trans->status = 1;
                            $model_line_trans->is_free = $is_free;
                            if ($model_line_trans->save(false)) {

                                $modelx = \common\models\OrderLine::find()->where(['product_id' => $datalist[$i]['product_id'], 'order_id' => $has_order_id, 'customer_id' => $customer_id])->one();
                                if ($modelx) {
                                    $modelx->qty = ($modelx->qty + $datalist[$i]['qty']);
                                    $modelx->line_total = $payment_type_id == 3 ? 0 : ($modelx->qty * $datalist[$i]['price']);
                                    $modelx->status = 1;
                                    $modelx->is_free = $is_free;
                                    if ($modelx->save(false)) {
                                        $status = true;
                                    }
                                } else {

                                    $model_line = new \backend\models\Orderline();
                                    $model_line->order_id = $has_order_id;
                                    $model_line->customer_id = $customer_id;
                                    $model_line->product_id = $datalist[$i]['product_id'];
                                    $model_line->qty = $datalist[$i]['qty'];
                                    $model_line->price = $payment_type_id == 3 ? 0 : $datalist[$i]['price'];
                                    $model_line->line_total = $payment_type_id == 3 ? 0 : $line_total;
                                    $model_line->price_group_id = $datalist[$i]['price_group_id'];//$price_group_id;
                                    $model_line->sale_payment_method_id = $payment_type_id;
                                    $model_line->issue_ref_id = $issue_id;
                                    $model_line->status = 1;
                                    $model_line->is_free = $is_free;
                                    if ($model_line->save(false)) {

                                    }
                                }

                                if ($payment_type_id == 1) {
                                    $this->addpayment($has_order_id, $customer_id, $line_total, $company_id, $branch_id, $payment_type_id);
                                }

                                //  $order_total_all += $model_line_trans->line_total;

                                // issue order stock
                                $model_update_order_stock = \common\models\OrderStock::find()->where(['route_id' => $route_id, 'product_id' => $datalist[$i]['product_id'], 'date(trans_date)' => date('Y-m-d')])->andFilterWhere(['>', 'avl_qty', 0])->orderBy('id')->one();
                                if ($model_update_order_stock) {
                                    if ($model_update_order_stock->avl_qty >= $datalist[$i]['qty']) {
                                        $model_update_order_stock->order_id = $has_order_id;
                                        $model_update_order_stock->avl_qty = ($model_update_order_stock->avl_qty - $datalist[$i]['qty']);
                                        $model_update_order_stock->save(false);
                                    } else {
                                        $remain_qty = ($datalist[$i]['qty'] - $model_update_order_stock->avl_qty);

                                        $model_update_order_stock->order_id = $has_order_id;
                                        $model_update_order_stock->avl_qty = 0;
                                        if ($model_update_order_stock->save(false)) {

                                            $model_update_order_stock2 = \common\models\OrderStock::find()->where(['route_id' => $route_id, 'product_id' => $datalist[$i]['product_id'], 'date(trans_date)' => date('Y-m-d')])->andFilterWhere(['>', 'avl_qty', 0])->orderBy('id')->one();
                                            if ($model_update_order_stock2) {
                                                $model_update_order_stock2->order_id = $has_order_id;
                                                $model_update_order_stock2->avl_qty = ($model_update_order_stock2->avl_qty - $remain_qty);
                                                $model_update_order_stock2->save(false);
                                            }
                                        }
                                    }
                                }
                                // end issue order stock
                                $status = true;
                            }
                        }
                    }
                }
            } else {
                $model = new \backend\models\Ordermobile();
                $model->order_no = $model->getLastNo($sale_date, $company_id, $branch_id);
                // $model->order_date = date('Y-m-d H:i:s', strtotime($sale_date . ' ' . $sale_time));
                $model->order_date = date('Y-m-d H:i:s');
                $model->customer_id = 0;
                $model->order_channel_id = $route_id; // สายส่ง
                $model->sale_channel_id = 1; //ช่องทาง
                $model->car_ref_id = $car_id;
                $model->issue_id = $issue_id;
                $model->status = 1;
                $model->created_by = $user_id;
                $model->company_id = $company_id;
                $model->branch_id = $branch_id;
                $model->sale_from_mobile = 1;
                if ($model->save(false)) {
                   // array_push($data, ['order_id' => $model->id]);
                    if (count($datalist) > 0) {
                        for ($i = 0; $i <= count($datalist) - 1; $i++) {
                            if ($datalist[$i]['qty'] <= 0) continue;
                            // $price_group_id = $this->findCustomerpricgroup($customer_id, $datalist[$i]['product_id'], $route_id);
                            $line_total = ($datalist[$i]['qty'] * $datalist[$i]['price']);
                            $model_line_trans = new \backend\models\Orderlinetrans();
                            $model_line_trans->order_id = $model->id;
                            $model_line_trans->customer_id = $customer_id;
                            $model_line_trans->product_id = $datalist[$i]['product_id'];
                            $model_line_trans->qty = $datalist[$i]['qty'];
                            $model_line_trans->price = $payment_type_id == 3 ? 0 : $datalist[$i]['price'];
                            $model_line_trans->line_total = $payment_type_id == 3 ? 0 : $line_total;
                            $model_line_trans->price_group_id = $datalist[$i]['price_group_id'];//$price_group_id;
                            $model_line_trans->sale_payment_method_id = $payment_type_id;
                            $model_line_trans->issue_ref_id = $issue_id;
                            $model_line_trans->status = 1;
                            $model_line_trans->is_free = $is_free;

                            if ($model_line_trans->save(false)) {
                                $model_line = new \backend\models\Orderline();
                                $model_line->order_id = $model->id;
                                $model_line->customer_id = $customer_id;
                                $model_line->product_id = $datalist[$i]['product_id'];
                                $model_line->qty = $datalist[$i]['qty'];
                                $model_line->price = $payment_type_id == 3 ? 0 : $datalist[$i]['price'];
                                $model_line->line_total = $payment_type_id == 3 ? 0 : $line_total;
                                $model_line->price_group_id = $datalist[$i]['price_group_id'];//$price_group_id;
                                $model_line->status = 1;
                                $model_line->sale_payment_method_id = $payment_type_id;
                                $model_line->issue_ref_id = $issue_id;
                                $model_line->is_free = $is_free;
                                if ($model_line->save(false)) {
                                }

                                if ($payment_type_id ==1) {
                                    $this->addpayment($model->id, $customer_id, $line_total, $company_id, $branch_id, $payment_type_id);
                                }

                                $order_total_all += $model_line_trans->line_total;
                                $status = true;

                                // issue order stock
                                $model_update_order_stock = \common\models\OrderStock::find()->where(['route_id' => $route_id, 'product_id' => $datalist[$i]['product_id'], 'date(trans_date)' => date('Y-m-d')])->andFilterWhere(['>', 'avl_qty', 0])->orderBy('id')->one();
                                if ($model_update_order_stock) {
                                    if ($model_update_order_stock->avl_qty >= $datalist[$i]['qty']) {
                                        $model_update_order_stock->order_id = $model->id;
                                        $model_update_order_stock->avl_qty = ($model_update_order_stock->avl_qty - $datalist[$i]['qty']);
                                        $model_update_order_stock->save(false);
                                    } else {
                                        $remain_qty = ($datalist[$i]['qty'] - $model_update_order_stock->avl_qty);

                                        $model_update_order_stock->order_id = $model->id;
                                        $model_update_order_stock->avl_qty = 0;
                                        if ($model_update_order_stock->save(false)) {

                                            $model_update_order_stock2 = \common\models\OrderStock::find()->where(['route_id' => $route_id, 'product_id' => $datalist[$i]['product_id'], 'date(trans_date)' => date('Y-m-d')])->andFilterWhere(['>', 'avl_qty', 0])->orderBy('id')->one();
                                            if ($model_update_order_stock2) {
                                                $model_update_order_stock2->order_id = $model->id;
                                                $model_update_order_stock2->avl_qty = ($model_update_order_stock2->avl_qty - $remain_qty);
                                                $model_update_order_stock2->save(false);
                                            }
                                        }
                                    }
                                }
                                // end issue order stock
                            }
                        }
                    }

                    $model->order_total_amt = $order_total_all;
                    $model->save(false);
//                    if ($model->issue_id > 0) {
//                        $model_issue = \backend\models\Journalissue::find()->where(['id' => $model->issue_id])->one();
//                        if ($model_issue) {
//                            $model_issue->status = 2;
//                            $model_issue->order_ref_id = $model->id;
//                            $model_issue->company_id = $company_id;
//                            $model_issue->branch_id = $branch_id;
//                            $model_issue->save(false);
//                        }
//                    }
                }
            }
        }
        //  array_push($data,['data'=>$req_data]);

        return ['status' => $status, 'data' => $data];
    }


//    public function addPayment($customer_id, $trans_date,$order_id,$pay_amount,$company_id,$branch_id)
//    {
//        $status = false;
//        $model = \common\models\PaymentReceive::find()->where(['date(trans_date)' => $trans_date, 'customer_id' => $customer_id])->one();
//       // return $model;
//        if ($model) {
//            //if(count($check_record) > 0){
//            $model_line = new \common\models\PaymentReceiveLine();
//            $model_line->payment_receive_id = $model->id;
//            $model_line->order_id = $order_id;
//            $model_line->payment_amount =$pay_amount;
//            $model_line->payment_channel_id = 1; // 1 เงินสด 2 โอน
//            $model_line->payment_method_id = 1; // 1 สด
//            $model_line->status = 1;
//            if ($model_line->save(false)) {
//                $status = true;
//            }
//            // }
//        } else {
//            $model = new \backend\models\Paymentreceive();
//            $model->trans_date = date('Y-m-d');//date('Y-m-d H:i:s');
//            $model->customer_id = $customer_id;
//            $model->journal_no = $model->getLastNo2(date('Y-m-d'), $company_id, $branch_id);
//            $model->status = 1;
//            $model->company_id = $company_id;
//            $model->branch_id = $branch_id;
//            if ($model->save()) {
//                $model_line = new \common\models\PaymentReceiveLine();
//                $model_line->payment_receive_id = $model->id;
//                $model_line->order_id = $order_id;
//                $model_line->payment_amount = $pay_amount;
//                $model_line->payment_channel_id = 1; // 1 เงินสด 2 โอน
//                $model_line->payment_method_id = 1; // 1 สด
//                $model_line->status = 1;
//                if ($model_line->save(false)) {
//                    $status = true;
//                }
//            }
//        }
//    }

    public function actionAddorder()
    {
        $customer_id = null;
        $product_id = null;
        $qty = 0;
//        $price = 0;
//        $price_group_id = null;
        $status = false;
        $user_id = 0;
        $issue_id = 0;
        $route_id = 0;
        $api_date = null;
        $car_id = 0;
        $company_id = 0;
        $branch_id = 0;

        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $req_data = \Yii::$app->request->getBodyParams();
        if ($req_data != null) {
            $api_date = $req_data['order_date'];
            $customer_id = $req_data['customer_id'];
            $product_id = $req_data['product_id'];
            $qty = $req_data['qty'];
            $price = $req_data['price']; // find by route_id
            //  $price_group_id = $req_data['price_group_id'];
            $user_id = $req_data['user_id'] == null ? 0 : $req_data['user_id'];
            $issue_id = $req_data['issue_id'];
            $route_id = $req_data['route_id'];
            $car_id = $req_data['car_id'];
            $payment_type_id = $req_data['payment_type_id'];
            $company_id = $req_data['company_id'];
            $branch_id = $req_data['branch_id'];

        }

        $data = [];
        $is_free = 0;
        if ($payment_type_id == 3) {
            $is_free = 1;
        }
        if ($customer_id && $route_id && $car_id) {
            //  $sale_date = date('Y/m/d');
            $sale_date = date('Y/m/d');

            $order_total_all = 0;
            $has_order = $this->hasOrder($sale_date, $route_id, $car_id);
            if ($has_order != null) {
                $has_order_id = $has_order->id;
                if ($has_order_id) {
                    $this->registerissue($has_order_id, $issue_id, $company_id, $branch_id);
                    //$price = $this->findCustomerprice($customer_id, $product_id, $route_id);

                    $price_group_id = $this->findCustomerpricgroup($customer_id, $product_id, $route_id);

                    $modelx = \common\models\OrderLine::find()->where(['product_id' => $product_id, 'order_id' => $has_order_id, 'customer_id' => $customer_id])->one();
                    if ($modelx) {
                        $modelx->qty = ($modelx->qty + $qty);
                        $modelx->line_total = $payment_type_id == 3 ? 0 : ($modelx->qty * $price);
                        $modelx->status = 1;
                        $modelx->is_free = $is_free;
                        if ($modelx->save(false)) {
                            $status = true;
                            $model_update_issue_line = \common\models\JournalIssueLine::find()->where(['issue_id' => $issue_id, 'product_id' => $product_id])->one();
                            if ($model_update_issue_line) {
                                $model_update_issue_line->avl_qty = ($model_update_issue_line->avl_qty - (int)$qty);
                                $model_update_issue_line->save(false);
                            }
                        }
                    } else {
                        $model_line = new \backend\models\Orderline();
                        $model_line->order_id = $has_order_id;
                        $model_line->customer_id = $customer_id;
                        $model_line->product_id = $product_id;
                        $model_line->qty = $qty;
                        $model_line->price = $payment_type_id == 3 ? 0 : $price;
                        $model_line->line_total = $payment_type_id == 3 ? 0 : ($qty * $price);
                        $model_line->price_group_id = $price_group_id;
                        $model_line->sale_payment_method_id = $payment_type_id;
                        $model_line->issue_ref_id = $issue_id;
                        $model_line->status = 1;
                        $model_line->is_free = $is_free;
                        if ($model_line->save(false)) {

                            //  if ($payment_type_id == 2) {
                            if ($payment_type_id == 1) {
                                $this->addpayment($has_order_id, $customer_id, ($qty * $price), $company_id, $branch_id, $payment_type_id);
                            }

                            //  }

                            // $order_total_all += $model_line->line_total;
                            $status = true;

                            // issue order stock
                            $model_update_order_stock = \common\models\OrderStock::find()->where(['route_id' => $route_id, 'product_id' => $product_id, 'date(trans_date)' => date('Y-m-d')])->andFilterWhere(['>', 'avl_qty', 0])->orderBy('id')->one();
                            if ($model_update_order_stock) {
                                if ($model_update_order_stock->avl_qty >= $qty) {
                                    $model_update_order_stock->order_id = $has_order_id;
                                    $model_update_order_stock->avl_qty = $model_update_order_stock->avl_qty - $qty;
                                    $model_update_order_stock->save(false);
                                } else {
                                    $remain_qty = $qty - $model_update_order_stock->avl_qty;

                                    $model_update_order_stock->order_id = $has_order_id;
                                    $model_update_order_stock->avl_qty = 0;
                                    if ($model_update_order_stock->save(false)) {

                                        $model_update_order_stock2 = \common\models\OrderStock::find()->where(['route_id' => $route_id, 'product_id' => $product_id, 'date(trans_date)' => date('Y-m-d')])->andFilterWhere(['>', 'avl_qty', 0])->orderBy('id')->one();
                                        if ($model_update_order_stock2) {
                                            $model_update_order_stock2->order_id = $has_order_id;
                                            $model_update_order_stock2->avl_qty = $model_update_order_stock2->avl_qty - $remain_qty;
                                            $model_update_order_stock2->save(false);
                                        }
                                    }
                                }
                            }
                            // end issue order stock

                        }
                    }

//                    $model->order_total_amt = $order_total_all;
//                    $model->save(false);
                }
            } else {
                $model = new \backend\models\Ordermobile();
                $model->order_no = $model->getLastNo($sale_date, $company_id, $branch_id);
                // $model->order_date = date('Y-m-d H:i:s', strtotime($sale_date . ' ' . $sale_time));
                $model->order_date = date('Y-m-d H:i:s');
                $model->customer_id = 0;
                $model->order_channel_id = $route_id; // สายส่ง
                $model->sale_channel_id = 1; //ช่องทาง
                $model->car_ref_id = $car_id;
                $model->issue_id = $issue_id;
                $model->status = 1;
                $model->created_by = $user_id;
                $model->company_id = $company_id;
                $model->branch_id = $branch_id;
                $model->sale_from_mobile = 1;
                if ($model->save(false)) {
                    array_push($data, ['order_id' => $model->id]);
                    $this->registerissue($model->id, $issue_id, $company_id, $branch_id);
                    //   $price = $this->findCustomerprice($customer_id, $product_id, $route_id);
                    $price_group_id = $this->findCustomerpricgroup($customer_id, $product_id, $route_id);

                    $model_line = new \backend\models\Orderline();
                    $model_line->order_id = $model->id;
                    $model_line->customer_id = $customer_id;
                    $model_line->product_id = $product_id;
                    $model_line->qty = $qty;
                    $model_line->price = $payment_type_id == 3 ? 0 : $price;
                    $model_line->line_total = $payment_type_id == 3 ? 0 : ($qty * $price);
                    $model_line->price_group_id = $price_group_id;
                    $model_line->status = 1;
                    $model_line->sale_payment_method_id = $payment_type_id;
                    $model_line->issue_ref_id = $issue_id;
                    $model_line->is_free = $is_free;
                    if ($model_line->save(false)) {

                        //   if ($payment_type_id == 2) {

                        if ($payment_type_id != 3) {
                            $this->addpayment($model->id, $customer_id, ($qty * $price), $company_id, $branch_id, $payment_type_id);
                        }
                        //  }

                        $order_total_all += $model_line->line_total;
                        $status = true;

                        // issue order stock
                        $model_update_order_stock = \common\models\OrderStock::find()->where(['route_id' => $route_id, 'product_id' => $product_id, 'date(trans_date)' => date('Y-m-d')])->andFilterWhere(['>', 'avl_qty', 0])->orderBy('id')->one();
                        if ($model_update_order_stock) {
                            if ($model_update_order_stock->avl_qty >= $qty) {
                                $model_update_order_stock->order_id = $model->id;
                                $model_update_order_stock->avl_qty = $model_update_order_stock->avl_qty - $qty;
                                $model_update_order_stock->save(false);
                            } else {
                                $remain_qty = $qty - $model_update_order_stock->avl_qty;
                                $model_update_order_stock->order_id = $model->id;
                                $model_update_order_stock->avl_qty = 0;
                                if ($model_update_order_stock->save(false)) {

                                    $model_update_order_stock2 = \common\models\OrderStock::find()->where(['route_id' => $route_id, 'product_id' => $product_id, 'date(trans_date)' => date('Y-m-d')])->andFilterWhere(['>', 'avl_qty', 0])->orderBy('id')->one();
                                    if ($model_update_order_stock2) {
                                        $model_update_order_stock2->order_id = $model->id;
                                        $model_update_order_stock2->avl_qty = $model_update_order_stock2->avl_qty - $remain_qty;
                                        $model_update_order_stock2->save(false);
                                    }
                                }
                            }
                        }
                        // end issue order stock

                    }
                    $model->order_total_amt = $order_total_all;
                    $model->save(false);
                    if ($model->issue_id > 0) {
                        $model_issue = \backend\models\Journalissue::find()->where(['id' => $model->issue_id])->one();
                        if ($model_issue) {
                            $model_issue->status = 2;
                            $model_issue->order_ref_id = $model->id;
                            $model_issue->company_id = $company_id;
                            $model_issue->branch_id = $branch_id;
                            $model_issue->save(false);
                        }

                    }
                }
            }
        }
        //  array_push($data,['data'=>$req_data]);

        return ['status' => $status, 'data' => $data];
    }

    public function hasOrder($order_date, $route_id, $car_id)
    {
        $order_date = date('Y-m-d');
        $res = null;
        if ($route_id && $car_id) {
            $model = \common\models\Orders::find()->where(['date(order_date)' => $order_date, 'order_channel_id' => $route_id, 'car_ref_id' => $car_id, 'status' => 1])->one();
            $res = $model;
        }
        return $res;
    }

//    public function checkorderopen($route_id,$order_date){
//        if($route_id){
//            $model = \common\models\Orders::find()->where(['delivery_route_id'=>$route_id,'date(order_date)'=>$order_date,'status'=>1])->count();
//        }
//    }
//    public function checkissueorder($route_id,$order_date){
//        if($route_id){
//            $model = \common\models\OrderStock::find()->where(['route_id'=>$route_id,'date(trans_date)'=>$order_date])->count();
//        }
//    }

    public function findCustomerprice($customer_id, $product_id, $route_id)
    {
        $price = 0;
        if ($product_id && $route_id) {
            $model = \common\models\QueryCustomerPrice::find()->where(['cus_id' => $customer_id, 'product_id' => $product_id, 'delivery_route_id' => $route_id])->one();
            if ($model) {
                $price = $model->sale_price == null ? 0 : $model->sale_price;
            }
        }
        return $price;
    }

    public function findCustomerpricgroup($customer_id, $product_id, $route_id)
    {
        $group_id = 0;
        if ($product_id && $route_id) {
            $model = \common\models\QueryCustomerPrice::find()->where(['cus_id' => $customer_id, 'product_id' => $product_id, 'delivery_route_id' => $route_id])->one();
            if ($model) {
                $group_id = $model->id == null ? 0 : $model->id;
            }
        }
        return $group_id;
    }

    public function addpayment($order_id, $customer_id, $amount, $company_id, $branch_id, $payment_type_id)
    {
        $status = false;
        $model = \common\models\PaymentReceive::find()->where(['date(trans_date)' => date('Y-m-d'), 'customer_id' => $customer_id])->one();
       // return $model;
        if ($model) {
            //if(count($check_record) > 0){
            $model_line = new \common\models\PaymentReceiveLine();
            $model_line->payment_receive_id = $model->id;
            $model_line->order_id = $order_id;
            $model_line->payment_amount =$amount;
            $model_line->payment_channel_id = 1; // 1 เงินสด 2 โอน
            $model_line->payment_method_id = 1; // 1 สด
            $model_line->status = 1;
            if ($model_line->save(false)) {
                $status = true;
            }
            // }
        } else {
            $model = new \backend\models\Paymentreceive();
            $model->trans_date = date('Y-m-d');//date('Y-m-d H:i:s');
            $model->customer_id = $customer_id;
            $model->journal_no = $model->getLastNo2(date('Y-m-d'), $company_id, $branch_id);
            $model->status = 1;
            $model->company_id = $company_id;
            $model->branch_id = $branch_id;
            if ($model->save()) {
                $model_line = new \common\models\PaymentReceiveLine();
                $model_line->payment_receive_id = $model->id;
                $model_line->order_id = $order_id;
                $model_line->payment_amount = $amount;
                $model_line->payment_channel_id = 1; // 1 เงินสด 2 โอน
                $model_line->payment_method_id = 1; // 1 สด
                $model_line->status = 1;
                if ($model_line->save(false)) {
                    $status = true;
                }
            }
        }

//        $model = new \backend\models\Paymenttrans();
//        $model->trans_no = $model->getLastNo($company_id, $branch_id);
//        $model->trans_date = date('Y-m-d H:i:s');
//        $model->order_id = $order_id;
//        $model->status = 0;
//        $model->company_id = $company_id;
//        $model->branch_id = $branch_id;
//        if ($model->save(false)) {
//            if ($customer_id != null) {
//
//                $model_line = new \backend\models\Paymenttransline();
//                $model_line->trans_id = $model->id;
//                $model_line->customer_id = $customer_id;
//                $model_line->payment_method_id = 8;
//                $model_line->payment_term_id = 0;
//                $model_line->payment_date = date('Y-m-d H:i:s');
//                $model_line->payment_amount = $payment_type_id == 1 ? $amount : 0;
//                $model_line->total_amount = 0;
//                $model_line->order_ref_id = $order_id;
//                $model_line->payment_type_id = $payment_type_id;
//                $model_line->status = 1;
//                $model_line->doc = '';
//                if ($model_line->save(false)) {
//
//                }
//
//            }
//        }
    }

    public function actionList()
    {
        $status = false;
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $req_data = \Yii::$app->request->getBodyParams();
        $car_id = $req_data['car_id'];
        $api_date = $req_data['order_date'];

        $data = [];
        if ($car_id) {

            $sale_date = date('Y-m-d');
            $t_date = null;
            $exp_order_date = explode(' ', $api_date);
            if ($exp_order_date != null) {
                if (count($exp_order_date) > 1) {
                    $x_date = explode('-', $exp_order_date[0]);
                    if (count($x_date) > 1) {
                        $t_date = $x_date[0] . "/" . $x_date[1] . "/" . $x_date[2];
                    }
                }
            }
            if ($t_date != null) {
                $sale_date = $t_date;
            }

            $model = \common\models\QueryApiOrderDailySummary::find()->where(['car_ref_id' => $car_id, 'date(order_date)' => $sale_date])->all();
            // $model = \common\models\Orders::find()->where(['id'=>131])->all();
            //  $model = \common\models\Orders::find()->where(['car_ref_id' => $car_id])->all();
            if ($model) {
                $status = true;
                foreach ($model as $value) {
                    array_push($data, [
                        'id' => $value->id,
                        'order_no' => $value->order_no,
                        'order_date' => $value->order_date,
                        'order_status' => $value->status,
                        'customer_id' => $value->customer_id,
                        'customer_code' => $value->code,
                        'customer_name' => $value->name,
                        'note' => '',
                        'payment_method' => $value->payment_method_name,
                        'payment_method_id' => $value->pay_type,
                        'sale_payment_method_id' => $value->sale_payment_method_id,
                        'total_amount' => $value->line_total == null ? 0 : $value->line_total,
                        'total_qty' => $value->line_qty == null ? 0 : $value->line_qty,
                    ]);
                }
            }
        }
        return ['status' => $status, 'data' => $data];
    }

    public function actionListnew()
    {
        $status = false;
        $searchcustomer = '';
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $req_data = \Yii::$app->request->getBodyParams();
        $car_id = $req_data['car_id'];
        $api_date = $req_data['order_date'];
        $searchcustomer = $req_data['searchcustomer'];

        $data = [];
        if ($car_id) {

            $sale_date = date('Y-m-d');
            $t_date = null;
            $exp_order_date = explode(' ', $api_date);
            if ($exp_order_date != null) {
                if (count($exp_order_date) > 1) {
                    $x_date = explode('-', $exp_order_date[0]);
                    if (count($x_date) > 1) {
                        $t_date = $x_date[0] . "/" . $x_date[1] . "/" . $x_date[2];
                    }
                }
            }
            if ($t_date != null) {
                $sale_date = $t_date;
            }
            $model = null;
            if ($searchcustomer != '') {
                $model = \common\models\QueryApiOrderDailySummaryNew::find()->where(['car_ref_id' => $car_id, 'date(order_date)' => $sale_date, 'status' => 1, 'customer_id' => $searchcustomer])->all();
            } else {
                $model = \common\models\QueryApiOrderDailySummaryNew::find()->where(['car_ref_id' => $car_id, 'date(order_date)' => $sale_date, 'status' => 1])->all();
            }

            // $model = \common\models\Orders::find()->where(['id'=>131])->all();
            //  $model = \common\models\Orders::find()->where(['car_ref_id' => $car_id])->all();
            if ($model) {
                $status = true;
                foreach ($model as $value) {
                    array_push($data, [
                        'id' => $value->id,
                        'order_no' => $value->order_no,
                        'order_date' => $value->order_date,
                        'order_status' => $value->status,
                        'customer_id' => $value->customer_id,
                        'customer_code' => $value->code,
                        'customer_name' => $value->name,
                        'note' => '',
                        'sale_payment_method_id' => $value->sale_payment_method_id,
                        'line_total' => $value->line_total == null ? 0 : $value->line_total,
                        'qty' => $value->line_qty == null ? 0 : $value->line_qty,
                        'price' => $value->price == null ? 0 : $value->price,
                        'order_line_id' => $value->order_line_id,
                        'product_id' => $value->product_id,
                        'product_code' => $value->product_code,
                        'product_name' => $value->product_name,
                        'order_line_date' => date('d-m-Y H:i:s', $value->created_at),
                        'order_line_status' => $value->order_line_status,
                    ]);
                }
            }
        }
        return ['status' => $status, 'data' => $data];
    }


    public function actionAddordertransfer()
    {
        $customer_id = null;
        $product_id = null;
        $qty = 0;
//        $price = 0;
//        $price_group_id = null;
        $status = false;
        $user_id = 0;
        $transfer_id = 0;
        $route_id = 0;
        $api_date = null;
        $car_id = 0;

        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $req_data = \Yii::$app->request->getBodyParams();
        if ($req_data != null) {
            $api_date = $req_data['order_date'];
            $customer_id = $req_data['customer_id'];
            $product_id = $req_data['product_id'];
            $qty = $req_data['qty'];
            $price = $req_data['price']; // find by route_id
            //  $price_group_id = $req_data['price_group_id'];
            $user_id = $req_data['user_id'] == null ? 0 : $req_data['user_id'];
            $issue_id = $req_data['issue_id'];
            $route_id = $req_data['route_id'];
            $car_id = $req_data['car_id'];
            $transfer_id = $req_data['transfer_id'];
        }

        $data = [];
        if ($customer_id && $route_id && $car_id) {
            //  $sale_date = date('Y/m/d');
            $sale_date = date('Y/m/d');
//            $t_date = null;
//            $exp_order_date = explode(' ', $api_date);
//            if ($exp_order_date != null) {
//                if (count($exp_order_date) > 1) {
//                    $x_date = explode('-', $exp_order_date[0]);
//                    if (count($x_date) > 1) {
//                        $t_date = $x_date[0] . "/" . $x_date[1] . "/" . $x_date[2];
//                    }
//                }
//            }
//            if ($t_date != null) {
//                $sale_date = $t_date;
//            }
           // $sale_time = date('H:i:s');

            $order_total_all = 0;

            $has_order = $this->hasOrder($sale_date, $route_id, $car_id);
            if ($has_order != null) {
                $has_order_id = $has_order->id;
                if ($has_order_id) {
                    //$price = $this->findCustomerprice($customer_id, $product_id, $route_id);

                    $price_group_id = $this->findCustomerpricgroup($customer_id, $product_id, $route_id);

                    $modelx = \common\models\OrderLine::find()->where(['product_id' => $product_id, 'order_id' => $has_order_id, 'customer_id' => $customer_id])->one();
                    if ($modelx) {
                        $modelx->qty = ($modelx->qty + $qty);
                        $modelx->line_total = ($modelx->qty * $price);
                        $modelx->status = 1;
                        if ($modelx->save(false)) {
                            $status = true;
                        }
                    } else {
                        $model_line = new \backend\models\Orderline();
                        $model_line->order_id = $has_order_id;
                        $model_line->customer_id = $customer_id;
                        $model_line->product_id = $product_id;
                        $model_line->qty = $qty;
                        $model_line->price = $price;
                        $model_line->line_total = ($qty * $price);
                        $model_line->price_group_id = $price_group_id;
                        $model_line->status = 1;
                        if ($model_line->save(false)) {
                            $order_total_all += $model_line->line_total;
                            $status = true;

                            $model_update_transfer_line = \common\models\TransferLine::find()->where(['transfer_id' => $transfer_id, 'product_id' => $product_id])->one();
                            if ($model_update_transfer_line) {
                                $model_update_transfer_line->avl_qty = $model_update_transfer_line->avl_qty - $qty;
                                $model_update_transfer_line->save(false);
                            }
                        }
                    }


//                    $model->order_total_amt = $order_total_all;
//                    $model->save(false);
                }
            } else {
                $model = new \backend\models\Orders();
                $model->order_no = $model->getLastNo($sale_date);
                // $model->order_date = date('Y-m-d H:i:s', strtotime($sale_date . ' ' . $sale_time));
                $model->order_date = date('Y-m-d H:i:s');
                $model->customer_id = 0;
                $model->order_channel_id = $route_id; // สายส่ง
                $model->sale_channel_id = 1; //ช่องทาง
                $model->car_ref_id = $car_id;
                $model->issue_id = $issue_id;
                $model->status = 1;
                $model->created_by = $user_id;
                if ($model->save(false)) {
                    //   $price = $this->findCustomerprice($customer_id, $product_id, $route_id);
                    $price_group_id = $this->findCustomerpricgroup($customer_id, $product_id, $route_id);
                    $model_line = new \backend\models\Orderline();
                    $model_line->order_id = $model->id;
                    $model_line->customer_id = $customer_id;
                    $model_line->product_id = $product_id;
                    $model_line->qty = $qty;
                    $model_line->price = $price;
                    $model_line->line_total = ($qty * $price);
                    $model_line->price_group_id = $price_group_id;
                    $model_line->status = 1;
                    if ($model_line->save(false)) {
                        $order_total_all += $model_line->line_total;
                        $status = true;

                        $model_update_transfer_line = \common\models\TransferLine::find()->where(['transfer_id' => $transfer_id, 'product_id' => $product_id])->one();
                        if ($model_update_transfer_line) {
                            $model_update_transfer_line->avl_qty = $model_update_transfer_line->avl_qty - $qty;
                            $model_update_transfer_line->save(false);
                        }
                    }
                    $model->order_total_amt = $order_total_all;
                    $model->save(false);
                }
            }
        }
        //  array_push($data,['data'=>$req_data]);

        return ['status' => $status, 'data' => $data];
    }


    public function actionListbycustomer()
    {
        $status = false;
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $req_data = \Yii::$app->request->getBodyParams();
        $customer_id = $req_data['customer_id'];
        $order_id = $req_data['order_id'];

        $data = [];
        if ($customer_id) {
            //$model = \common\models\QueryApiOrderDaily::find()->where(['customer_id' => $customer_id])->andFilterWhere(['id' => $order_id])->andFilterWhere(['>', 'qty', 0])->all();
            $model = \common\models\QueryApiOrderDailySummaryNew::find()->where(['customer_id' => $customer_id])->andFilterWhere(['id' => $order_id])->andFilterWhere(['>', 'line_qty', 0])->all();
            if ($model) {
                $status = true;
                foreach ($model as $value) {
                    array_push($data, [
                        'order_id' => $value->id,
                        'order_no' => $value->order_no,
                        'order_date' => $value->order_date,
                        'order_status' => $value->status,
                        'line_id' => $value->order_line_id,
                        'customer_id' => $value->customer_id,
                        'customer_name' => $value->name,
                        'customer_code' => $value->code,
                        'product_id' => $value->product_id,
                        'product_code' => $value->product_code,
                        'product_name' => $value->product_name,
                        'qty' => $value->line_qty,
                        'price' => $value->price,
                        'price_group_id' => '',
                        'order_line_status' => \backend\models\Orderlinetrans::findStatus($value->order_line_id),
                    ]);

                }
            }
        }

        return ['status' => $status, 'data' => $data];
    }

    public function getSumbycust($order_id)
    {
        $data = [];
        if ($order_id) {
            $model = \backend\models\Orderline::find()->select(['customer_id', 'sum(line_total) as line_total'])->where(['order_id' => $order_id])->groupBy('customer_id')->all();
            if ($model) {
                foreach ($model as $value) {
                    array_push($data, ['customer_id' => $value->customer_id, 'line_total' => $value->line_total]);
                }
            }
        }
        return $data;
    }

    public function actionDeleteorderline()
    {
        $status = false;
        $id = null;


        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $req_data = \Yii::$app->request->getBodyParams();
        $id = $req_data['id'];

        $data = [];
        if ($id) {
            $model_data = \backend\models\Orderline::find()->where(['id' => $id])->one();
            if ($model_data) {
                // $model_return_issue = \backend\models\Journalissueline::find()->where(['product_id' => $model_data->product_id, 'issue_id' => $model_data->issue_ref_id])->andFilterWhere(['>', 'qty', 0])->one();
                $model_return_issue = \common\models\OrderStock::find()->where(['product_id' => $model_data->product_id, 'order_id' => $model_data->order_id])->one();

                if ($model_return_issue) {
                    $model_return_issue->avl_qty = (int)$model_return_issue->avl_qty + (int)$model_data->qty;
                    if ($model_return_issue->save(false)) {
                        if (\common\models\OrderLine::deleteAll(['id' => $id])) {
                            $status = true;
                        }
                    }
                }
            }

        }

        return ['status' => $status, 'data' => $data];
    }

    public function actionDeleteordercustomer()
    {
        $status = false;
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $req_data = \Yii::$app->request->getBodyParams();
        $order_id = $req_data['order_id'];
        $customer_id = $req_data['customer_id'];

        $data = [];
        if ($order_id != null && $customer_id != null) {
            if (\common\models\OrderLine::updateAll(['qty' => 0, 'price' => 0, 'line_total' => 0], ['order_id' => $order_id, 'customer_id' => $customer_id])) {
                $status = true;
            }
        }
        return ['status' => $status, 'data' => $data];
    }

    public function actionDeleteorder()
    {
        $status = false;
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $req_data = \Yii::$app->request->getBodyParams();
        $id = $req_data['order_id'];

        $data = [];
        if (!$id) {
            if (\common\models\Order::deleteAll(['id' => $id])) {
                $status = true;
            }
        }

        return ['status' => $status, 'data' => $data];
    }

    public function actionCustomercredit()
    {
        $status = false;
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $req_data = \Yii::$app->request->getBodyParams();
        $id = $req_data['orderline_id'];

        $data = [];
        if ($cus_id) {
            $model = \common\models\QuerySalePaySummary::find()->where(['customer_id' => $cus_id])->andFilterWhere(['>', 'remain_amount', 0])->all();
            if ($model) {
//                $html = $cus_id;
                $i = 0;
                foreach ($model as $value) {
                    $i += 1;
                    //   $total_amount = $total_amount + ($value->remain_amount == null ? 0 : $value->remain_amount);
                    $html .= '<tr>';
                    $html .= '<td style="text-align: center">' . $i . '</td>';
                    $html .= '<td style="text-align: center">' . \backend\models\Orders::getNumber($value->order_id) . '</td>';
                    $html .= '<td style="text-align: center">' . date('d/m/Y', strtotime($value->order_date)) . '</td>';
                    $html .= '<td>
                            <select name="line_pay_type[]" id=""  class="form-control" onchange="checkpaytype($(this))">
                                <option value="0">เงินสด</option>
                                <option value="1">โอนธนาคาร</option>
                            </select>
                            <input type="file" class="line-doc" name="line_doc[]" style="display: none">
                            <input type="hidden" class="line-order-id" name="line_order_id[]" value="' . $value->order_id . '">
                            <input type="hidden" class="line-number" name="line_number[]" value="' . ($i - 1) . '">
                    </td>';
//                    $html .= '<td style="text-align: center"><input type="file" class="form-control"></td>';
                    $html .= '<td>
                            <input type="text" class="form-control line-remain" style="text-align: right" name="line_remain[]" value="' . number_format($value->remain_amount, 2) . '" readonly>
                            <input type="hidden" class="line-remain-qty" value="' . $value->remain_amount . '">
                            </td>';
                    $html .= '<td><input type="number" class="form-control line-pay" name="line_pay[]" value="" onchange="linepaychange($(this))"></td>';
                    $html .= '</tr>';

                }
                // $html .= '<tr><td colspan="4" style="text-align: right">รวม</td><td style="text-align: right;font-weight: bold">' . number_format($total_amount, 2) . '</td><td style="text-align: right;font-weight: bold"><span class="line-pay-total">0</span></td></tr>';
            }
        }

        echo $html;
    }

    public function registerissue($order_id, $issue_id, $company_id, $branch_id)
    {

//        $order_id = \Yii::$app->request->post('order_id');
//        $issuelist = \Yii::$app->request->post('issue_list');
        $default_wh = 6;
        if ($company_id == 1 && $branch_id == 2) {
            $default_wh = 5;
        }

        if ($order_id != null && $issue_id != null) {
            //  $issue_data = explode(',', $issuelist);
//            print_r($issuelist[0]);

            $model_check_has_issue = \common\models\OrderStock::find()->where(['order_id' => $order_id, 'issue_id' => $issue_id])->count();
            if ($model_check_has_issue > 0) {

            } else {
//                $model_order= \backend\models\Orders::find()->where(['id'=>$order_id])->one();
//                if($model_order){
//                    $model_order->
//                }
                $model_issue_line = \backend\models\Journalissueline::find()->where(['issue_id' => $issue_id])->all();
                foreach ($model_issue_line as $val2) {
                    if ($val2->qty <= 0 || $val2->qty == null) continue;
                    $model_order_stock = new \common\models\OrderStock();
                    $model_order_stock->issue_id = $issue_id;
                    $model_order_stock->product_id = $val2->product_id;
                    $model_order_stock->qty = $val2->qty;
                    $model_order_stock->used_qty = 0;
                    $model_order_stock->avl_qty = $val2->qty;
                    $model_order_stock->order_id = $order_id;
                    if ($model_order_stock->save(false)) {
                        $model_update_issue_status = \common\models\JournalIssue::find()->where(['id' => $issue_id])->one();
                        if ($model_update_issue_status) {
                            $model_update_issue_status->status = 2;
                            $model_update_issue_status->save(false);
                        }
                        $this->updateStock($val2->product_id, $val2->qty, $default_wh, '');
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
            $model_trans->warehouse_id = $wh_id;
            $model_trans->stock_type = 2; // 1 in 2 out
            $model_trans->activity_type_id = 6; // 6 issue car
            if ($model_trans->save(false)) {
                $model = \backend\models\Stocksum::find()->where(['warehouse_id' => $wh_id, 'product_id' => $product_id])->one();
                if ($model) {
                    $model->qty = $model->qty - (int)$qty;
                    $model->save(false);
                }
            }
        }
    }

    public function actionCloseorder()
    {
        $status = 0;

        $company_id = 1;
        $branch_id = 1;
        $order_id = null;

        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $req_data = \Yii::$app->request->getBodyParams();

        $order_id = $req_data['order_id'];
        $company_id = $req_data['company_id'];
        $branch_id = $req_data['branch_id'];

        $default_wh = 6;
        if ($company_id == 1 && $branch_id == 2) {
            $default_wh = 5;
        }
        $reprocess_wh = 0;

        $data = [];
        $res = 0;
        if ($order_id != null && $company_id != null && $branch_id != null) {
            $reprocess_wh = $this->findReprocesswh($company_id, $branch_id);
            //   $model = \backend\models\Orders::find()->where(['order_channel_id' => $route_id, 'date(order_date)' => $f_date])->andFilterWhere(['<', 'status', 100])->one();
            // $model_close = \common\models\QuerySaleFinished::find()->where(['id' => $order_id])->all();
            $model_close = \common\models\OrderStock::find()->where(['order_id' => $order_id])->all();
            if ($model_close) {
                $x = 0;
                foreach ($model_close as $value) {
                    if ($value->avl_qty <= 0 || $value->avl_qty == null) {
                        $x += 1;
                        continue;
                    }
                    $model = new \backend\models\Stocktrans();
                    $model->journal_no = '';
                    $model->trans_date = date('Y-m-d H:i:s');
                    $model->product_id = $value->product_id;
                    $model->qty = $value->avl_qty;
                    $model->warehouse_id = $default_wh;
                    $model->stock_type = 1;
                    $model->activity_type_id = 7; // 1 prod rec 2 issue car
                    $model->company_id = $company_id;
                    $model->branch_id = $branch_id;
                    if ($model->save()) {
                        $this->updateSummary($value->product_id, $reprocess_wh, $value->avl_qty, $company_id, $branch_id);
                        $res += 1;
                        $data = ['stock' => 'ok', 'order_id' => $order_id];
                    }
                }
                if ($res > 0 || $x == count($model_close)) {
                    $model_update = \backend\models\Orders::find()->where(['id' => $order_id])->one();
                    if ($model_update) {
                        $model_update->status = 100;
                        if ($model_update->save(false)) {
//                            $model_issue = \common\models\OrderStock::find()->distinct('issue_id')->where(['order_id' => $order_id])->all();
//                            if ($model_issue) {
//                                foreach ($model_issue as $value) {
//                                    $model_update_issue = \common\models\JournalIssue::find()->where(['id' => $value->issue_id])->one();
//                                    if ($model_update_issue) {
//                                        $model_update_issue->status = 100;
//                                        $model_update_issue->save(false);
//                                    }
//                                }
//                            }
                        }
                        $status = 1;
                    }
                }
            }

        }

        return ['status' => $status, 'data' => $data];
    }

    public function updateSummary($product_id, $wh_id, $qty, $company_id, $branch_id)
    {
        if ($wh_id != null && $product_id != null && $qty > 0) {
            $model = \backend\models\Stocksum::find()->where(['warehouse_id' => $wh_id, 'product_id' => $product_id])->one();
            if ($model) {
                $model->qty = ($model->qty + (int)$qty);
                $model->save(false);
            } else {
                $model_new = new \backend\models\Stocksum();
                $model_new->warehouse_id = $wh_id;
                $model_new->product_id = $product_id;
                $model_new->qty = $qty;
                $model_new->company_id = $company_id;
                $model_new->branch_id = $branch_id;
                $model_new->save(false);
            }
        }
    }

    public function findReprocesswh($company_id, $branch_id)
    {
        $id = 0;
        if ($company_id && $branch_id) {
            $model = \backend\models\Warehouse::find()->where(['company_id' => $company_id, 'branch_id' => $branch_id, 'is_reprocess' => 1])->one();
            if ($model) {
                $id = $model->id;
            }
        }
        return $id;
    }

    public function actionCancelorder()
    {
        $status = 0;

        $order_line_id = 0;
        $route_name = "";
        $order_no = '';
        $customer_code = '';
        $product_code = '';
        $reason = '';


        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $req_data = \Yii::$app->request->getBodyParams();
        $order_line_id = $req_data['line_id'];
        $route_name = $req_data['route_name'];
        $order_no = $req_data['order_no'];
        $customer_code = $req_data['customer_code'];
        $product_code = $req_data['product_code'];
        $reason = $req_data['reason'];

        $data = [];

        if ($order_line_id != null) {
            $model = \backend\models\Orderlinetrans::find()->where(['id' => $order_line_id])->one();
            if ($model) {
                $model_order_stock = \common\models\OrderStock::find()->where(['order_id' => $model->order_id, 'product_id' => $model->product_id])->one();
                if ($model_order_stock) {
                    $model_order_stock->avl_qty = $model_order_stock->avl_qty + $model->qty;
                    if ($model_order_stock->save(false)) {
                        $model->status = 500;
                        if ($model->save(false)) {
                            $model_update_line = \backend\models\Orderline::find()->where(['order_id' => $model->order_id, 'product_id' => $model->product_id])->one();
                            if ($model_update_line) {
                                $new_line_total = ($model_update_line->price * $model->qty);
                                $model_update_line->qty = ($model_update_line->qty - $model->qty);
                                $model_update_line->line_total = ($model_update_line->line_total - $new_line_total);
                                $model_update_line->save(false);
                            }
                            $status = 1;
                            array_push($data, ['cancel_order' => 'successfully']);
                            $this->notifymessage('สายส่ง: ' . $route_name . ' ยกเลิกรายการขาย ' . $order_no . ' ลูกค้า: ' . $customer_code . ' ยอดเงิน: ' . $model->line_total . ' เหตุผล: ' . $reason);
                        }
                    }
                }
            }
        }
        return ['status' => $status, 'data' => $data];
    }

    public function notifymessage($message)
    {
        //$message = "This is test send request from camel paperless";
        $line_api = 'https://notify-api.line.me/api/notify';
        $line_token = 'NY1xHWO4Qa6EWGA25AKuQVeHwSwpeTEPpCGE3pYB5qT';
        // $line_token = 'N3x9CANrOE3qjoAejRBLjrJ7FhLuTBPFuC9ToXh0szh';

        // $queryData = array('message' => $message);
        $queryData = array('message' => $message);
        $queryData = http_build_query($queryData, '', '&');
        $headerOptions = array(
            'http' => array(
                'method' => 'POST',
                'header' => "Content-Type: application/x-www-form-urlencoded\r\n"
                    . "Authorization: Bearer " . $line_token . "\r\n"
                    . "Content-Length: " . strlen($queryData) . "\r\n",
                'content' => $queryData
            )
        );
        $context = stream_context_create($headerOptions);
        $result = file_get_contents($line_api, FALSE, $context);
        $res = json_decode($result);
        return $res;
    }


//    public function actionAddordernew()
//    {
//        $customer_id = null;
//        $status = false;
//        $user_id = 0;
//        $issue_id = 0;
//        $route_id = 0;
//        $car_id = 0;
//        $company_id = 0;
//        $branch_id = 0;
//        $datalist = null;
//
//        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
//        $req_data = \Yii::$app->request->getBodyParams();
//        if ($req_data != null) {
//            $customer_id = $req_data['customer_id'];
//            $user_id = $req_data['user_id'] == null ? 0 : $req_data['user_id'];
//            //  $issue_id = $req_data['issue_id'];
//            $route_id = $req_data['route_id'];
//            $car_id = $req_data['car_id'];
//            $payment_type_id = $req_data['payment_type_id'];
//            $company_id = $req_data['company_id'];
//            $branch_id = $req_data['branch_id'];
//            $datalist = $req_data['data'];
//        }
//
//        $data = [];
//        $is_free = 0;
//        if ($payment_type_id == 3) {
//            $is_free = 1;
//        }
//        if ($customer_id && $route_id && $car_id) {
//            //  $sale_date = date('Y/m/d');
//            $sale_date = date('Y/m/d');
//
//            $sale_time = date('H:i:s');
//            $order_total_all = 0;
//            $has_order = $this->hasOrder($sale_date, $route_id, $car_id);
//            if ($has_order != null) {
//                $has_order_id = $has_order->id;
//                if ($has_order_id) {
//                    //$this->registerissue($has_order_id, $issue_id, $company_id, $branch_id);
//                    //$price = $this->findCustomerprice($customer_id, $product_id, $route_id);
//
//                    if (count($datalist) > 0) {
//                        for ($i = 0; $i <= count($datalist) - 1; $i++) {
//                            if ($datalist[$i]['qty'] <= 0) continue;
//
//                            // $price_group_id = $this->findCustomerpricgroup($customer_id, $datalist[$i]['product_id'], $route_id);
//
//                            $modelx = \common\models\OrderLine::find()->where(['product_id' => $datalist[$i]['product_id'], 'order_id' => $has_order_id, 'customer_id' => $customer_id])->one();
//                            if ($modelx) {
//                                $modelx->qty = ($modelx->qty + $datalist[$i]['qty']);
//                                $modelx->line_total = $payment_type_id == 3 ? 0 : ($modelx->qty * $datalist[$i]['price']);
//                                $modelx->status = 1;
//                                $modelx->is_free = $is_free;
//                                if ($modelx->save(false)) {
//                                    $status = true;
//
//                                }
//                            } else {
//                                $model_line = new \backend\models\Orderline();
//                                $model_line->order_id = $has_order_id;
//                                $model_line->customer_id = $customer_id;
//                                $model_line->product_id = $datalist[$i]['product_id'];
//                                $model_line->qty = $datalist[$i]['qty'];
//                                $model_line->price = $payment_type_id == 3 ? 0 : $datalist[$i]['price'];
//                                $model_line->line_total = $payment_type_id == 3 ? 0 : ($datalist[$i]['qty'] * $datalist[$i]['price']);
//                                $model_line->price_group_id = $datalist[$i]['price_group_id'] ;//$price_group_id;
//                                $model_line->sale_payment_method_id = $payment_type_id;
//                                $model_line->issue_ref_id = $issue_id;
//                                $model_line->status = 1;
//                                $model_line->is_free = $is_free;
//                                if ($model_line->save(false)) {
//
//                                    //  if ($payment_type_id == 2) {
//                                    if ($payment_type_id != 3) {
//                                        $this->addpayment($has_order_id, $customer_id, ($datalist[$i]['qty'] * $datalist[$i]['price']), $company_id, $branch_id, $payment_type_id);
//                                    }
//
//                                    //  }
//
//                                    $order_total_all += $model_line->line_total;
//                                    $status = true;
//
//                                    // issue order stock
//                                    $model_update_order_stock = \common\models\OrderStock::find()->where(['route_id' => $route_id, 'product_id' => $datalist[$i]['product_id'], 'date(trans_date)' => date('Y-m-d')])->andFilterWhere(['>', 'avl_qty', 0])->orderBy('id')->one();
//                                    if ($model_update_order_stock) {
//                                        if ($model_update_order_stock->avl_qty >= $datalist[$i]['qty']) {
//                                            $model_update_order_stock->order_id = $has_order_id;
//                                            $model_update_order_stock->avl_qty = $model_update_order_stock->avl_qty - $datalist[$i]['qty'];
//                                            $model_update_order_stock->save(false);
//                                        } else {
//                                            $remain_qty = $datalist[$i]['qty'] - $model_update_order_stock->avl_qty;
//
//                                            $model_update_order_stock->order_id = $has_order_id;
//                                            $model_update_order_stock->avl_qty = 0;
//                                            if ($model_update_order_stock->save(false)) {
//
//                                                $model_update_order_stock2 = \common\models\OrderStock::find()->where(['route_id' => $route_id, 'product_id' => $datalist[$i]['product_id'], 'date(trans_date)' => date('Y-m-d')])->andFilterWhere(['>', 'avl_qty', 0])->orderBy('id')->one();
//                                                if ($model_update_order_stock2) {
//                                                    $model_update_order_stock2->order_id = $has_order_id;
//                                                    $model_update_order_stock2->avl_qty = $model_update_order_stock2->avl_qty - $remain_qty;
//                                                    $model_update_order_stock2->save(false);
//                                                }
//                                            }
//                                        }
//                                    }
//                                    // end issue order stock
//
//                                }
//                            }
//
////                    $model->order_total_amt = $order_total_all;
////                    $model->save(false);
//                        }
//                    }
//
//                }
//            } else {
//                $model = new \backend\models\Ordermobile();
//                $model->order_no = $model->getLastNo($sale_date, $company_id, $branch_id);
//                // $model->order_date = date('Y-m-d H:i:s', strtotime($sale_date . ' ' . $sale_time));
//                $model->order_date = date('Y-m-d H:i:s');
//                $model->customer_id = 0;
//                $model->order_channel_id = $route_id; // สายส่ง
//                $model->sale_channel_id = 1; //ช่องทาง
//                $model->car_ref_id = $car_id;
//                $model->issue_id = $issue_id;
//                $model->status = 1;
//                $model->created_by = $user_id;
//                $model->company_id = $company_id;
//                $model->branch_id = $branch_id;
//                $model->sale_from_mobile = 1;
//                if ($model->save(false)) {
//                    array_push($data, ['order_id' => $model->id]);
//                    //$this->registerissue($model->id, $issue_id, $company_id, $branch_id);
//                    //   $price = $this->findCustomerprice($customer_id, $product_id, $route_id);
//
//                    if (count($datalist) > 0) {
//                        for ($i = 0; $i <= count($datalist) - 1; $i++) {
//                            if ($datalist[$i]['qty'] <= 0) continue;
//
//
//                            // $price_group_id = $this->findCustomerpricgroup($customer_id, $datalist[$i]['product_id'], $route_id);
//
//                            $model_line = new \backend\models\Orderline();
//                            $model_line->order_id = $model->id;
//                            $model_line->customer_id = $customer_id;
//                            $model_line->product_id = $datalist[$i]['product_id'];
//                            $model_line->qty = $datalist[$i]['qty'];
//                            $model_line->price = $payment_type_id == 3 ? 0 : $datalist[$i]['price'];
//                            $model_line->line_total = $payment_type_id == 3 ? 0 : ($datalist[$i]['qty'] * $datalist[$i]['price']);
//                            $model_line->price_group_id = $datalist[$i]['price_group_id'];//$price_group_id;
//                            $model_line->status = 1;
//                            $model_line->sale_payment_method_id = $payment_type_id;
//                            $model_line->issue_ref_id = $issue_id;
//                            $model_line->is_free = $is_free;
//                            if ($model_line->save(false)) {
//
//                                //   if ($payment_type_id == 2) {
//
//                                if ($payment_type_id != 3) {
//                                    $this->addpayment($model->id, $customer_id, ($datalist[$i]['qty'] * $datalist[$i]['price']), $company_id, $branch_id, $payment_type_id);
//                                }
//                                //  }
//
//                                $order_total_all += $model_line->line_total;
//                                $status = true;
////
////                        $model_update_issue_line = \common\models\JournalIssueLine::find()->where(['issue_id' => $issue_id, 'product_id' => $product_id])->one();
////                        if ($model_update_issue_line) {
////                            $model_update_issue_line->avl_qty = $model_update_issue_line->avl_qty - $qty;
////                            $model_update_issue_line->save(false);
////                        }
//                                // issue order stock
//                                $model_update_order_stock = \common\models\OrderStock::find()->where(['route_id' => $route_id, 'product_id' => $datalist[$i]['product_id'], 'date(trans_date)' => date('Y-m-d')])->andFilterWhere(['>', 'avl_qty', 0])->orderBy('id')->one();
//                                if ($model_update_order_stock) {
//                                    if ($model_update_order_stock->avl_qty >= $datalist[$i]['qty']) {
//                                        $model_update_order_stock->order_id = $model->id;
//                                        $model_update_order_stock->avl_qty = $model_update_order_stock->avl_qty - $datalist[$i]['qty'];
//                                        $model_update_order_stock->save(false);
//                                    } else {
//                                        $remain_qty = $datalist[$i]['qty'] - $model_update_order_stock->avl_qty;
//
//                                        $model_update_order_stock->order_id = $model->id;
//                                        $model_update_order_stock->avl_qty = 0;
//                                        if ($model_update_order_stock->save(false)) {
//
//                                            $model_update_order_stock2 = \common\models\OrderStock::find()->where(['route_id' => $route_id, 'product_id' => $datalist[$i]['product_id'], 'date(trans_date)' => date('Y-m-d')])->andFilterWhere(['>', 'avl_qty', 0])->orderBy('id')->one();
//                                            if ($model_update_order_stock2) {
//                                                $model_update_order_stock2->order_id = $model->id;
//                                                $model_update_order_stock2->avl_qty = $model_update_order_stock2->avl_qty - $remain_qty;
//                                                $model_update_order_stock2->save(false);
//                                            }
//                                        }
//                                    }
//                                }
//                                // end issue order stock
//
//                            }
//
//                        }
//                    }
//
//                    $model->order_total_amt = $order_total_all;
//                    $model->save(false);
//                    if ($model->issue_id > 0) {
//                        $model_issue = \backend\models\Journalissue::find()->where(['id' => $model->issue_id])->one();
//                        if ($model_issue) {
//                            $model_issue->status = 2;
//                            $model_issue->order_ref_id = $model->id;
//                            $model_issue->company_id = $company_id;
//                            $model_issue->branch_id = $branch_id;
//                            $model_issue->save(false);
//                        }
//                    }
//                }
//            }
//        }
//        //  array_push($data,['data'=>$req_data]);
//
//        return ['status' => $status, 'data' => $data];
//    }

}
