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
        $customer_id = null;
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $req_data = \Yii::$app->request->getBodyParams();
        $customer_id = $req_data['customer_id'];

        $data = [];
        $status = false;
        if ($customer_id) {
            // $model = \common\models\JournalIssue::find()->one();
            $model = \common\models\QuerySalePaySummary::find()->where(['customer_id' => $customer_id])->andfilterWhere(['>' ,'remain_amount', 0])->all();
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
        $pay_date = null;

        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $req_data = \Yii::$app->request->getBodyParams();
        $order_id = $req_data['order_id'];
        $payment_channel_id = $req_data['payment_channel_id'];
        $customer_id = $req_data['customer_id'];
        $pay_amount = $req_data['pay_amount'];
        $pay_date = $req_data['pay_date'];

        $xdate = explode('-', trim($pay_date));
        $t_date = date('Y-m-d');
        if (count($xdate) > 1) {
            $t_date = $xdate[2] . '/' . $xdate[1] . '/' . $xdate[0];
        }
        $data = [];
        $status = false;
        if ($customer_id && $order_id) {
          //  $t_date = date('Y-m-d');

            $xdate = explode('-', trim($pay_date));
            $t_date = date('Y-m-d');
            if (count($xdate) > 1) {
                $t_date = $xdate[2] . '-' . $xdate[1] . '-' . $xdate[0];
            }

            $check_record = $this->checkHasRecord($customer_id, $t_date);
            if($check_record != null){
                //if(count($check_record) > 0){
                    $model_line = new \common\models\PaymentReceiveLine();
                    $model_line->payment_receive_id = $check_record->id;
                    $model_line->order_id = $order_id;
                    $model_line->payment_amount = $pay_amount;
                    $model_line->payment_channel_id = $payment_channel_id;
                    $model_line->status = 1;
                    if($model_line->save(false)){
                        $status = true;
                        $this->updatePaymenttransline($customer_id, $order_id, $pay_amount, $payment_channel_id);
                    }
               // }
            }else{
                $model = new \backend\models\Paymentreceive();
                $model->trans_date = date('Y-m-d', strtotime($t_date));//date('Y-m-d H:i:s');
                $model->customer_id = $customer_id;
                $model->journal_no = $model->getLastNo(date('Y-m-d'));
                $model->status = 1;
                if($model->save()){
                    $model_line = new \common\models\PaymentReceiveLine();
                    $model_line->payment_receive_id = $model->id;
                    $model_line->order_id = $order_id;
                    $model_line->payment_amount = $pay_amount;
                    $model_line->payment_channel_id = $payment_channel_id;
                    $model_line->status = 1;
                    if($model_line->save(false)){
                        $status = true;
                        $this->updatePaymenttransline($customer_id, $order_id, $pay_amount, $payment_channel_id);
                    }
                }
            }

        }
       // array_push($data,['date'=>$t_date]);

        return ['status' => $status, 'data' => $data];
    }
    public function checkHasRecord($customer_id, $trans_date){
        $model = \common\models\PaymentReceive::find()->where(['date(trans_date)'=>$trans_date,'customer_id'=>$customer_id])->one();
        return $model;
    }
    public function updatePaymenttransline($customer_id, $order_id, $pay_amt, $pay_type)
    {
        if ($customer_id != null && $order_id != null && $pay_amt > 0) {
            //     $model = \backend\models\Paymenttransline::find()->where(['customer_id'=>$customer_id,'order_ref_id'=>$order_id])->andFilterWhere(['payment_method_id'=>2])->one();
            $model = \backend\models\Paymenttransline::find()->innerJoin('payment_method', 'payment_trans_line.payment_method_id=payment_method.id')->where(['payment_trans_line.customer_id' => $customer_id, 'payment_trans_line.order_ref_id' => $order_id])->andFilterWhere(['payment_method.pay_type' => 2])->one();
            if ($model) {
                if ($pay_type == 0) {
                    $model->payment_amount = ($model->payment_amount - (float)$pay_amt);
                } else {
                    $model->payment_amount = ($model->payment_amount + (float)$pay_amt);
                }

                $model->save(false);
            }
        }
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
