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
}
