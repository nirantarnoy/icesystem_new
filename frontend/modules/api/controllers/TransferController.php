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

        $from_car_id = $req_data['from_car_id'];
        $to_car_id = $req_data['to_car_id'];
        $data_list = $req_data['data'];
        $issue_id = $req_data['issue_id'];
//        $qty = $req_data['qty'];
//        $sale_price = $req_data['price'];

//        $order_id = \Yii::$app->request->post('transfer_order_id');
//        $order_target_id = \Yii::$app->request->post('order_target');
//        $line_prod = \Yii::$app->request->post('line_issue_product_id');
//        $line_qty = \Yii::$app->request->post('line_trans_qty');


        if ($from_car_id != null && $to_car_id != null && $issue_id != null) {
            //if ($data_list != null) {
                $trans_date = date('Y/m/d');
                $model = new \backend\models\Journaltransfer();
                $model->journal_no = $model->getLastNo($trans_date);
                $model->trans_date = date('Y-m-d');
                $model->order_ref_id = 1;
                $model->order_target_id = 1;
                $model->from_car_id = $from_car_id;
                $model->to_car_id = $to_car_id;
                $model->status = 1;
                if ($model->save(false)) {
                    if (count($data_list) > 0) {
                        for ($i = 0; $i <= count($data_list) - 1; $i++) {
                            if ($data_list[$i]['qty'] <= 0) continue;

                            $model_line = new \backend\models\Transferline();
                            $model_line->transfer_id = $model->id;
                            $model_line->product_id = $data_list[$i]['product_id'];
                            $model_line->sale_price = $data_list[$i]['price'];
                            $model_line->qty = $data_list[$i]['qty'];
                            $model_line->avl_qty = $data_list[$i]['qty'];
                            $model_line->status = 1;
                            if($model_line->save(false)){
                                //$this->updateIssue($issue_id[$i],$data_list[$i]['product_id'],$data_list[$i]['qty']);
                                $status = true;
                            }
                        }
                    }
                }
           // }
        }
        return ['status' => $status, 'data' => count($data_list)];
    }

    public function updateIssue($issue_id, $product_id ,$qty){
        if($issue_id){
            $model = \common\models\JournalIssueLine::find()->where(['issue_id'=>$issue_id,'product_id'=>$product_id])->one();
            if($model){
                $model->avl_qty = ($model->avl_qty - $qty);
                $model->save(false);
            }
        }
    }
    public function actionInlist()
    {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $req_data = \Yii::$app->request->getBodyParams();
        $car_id = $req_data['car_id'];

        $data = [];
        $status = false;
        if($car_id){
          //  $model = \common\models\JournalTransfer::find()->where(['delivery_route_id'=>$route_id])->all();
            $model = \common\models\JournalTransfer::find()->where(['to_car_id'=>$car_id])->all();
            if ($model) {
                $status = true;
                foreach ($model as $value) {
                    $model_line_avl_qty = \common\models\TransferLine::find()->where(['transfer_id'=>$value->id])->sum('avl_qty');
                    array_push($data, [
                        'transfer_id' => $value->id,
                        'journal_no' => $value->journal_no,
                        'to_route' => $value->order_target_id,
                        'from_car_id' => $value->from_car_id,
                        'from_car_name' => \backend\models\Car::findName($value->from_car_id),
                        'qty' => $model_line_avl_qty,
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
        $car_id = $req_data['car_id'];

        $data = [];
        $status = false;
        if($car_id != null || $car_id != ''){
            //  $model = \common\models\JournalTransfer::find()->where(['delivery_route_id'=>$route_id])->all();
            $model = \common\models\JournalTransfer::find()->where(['from_car_id'=>$car_id])->all();
            if ($model) {
                $status = true;
                foreach ($model as $value) {
                    $model_line_qty = \common\models\TransferLine::find()->where(['transfer_id'=>$value->id])->sum('qty');

                    array_push($data, [
                        'transfer_id' => $value->id,
                        'journal_no' => $value->journal_no,
                        'to_route' => $value->order_target_id,
                        'to_car_no' => \backend\models\Car::findName($value->to_car_id),
                        'to_order_no' => $value->order_ref_id,
                        'qty' => $model_line_qty
                    ]);
                }
            }
        }

        return ['status' => $status, 'data' => $data];
    }
}
