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
        $status  = false;
        $data = [];

        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $req_data = \Yii::$app->request->getBodyParams();

        $car_id = $req_data['target_car_id'];
        $data_list = $req_data['data'];
//        $qty = $req_data['qty'];
//        $sale_price = $req_data['price'];

//        $order_id = \Yii::$app->request->post('transfer_order_id');
//        $order_target_id = \Yii::$app->request->post('order_target');
//        $line_prod = \Yii::$app->request->post('line_issue_product_id');
//        $line_qty = \Yii::$app->request->post('line_trans_qty');


//        if ($car_id) {
//            if ($product_id != null) {
//                $trans_date = date('d/m/Y');
//                $model = new \backend\models\Journaltransfer();
//                $model->journal_no = $model->getLastNo($trans_date);
//                $model->trans_date = date('Y-m-d');
//                $model->order_ref_id = 1;
//                $model->order_target_id = 1;
//                $model->status = 1;
//                if ($model->save(false)) {
//                    if (count($product_id) > 0) {
//                        for ($i = 0; $i <= count($product_id) - 1; $i++) {
//                            if ($qty[$i] <= 0) continue;
//
//                            $model_line = new \backend\models\Transferline();
//                            $model_line->transfer_id = $model->id;
//                            $model_line->product_id = $product_id[$i];
//                            $model_line->sale_price = $sale_price[$i];
//                            $model_line->qty = $qty[$i];
//                            $model_line->status = 1;
//                            if($model_line->save(false)){
//                                $status = true;
//                            }
//                        }
//                    }
//                }
//            }
//        }
        return ['status' => $status, 'data' => $data_list];
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
