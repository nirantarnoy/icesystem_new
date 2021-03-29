<?php

namespace frontend\modules\api\controllers;

use yii\filters\VerbFilter;
use yii\web\Controller;


class TransferController extends Controller
{
    public $enableCsrfValidation = false;
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'outlist' => ['POST'],
                    'inlist' => ['POST'],
                    'addtransfer'=> ['POST'],
                ],
            ],
        ];
    }
    public function actionAddtransfer(){
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $req_data = \Yii::$app->request->getBodyParams();
        $route_id = $req_data['route_id'];
        
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
    }
    public function actionInlist()
    {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $req_data = \Yii::$app->request->getBodyParams();
        $route_id = $req_data['route_id'];

        $data = [];
        $status = false;
        if($route_id){
          //  $model = \common\models\JournalTransfer::find()->where(['delivery_route_id'=>$route_id])->all();
            $model = \common\models\JournalTransfer::find()->all();
            if ($model) {
                $status = true;
                foreach ($model as $value) {
                    array_push($data, [
                        'transfer_id' => $value->id,
                        'journal_no' => $value->journal_no,
                        'to_route' => $value->order_target_id,
                        'to_car_no' => "001",
                        'to_order_no' => $value->order_ref_id
                    ]);
                }
            }
        }

        return ['status' => $status, 'data' => $data];
    }

    public function actionOutlist()
    {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $req_data = \Yii::$app->request->getBodyParams();
        $route_id = $req_data['route_id'];

        $data = [];
        $status = false;
        if($route_id){
            //  $model = \common\models\JournalTransfer::find()->where(['delivery_route_id'=>$route_id])->all();
            $model = \common\models\JournalTransfer::find()->all();
            if ($model) {
                $status = true;
                foreach ($model as $value) {
                    array_push($data, [
                        'transfer_id' => $value->id,
                        'journal_no' => $value->journal_no,
                        'to_route' => $value->order_target_id,
                        'to_car_no' => "001",
                        'to_order_no' => $value->order_ref_id
                    ]);
                }
            }
        }

        return ['status' => $status, 'data' => $data];
    }
}
