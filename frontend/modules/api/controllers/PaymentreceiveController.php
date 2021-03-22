<?php

namespace frontend\modules\api\controllers;

use yii\filters\VerbFilter;
use yii\web\Controller;


class PaymentreceiveController extends Controller
{
    public $enableCsrfValidation = false;

    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'list' => ['POST'],
                    'addpay'=>['POST'],
                    'deletepay' => ['POST']
                ],
            ],
        ];
    }

    public function actionList()
    {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $req_data = \Yii::$app->request->getBodyParams();
        $customer_id = $req_data['customer_id'];

        $data = [];
        $status = false;
        if ($customer_id) {
            // $model = \common\models\JournalIssue::find()->one();
            $model = \common\models\QuerySalePaySummary::find()->where(['customer_id' => $customer_id])->one();
            if ($model) {
                $status = true;
                foreach ($model as $value) {
                    array_push($data, [
                        'order_id' => $value->order_id,
                        'order_no' => \backend\models\Orders::getNumber($value->order_id),
                        'customer_id' => $value->customer_id,
                        'customer_code' => \backend\models\Customer::findName($value->customer_id),
                        'order_date' => $value->order_date,
                        'line_total' => $value->line_total,
                        //'payment_amount' => $value->payment_amount,
                        'remain_amount' => $value->remain_amount,
                        //'pay_type' => $value->pay_type,
                    ]);
                }

            }
        }

        return ['status' => $status, 'data' => $data];
    }
    public function actionAddpay()
    {
        $order_id = 0;
        $payment_channel_id = 0;
        $customer_id = 0;
        $pay_amount = 0;

        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $req_data = \Yii::$app->request->getBodyParams();
        $order_id = $req_data['order_id'];
        $payment_channel_id = $req_data['payment_channel_id'];
        $customer_id = $req_data['customer_id'];
        $pay_amount = $req_data['pay_amount'];

        $data = [];
        $status = false;
        if ($customer_id) {
            $t_date = date('Y-m-d');
            $check_record = $this->checkHasRecord($customer_id, $t_date);
            if($check_record != null){
                if(count($check_record) > 0){
                    $model_line = new \common\models\PaymentReceiveLine();
                    $model_line->payment_receive_id = $check_record->id;
                    $model_line->order_id = $order_id;
                    $model_line->payment_amount = $pay_amount;
                    $model_line->payment_channel_id = $payment_channel_id;
                    $model_line->status = 1;
                    if($model_line->save()){
                        $status = true;
                    }
                }
            }else{
                $model = new \common\models\PaymentReceive();
                $model->trans_date = date('Y-m-d H:i:s');
                $model->customer_id = $customer_id;
                $model->journal_no = $model->getLastNo();
                $model->status = 1;
                if($model->save()){
                    $model_line = new \common\models\PaymentReceiveLine();
                    $model_line->payment_receive_id = $model->id;
                    $model_line->order_id = $order_id;
                    $model_line->payment_amount = $pay_amount;
                    $model_line->payment_channel_id = $payment_channel_id;
                    $model_line->status = 1;
                    if($model_line->save()){
                        $status = true;
                    }
                }
            }

        }

        return ['status' => $status, 'data' => $data];
    }
    public function checkHasRecord($customer_id, $trans_date){
        $model = \common\models\PaymentReceive::find()->where(['date(trans_date)'=>$trans_date,'customer_id'=>$customer_id])->one();
        return $model;
    }
    public function actionDeletepay()
    {
        $status = false;
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $req_data = \Yii::$app->request->getBodyParams();
        $id = $req_data['id'];

        $data = [];
        if ($id) {
            if (\common\models\PaymentReceiveLine::deleteAll(['id' => $id])) {
                $status = true;
            }
        }

        return ['status' => $status, 'data' => $data];
    }
}
