<?php

namespace frontend\modules\api\controllers;

use yii\filters\VerbFilter;
use yii\web\Controller;


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
                    'orderlist' => ['POST']
                ],
            ],
        ];
    }

    public function actionAddorder()
    {
        $customer_id = null;
        $product_id = null;
        $qty = 0;
        $price = 0;
        $price_group_id = null;
        $status = false;

        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $req_data = \Yii::$app->request->getBodyParams();
        if ($req_data != null) {
            $customer_id = $req_data['customer_id'];
            $product_id = $req_data['product_id'];
            $qty = $req_data['qty'];
            $price = $req_data['price'];
            $price_group_id = $req_data['price_group_id'];
        }

        $data = [];
        if ($customer_id) {
            $sale_date = date('Y/m/d');

            $model = new \backend\models\Orders();
            $model->order_no = $model->getLastNo($sale_date);
            $model->order_date = date('Y-m-d H:i:s');
            $model->customer_id = 0;
            $model->sale_channel_id = 2;
            $model->issue_id = 0;
            $model->status = 1;
            if ($model->save(false)) {
                $model_line = new \backend\models\Orderline();
                $model_line->order_id = $model->id;
                $model_line->customer_id = $customer_id;
                $model_line->product_id = $product_id;
                $model_line->qty = $qty;
                $model_line->price = $price;
                $model_line->line_total = ($qty * $price);
                $model_line->price_group_id = $price_group_id;
                $model_line->status = 1;
                if ($model_line->save()) {
                    $status = true;
                }
            }
//            $model = \common\models\Customer::find()->where(['delivery_route_id'=>$route_id])->all();
//            if ($model) {
//                $status = true;
//                foreach ($model as $value) {
//                    array_push($data, [
//                        'id' => $value->id,
//                        'code' => $value->code,
//                        'name' => $value->name,
//                        'route_id' => $value->delivery_route_id
//                    ]);
//                }
//            }
        }

        return ['status' => $status, 'data' => $data];
    }

    public function actionList()
    {
        $status = false;
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $req_data = \Yii::$app->request->getBodyParams();
        $car_id = $req_data['car_id'];

        $data = [];
        if($car_id){
            $model = \common\models\Orders::find()->where(['car_ref_id'=>$car_id])->all();
            if ($model) {
                $status = true;
                foreach ($model as $value) {
                    array_push($data, [
                        'id' => $value->id,
                        'order_no' => $value->order_no,
                        'order_date' => $value->order_date,
                        'order_status' => $value->status
                    ]);
                }
            }
        }

        return ['status' => $status, 'data' => $data];
    }
}
