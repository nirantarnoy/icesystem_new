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
                    'addtransfer' => ['POST'],
                ],
            ],
        ];
    }

    public function actionAddtransfer()
    {
        $status = false;
        $data = [];

        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $req_data = \Yii::$app->request->getBodyParams();

        $from_car_id = $req_data['from_car_id'];
        $to_route_id = $req_data['to_route_id'];
        $to_car_id = $req_data['to_car_id'];
        $data_list = $req_data['data'];
        $company_id = $req_data['company_id'];
        $branch_id = $req_data['branch_id'];
        $route_id = $req_data['route_id'];


        if ($from_car_id != null && $to_route_id != null && $company_id != null && $branch_id != null && $route_id != null) {
            //if ($data_list != null) {
//            $to_route_id = 0;
//            $model_to_route = \common\models\QueryCarRoute::find()->where(['id' => $to_car_id])->one();
//            if($model_to_route){
//                $to_route_id = $model_to_route->delivery_route_id;
//            }
            if($to_route_id){
                $trans_date = date('Y/m/d');
                $model = new \backend\models\Journaltransfer();
                $model->journal_no = $model->getLastNo2($trans_date, $company_id, $branch_id);
                $model->trans_date = date('Y-m-d H:i:s');
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
                            if ($model_line->save(false)) {

                                $model_from_order_stock = \common\models\OrderStock::find()->where(['route_id' => $route_id, 'product_id' => $data_list[$i]['product_id'], 'date(trans_date)' => date('Y-m-d')])->one();
                                if ($model_from_order_stock) {
                                    $model_from_order_stock->avl_qty = ($model_from_order_stock->avl_qty - $data_list[$i]['qty']);
                                    if ($model_from_order_stock->save(false)) {
                                        $this->createTransaction($data_list[$i]['product_id'], $data_list[$i]['qty'], $from_car_id, $model->journal_no, 2); // out
                                        $model_from_order_to_stock = \common\models\OrderStock::find()->where(['route_id' => $to_route_id, 'product_id' => $data_list[$i]['product_id'], 'date(trans_date)' => date('Y-m-d')])->one();
                                        if($model_from_order_to_stock){
                                            $model_from_order_to_stock->avl_qty = ($model_from_order_to_stock->avl_qty + $data_list[$i]['qty']);
                                            if($model_from_order_to_stock->save(false)){
                                                $this->createTransaction($data_list[$i]['product_id'], $data_list[$i]['qty'], $to_car_id, $model->journal_no, 1); // in
                                            }
                                        }else{
                                            $model_new_order_stock = new \common\models\OrderStock();
                                            $model_new_order_stock->product_id  = $data_list[$i]['product_id'];
                                            $model_new_order_stock->route_id  = $to_route_id;
                                            $model_new_order_stock->qty  = $data_list[$i]['qty'];
                                            $model_new_order_stock->avl_qty  = $data_list[$i]['qty'];
                                            $model_new_order_stock->trans_date = date('Y-m-d H:i:s');
                                            $model_new_order_stock->company_id = $company_id;
                                            $model_new_order_stock->branch_id = $branch_id;
                                            if($model_new_order_stock->save()){
                                                $this->createTransaction($data_list[$i]['product_id'], $data_list[$i]['qty'], $to_car_id, $model->journal_no, 1); // in
                                            }
                                        }
                                    }
                                }


                                //$this->updateIssue($data_list[$i]['issue_id'], $data_list[$i]['product_id'], $data_list[$i]['qty']);
                                $status = true;
                            }
                        }
                    }
                }
            }

            // }
        }
        return ['status' => $status, 'data' => count($data_list)];
    }

    public function createTransaction($product_id, $qty, $car_id, $journal_no, $stock_type)
    {
        if ($product_id != null && $qty > 0) {
            $model_trans = new \backend\models\Stocktrans();
            $model_trans->journal_no = $journal_no;
            $model_trans->trans_date = date('Y-m-d H:i:s');
            $model_trans->product_id = $product_id;
            $model_trans->qty = $qty;
            $model_trans->warehouse_id = 0;
            $model_trans->stock_type = $stock_type; // 1 in 2 out
            $model_trans->activity_type_id = 22; // 22 transfer car
            if ($model_trans->save(false)) {

            }
        }
    }

    public function updateIssue($issue_id, $product_id, $qty)
    {
        if ($issue_id) {
            $model = \common\models\JournalIssueLine::find()->where(['issue_id' => $issue_id, 'product_id' => $product_id])->one();
            if ($model) {
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
        if ($car_id) {
            //  $model = \common\models\JournalTransfer::find()->where(['delivery_route_id'=>$route_id])->all();
            $model = \common\models\JournalTransfer::find()->where(['to_car_id' => $car_id])->all();
            if ($model) {
                $status = true;
                foreach ($model as $value) {
                    //$model_line_avl_qty = \common\models\TransferLine::find()->where(['transfer_id'=>$value->id])->sum('avl_qty');
                    $model_line = \common\models\TransferLine::find()->where(['transfer_id' => $value->id])->all();
                    if ($model_line) {
                        foreach ($model_line as $value2) {
                            array_push($data, [
                                'transfer_id' => $value->id,
                                'journal_no' => $value->journal_no,
                                'to_route' => $value->order_target_id,
                                'from_car_id' => $value->from_car_id,
                                'from_car_name' => \backend\models\Car::findName($value->from_car_id),
                                'product_id' => $value2->product_id,
                                'product_name' => \backend\models\Product::findName($value2->product_id),
                                'qty' => $value2->avl_qty,
                                'sale_price' => $value2->sale_price,
                            ]);
                        }
                    }

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
        if ($car_id != null || $car_id != '') {
            //  $model = \common\models\JournalTransfer::find()->where(['delivery_route_id'=>$route_id])->all();
            $model = \common\models\JournalTransfer::find()->where(['from_car_id' => $car_id])->all();
            if ($model) {
                $status = true;
                foreach ($model as $value) {
                    $model_line_qty = \common\models\TransferLine::find()->where(['transfer_id' => $value->id])->sum('qty');

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
