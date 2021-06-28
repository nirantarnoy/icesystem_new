<?php

namespace frontend\modules\api\controllers;

use yii\filters\VerbFilter;
use yii\web\Controller;

date_default_timezone_set('Asia/Bangkok');

class PlanController extends Controller
{
    public $enableCsrfValidation = false;

    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'addplan' => ['POST'],
                    'listplan' => ['POST'],
                    'deleteplan' => ['POST'],
                    'updateplan' => ['POST'],

                ],
            ],
        ];
    }

    public function actionAddplan()
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
            $company_id = $req_data['company_id'];
            $branch_id = $req_data['branch_id'];
            $datalist = $req_data['data'];
        }

        $data = [];

        if ($customer_id && $route_id && $car_id) {
            //  $sale_date = date('Y/m/d');
            $sale_date = date('Y/m/d');

            $sale_time = date('H:i:s');
            $order_total_all = 0;
            $has_order = $this->hasPlan($sale_date, $route_id, $car_id);
            if ($has_order != null) {
                $has_order_id = $has_order->id;
                if ($has_order_id) {
                    if (count($datalist) > 0) {
                        for ($i = 0; $i <= count($datalist) - 1; $i++) {
                            if ($datalist[$i]['qty'] <= 0) continue;

                            // $price_group_id = $this->findCustomerpricgroup($customer_id, $datalist[$i]['product_id'], $route_id);

                            $model_line_trans = new \backend\models\Planline();
                            $model_line_trans->plan_id = $has_order_id;
                            $model_line_trans->product_id = $datalist[$i]['product_id'];
                            $model_line_trans->qty = $datalist[$i]['qty'];
                            $model_line_trans->status = 1;
                            if ($model_line_trans->save(false)) {}


                        }
                    }
                }
            } else {
                $model = new \backend\models\Plan();
                $model->order_no = $model->getLastNo($sale_date, $company_id, $branch_id);
                // $model->order_date = date('Y-m-d H:i:s', strtotime($sale_date . ' ' . $sale_time));
                $model->trans_date = date('Y-m-d H:i:s');
                $model->customer_id = 0;
                $model->route_id = $route_id;
                $model->car_id = $car_id;
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

                            $model_line_trans = new \backend\models\Planline();
                            $model_line_trans->plan_id = $model->id;
                            $model_line_trans->product_id = $datalist[$i]['product_id'];
                            $model_line_trans->qty = $datalist[$i]['qty'];
                            $model_line_trans->status = 1;
                            if ($model_line_trans->save(false)) {

                                // end issue order stock
                            }
                        }
                    }
                }
            }
        }
        //  array_push($data,['data'=>$req_data]);

        return ['status' => $status, 'data' => $data];
    }



    public function hasPlan($order_date, $route_id, $car_id)
    {
        $order_date = date('Y-m-d');
        $res = null;
        if ($route_id && $car_id) {
            $model = \common\models\Plan::find()->where(['date(trans_date)' => $order_date, 'route_id' => $route_id, 'car_id' => $car_id, 'status' => 1])->one();
            $res = $model;
        }
        return $res;
    }

    public function actionListplan()
    {
        $status = false;
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $req_data = \Yii::$app->request->getBodyParams();
        $car_id = $req_data['car_id'];
        $api_date = $req_data['plan_date'];

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

            $model = \common\models\Plan::find()->where(['car_id' => $car_id, 'date(trans_date)' => $sale_date])->all();
            // $model = \common\models\Orders::find()->where(['id'=>131])->all();
            //  $model = \common\models\Orders::find()->where(['car_ref_id' => $car_id])->all();
            if ($model) {
                $status = true;
                foreach ($model as $value) {
                    array_push($data, [
                        'id' => $value->id,
                        'tran_no' => $value->journal_no,
                        'trans_date' => $value->trans_date,
                        'route_id' => $value->route_id,
                        'route_name' => '',
                        'customer_id' => $value->customer_id,
                        'customer_name' => \backend\models\Customer::findName($value->customer_id),
                        'status' => $value->status,
                    ]);
                }
            }
        }
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


}
