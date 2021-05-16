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
                    'addordertransfer' => ['POST'],
                    'list' => ['POST'],
                    'listbycustomer' => ['POST'],
                    'deleteorder' => ['POST'],
                    'deleteorderline' => ['POST'],
                    'deleteordercustomer' => ['POST'],
                    'customercredit' => ['POST'],
                    'closeorder' => ['POST']
                ],
            ],
        ];
    }

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
            $sale_time = date('H:i:s');
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
                            if ($payment_type_id != 3) {
                                $this->addpayment($has_order_id, $customer_id, ($qty * $price), $company_id, $branch_id, $payment_type_id);
                            }

                            //  }

                            $order_total_all += $model_line->line_total;
                            $status = true;

                            $model_update_issue_line = \common\models\JournalIssueLine::find()->where(['issue_id' => $issue_id, 'product_id' => $product_id])->one();
                            if ($model_update_issue_line) {
                                $model_update_issue_line->avl_qty = $model_update_issue_line->avl_qty - $qty;
                                $model_update_issue_line->save(false);
                            }
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
                    $this->registerissue($has_order_id, $issue_id, $company_id, $branch_id);
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

                        $model_update_issue_line = \common\models\JournalIssueLine::find()->where(['issue_id' => $issue_id, 'product_id' => $product_id])->one();
                        if ($model_update_issue_line) {
                            $model_update_issue_line->avl_qty = $model_update_issue_line->avl_qty - $qty;
                            $model_update_issue_line->save(false);
                        }
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
            $model = \common\models\Orders::find()->where(['date(order_date)' => $order_date, 'order_channel_id' => $route_id, 'car_ref_id' => $car_id])->one();
            $res = $model;
        }
        return $res;
    }

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
        $model = new \backend\models\Paymenttrans();
        $model->trans_no = $model->getLastNo($company_id, $branch_id);
        $model->trans_date = date('Y-m-d H:i:s');
        $model->order_id = $order_id;
        $model->status = 0;
        $model->company_id = $company_id;
        $model->branch_id = $branch_id;
        if ($model->save(false)) {
            if ($customer_id != null) {

                $model_line = new \backend\models\Paymenttransline();
                $model_line->trans_id = $model->id;
                $model_line->customer_id = $customer_id;
                $model_line->payment_method_id = 8;
                $model_line->payment_term_id = 0;
                $model_line->payment_date = date('Y-m-d H:i:s');
                $model_line->payment_amount = $payment_type_id == 1 ? $amount : 0;
                $model_line->total_amount = 0;
                $model_line->order_ref_id = $order_id;
                $model_line->payment_type_id = $payment_type_id;
                $model_line->status = 1;
                $model_line->doc = '';
                if ($model_line->save(false)) {

                }

            }
        }
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
            $sale_time = date('H:i:s');

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
            $model = \common\models\QueryApiOrderDaily::find()->where(['customer_id' => $customer_id])->andFilterWhere(['id' => $order_id])->andFilterWhere(['>', 'qty', 0])->all();
            if ($model) {
                $status = true;
                foreach ($model as $value) {
                    array_push($data, [
                        'order_id' => $value->id,
                        'order_no' => $value->order_no,
                        'order_date' => $value->order_date,
                        'order_status' => $value->status,
                        'line_id' => $value->line_id,
                        'customer_id' => $value->customer_id,
                        'customer_name' => $value->customer_name,
                        'customer_code' => $value->customer_code,
                        'product_id' => $value->product_id,
                        'product_code' => $value->product_code,
                        'product_name' => $value->product_name,
                        'qty' => $value->qty,
                        'price' => $value->price,
                        'price_group_id' => ''
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
                $model_return_issue = \backend\models\Journalissueline::find()->where(['product_id' => $model_data->product_id, 'issue_id' => $model_data->issue_ref_id])->andFilterWhere(['>', 'qty', 0])->one();
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
                            $model_check_has_issue->status = 2;
                            $model_check_has_issue->save(false);
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
        $status = false;
        $route_id = null;
        $order_date = null;

        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $req_data = \Yii::$app->request->getBodyParams();
        $route_id = $req_data['route_id'];
        $order_date = $req_data['order_date'];

        $trans_date = date('Y/m/d');
        $t_date = null;
        $exp_order_date = explode(' ', $order_date);
        if ($exp_order_date != null) {
            if (count($exp_order_date) > 1) {
                $x_date = explode('-', $exp_order_date[0]);
                if (count($x_date) > 1) {
                    $t_date = $x_date[0] . "/" . $x_date[1] . "/" . $x_date[2];
                }
            }
        }
        if ($t_date != null) {
            $trans_date = $t_date;
        }

        $data = [];
        $res = 0;
        if ($route_id != null && $order_date != null) {
         //   $model = \backend\models\Orders::find()->where(['order_channel_id' => $route_id, 'date(order_date)' => $f_date])->andFilterWhere(['<', 'status', 100])->one();
            $model = \backend\models\Orders::find()->where(['order_channel_id' => $route_id, 'date(order_date)' => $trans_date])->one();

            if ($model) {
//                $data = ['route_id'=>$route_id,'data'=>$trans_date];
//                $data = ['route_id'=>$route_id,'data'=>$order_date];
                $model_close = \common\models\QuerySaleFinished::find()->where(['id'=>$model->id])->all();
//                if ($model_close) {
//                    foreach ($model_close as $value) {
//                        if ($value->qty <= 0 || $value->qty == null) continue;
//                        $model = new \backend\models\Stocktrans();
//                        $model->journal_no = '';
//                        $model->trans_date = date('Y-m-d H:i:s');
//                        $model->product_id = $value->product_id;
//                        $model->qty = $value->qty;
//                        $model->warehouse_id = 5;
//                        $model->stock_type = 1;
//                        $model->activity_type_id = 7; // 1 prod rec 2 issue car
//                        if ($model->save()) {
//                            $this->updateSummary($value->product_id, 5, $value->qty);
//                            $res += 1;
//                        }
//                    }
//                    if ($res) {
//                        $this->updateOrderStatus($model->id);
//                    }
//                }
            }
        }

        return ['status' => $status, 'data' => $data];
    }

    public function updateSummary($product_id, $wh_id, $qty)
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
                $model_new->save(false);
            }
        }
    }

    public function updateOrderStatus($order_id)
    {
        if ($order_id) {
            $model = \backend\models\Orders::find()->where(['id' => $order_id])->one();
            if ($model) {
                $model->status = 100;
                $model->save();
            }
        }
    }
}
