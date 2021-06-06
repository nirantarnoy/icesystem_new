<?php

namespace frontend\modules\api\controllers;

use yii\filters\VerbFilter;
use yii\web\Controller;


class JournalissueController extends Controller
{
    public $enableCsrfValidation = false;

    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'list' => ['POST'],
                    'list2' => ['POST'],
                    'checkopen' => ['POST'],
                    'issueconfirm' => ['POST'],
                    'issueconfirm2' => ['POST'],
                ],
            ],
        ];
    }

    public function actionList()
    {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $req_data = \Yii::$app->request->getBodyParams();
        $route_id = $req_data['route_id'];
        // $car_id = $req_data['car_id'];
        $issue_date = $req_data['issue_date'];

        $data = [];
        $status = false;
        if ($route_id) {
            $trans_date = date('Y/m/d');
            $t_date = null;
            $exp_order_date = explode(' ', $issue_date);
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
            // $model = \common\models\JournalIssue::find()->one();
            $model = \common\models\JournalIssue::find()->where(['delivery_route_id' => $route_id, 'date(trans_date)' => $trans_date])->andFilterWhere(['<=', 'status', 2])->one();
            if ($model) {
                $model_line = \common\models\JournalIssueLine::find()->where(['issue_id' => $model->id])->all();
                if ($model_line) {
                    $status = true;
                    foreach ($model_line as $value) {
                        if ($value->qty == null || $value->qty <= 0) continue;
                        $product_image = \backend\models\Product::findPhoto($value->product_id);
                        array_push($data, [
                            'id' => $value->id,
                            'issue_id' => $value->issue_id,
                            'issue_no' => \backend\models\Journalissue::findNum($value->issue_id),
                            'product_id' => $value->product_id,
                            'product_name' => \backend\models\Product::findName($value->product_id),
                            'image' => 'http://119.59.100.74/icesystem/backend/web/uploads/images/products/' . $product_image,
                            'issue_qty' => $value->qty,
                            'avl_qty' => $value->avl_qty,
                            'price' => 0,
                            'product_image' => '',
                            'status' => $model->status
                        ]);
                    }
                }
            }
        }

        return ['status' => $status, 'data' => $data];
    }

    public function actionList2()
    {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $req_data = \Yii::$app->request->getBodyParams();
        $route_id = $req_data['route_id'];
        // $car_id = $req_data['car_id'];
        $issue_date = $req_data['issue_date'];

        $data = [];
        $status = false;
        if ($route_id) {
            $trans_date = date('Y/m/d');
            $t_date = null;
            $exp_order_date = explode(' ', $issue_date);
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
            // $model = \common\models\JournalIssue::find()->one();
            $model = \common\models\OrderStock::find()->select(['id', 'issue_id', 'product_id', 'SUM(qty) as qty', 'SUM(avl_qty) as avl_qty'])->where(['route_id' => $route_id, 'date(trans_date)' => $trans_date])->groupBy(['product_id'])->all();
            if ($model) {
                $status = true;
                foreach ($model as $value) {
                    if ($value->qty == null || $value->qty <= 0) continue;
                    $product_image = \backend\models\Product::findPhoto($value->product_id);
                    array_push($data, [
                        'id' => $value->id,
                        'issue_id' => $value->issue_id,
                        'issue_no' => \backend\models\Journalissue::findNum($value->issue_id),
                        'product_id' => $value->product_id,
                        'product_name' => \backend\models\Product::findName($value->product_id),
                        'image' => 'http://119.59.100.74/icesystem/backend/web/uploads/images/products/' . $product_image,
                        'issue_qty' => $value->qty,
                        'avl_qty' => $value->avl_qty,
                        'price' => 0,
                        'product_image' => '',
                        'status' => 2
                    ]);
                }

            }
        }

        return ['status' => $status, 'data' => $data];
    }

    public function actionIssueconfirm()
    {
        $issue_id = null;
        $user_id = null;
        $route_id = null;
        $company_id = 1;
        $branch_id = 1;
        $status = 0;
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $req_data = \Yii::$app->request->getBodyParams();
        //$route_id = $req_data['route_id'];
        $issue_id = $req_data['issue_id'];
        $user_id = $req_data['user_id'];
        $company_id = $req_data['company_id'];
        $branch_id = $req_data['branch_id'];

        $default_wh = 6;
        if ($company_id == 1 && $branch_id == 2) {
            $default_wh = 5;
        }

        $data = [];
        if ($issue_id != null && $user_id != null) {
            //$data = ['issue_id'=> $issue_id,'user_id'=>$user_id];
            $model_update_issue_status = \common\models\JournalIssue::find()->where(['id' => $issue_id])->one();
            $model_issue_line = \backend\models\Journalissueline::find()->where(['issue_id' => $issue_id])->all();
            foreach ($model_issue_line as $val2) {
                if ($val2->qty <= 0 || $val2->qty == null) continue;

                $model_order_stock = new \common\models\OrderStock();
                $model_order_stock->issue_id = $issue_id;
                $model_order_stock->product_id = $val2->product_id;
                $model_order_stock->qty = $val2->qty;
                $model_order_stock->used_qty = 0;
                $model_order_stock->avl_qty = $val2->qty;
                $model_order_stock->order_id = 0;
                $model_order_stock->route_id = $model_update_issue_status->delivery_route_id;
                $model_order_stock->trans_date = date('Y-m-d');
                $model_order_stock->company_id = $company_id;
                $model_order_stock->branch_id = $branch_id;
                if ($model_order_stock->save(false)) {

                    if ($model_update_issue_status) {
                        if ($model_update_issue_status->status != 2) {
                            $model_update_issue_status->status = 2;
                            if ($model_update_issue_status->save(false)) {

                                $status = 1;
                            }
                        }

                    }
                    $this->updateStock($val2->product_id, $val2->qty, $default_wh, '', $company_id, $branch_id);
                }
            }

            if ($status == 1) {
                $model_update_order = \backend\models\Orders::find()->where(['delivery_route_id' => $route_id, 'date(order_date)' => strtotime(date('Y-m-d')), 'status' => 1])->one();
                if ($model_update_order) {
                    $model_update_order->status = 99;
                    $model_update_order->save();
                }
            }
//            $model = \backend\models\Journalissue::find()->where(['id' => $issue_id])->one();
//            if ($model) {
//                $model->status = 2; //close
//                $model->user_confirm = $user_id;
//                if ($model->save()) {
//                    $status = 1;
//                }
//            }
        }
        return ['status' => $status, 'data' => $data];
    }

    public function checkhasOrderStock($route_id, $issue_id)
    {
        $res = 0;
        if ($route_id) {
            $res = \common\models\OrderStock::find()->where(['issue_id' => $issue_id, 'route_id' => $route_id])->count();
        }
        return $res;
    }

    public function actionIssueconfirm2()
    {
        $issue_id = null;
        $user_id = null;
        $route_id = null;
        $company_id = 1;
        $branch_id = 1;
        $status = 0;
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $req_data = \Yii::$app->request->getBodyParams();
        $route_id = $req_data['route_id'];
        $issue_id = $req_data['issue_id'];
        $user_id = $req_data['user_id'];
        $company_id = $req_data['company_id'];
        $branch_id = $req_data['branch_id'];

        $default_wh = 6;
        if ($company_id == 1 && $branch_id == 2) {
            $default_wh = 5;
        }

        $data = [];
        if ($issue_id != null && $user_id != null) {
            //$data = ['issue_id'=> $issue_id,'user_id'=>$user_id];
            $has_order_stock = $this->checkhasOrderStock($route_id, $issue_id);
            if ($has_order_stock == 0) {
                $model_update_issue_status = \common\models\JournalIssue::find()->where(['id' => $issue_id])->one();
                $model_issue_line = \backend\models\Journalissueline::find()->where(['issue_id' => $issue_id])->all();
                foreach ($model_issue_line as $val2) {
                    if ($val2->qty <= 0 || $val2->qty == null) continue;

                    if ($this->ismasterproduct($val2->product_id)) { // T1 T2 ตัดสตํอกอย่างเดียวไม่ขึ้นรถ
                        $this->updateStock($val2->product_id, $val2->qty, $default_wh, $model_update_issue_status->journal_no, $company_id, $branch_id);
                        continue;
                    }

                    $model_order_stock = new \common\models\OrderStock();
                    $model_order_stock->issue_id = $issue_id;
                    $model_order_stock->product_id = $val2->product_id;
                    $model_order_stock->qty = $val2->qty;
                    $model_order_stock->used_qty = 0;
                    $model_order_stock->avl_qty = $val2->qty;
                    $model_order_stock->order_id = 0;
                    $model_order_stock->route_id = $model_update_issue_status->delivery_route_id;
                    $model_order_stock->trans_date = date('Y-m-d');
                    $model_order_stock->company_id = $company_id;
                    $model_order_stock->branch_id = $branch_id;
                    if ($model_order_stock->save(false)) {
                        //  $this->updateStock($prod_id[$i], $line_qty[$i], $default_warehouse, $model->journal_no, $company_id, $branch_id);
                        if ($model_update_issue_status) {
                            if ($model_update_issue_status->status != 2) {
                                $model_update_issue_status->status = 2;
                                if ($model_update_issue_status->save(false)) {
                                    $status = 1;
                                }
                            }
                        }
                        // $this->updateStock($val2->product_id, $val2->qty, $default_wh, '', $company_id, $branch_id);
                        $this->updateStock($val2->product_id, $val2->qty, $default_wh, $model_update_issue_status->journal_no, $company_id, $branch_id);
                    }
                }

                if ($status == 1) {
                    $model_update_order = \backend\models\Orders::find()->where(['order_channel_id' => $route_id, 'date(order_date)' => date('Y-m-d'), 'status' => 1])->one();
                    if ($model_update_order) {
                        $model_update_order->status = 99;
                        $model_update_order->save(false);
                    }
                }
            }

//            $model = \backend\models\Journalissue::find()->where(['id' => $issue_id])->one();
//            if ($model) {
//                $model->status = 2; //close
//                $model->user_confirm = $user_id;
//                if ($model->save()) {
//                    $status = 1;
//                }
//            }
        }
        return ['status' => $status, 'data' => $data];
    }

    public function updateStock($product_id, $qty, $wh_id, $journal_no, $company_id, $branch_id)
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
            $model_trans->company_id = $company_id;
            $model_trans->branch_id = $branch_id;
            if ($model_trans->save(false)) {
                $model = \backend\models\Stocksum::find()->where(['warehouse_id' => $wh_id, 'product_id' => $product_id])->one();
                if ($model) {
                    $model->qty = $model->qty - (int)$qty;
                    $model->save(false);
                }
            }
        }
    }

    public function ismasterproduct($product_id)
    {
        $res = 0;
        if ($product_id) {
            $model = \backend\models\Product::find()->where(['id' => $product_id])->one();
            if ($model) {
                $res = $model->master_product == null ? 0 : $model->master_product;
            }
        }
        return $res;
    }

    public function actionCheckopen()
    {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $req_data = \Yii::$app->request->getBodyParams();
        $route_id = $req_data['route_id'];
        // $car_id = $req_data['car_id'];
        $issue_date = $req_data['issue_date'];

        $data = [];
        $status = false;
        if ($route_id) {
            $trans_date = date('Y/m/d');
            $t_date = null;
            $exp_order_date = explode(' ', $issue_date);
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
            // $model = \common\models\JournalIssue::find()->one();
            $model = \common\models\JournalIssue::find()->where(['delivery_route_id' => $route_id, 'date(trans_date)' => $trans_date, 'status' => 1])->one();
            if ($model) {
                $model_line = \common\models\JournalIssueLine::find()->where(['issue_id'=>$model->id])->all();
                if($model_line){
                    foreach ($model_line as $value){
                        if($value->qty <= 0)continue;
                        array_push($data, [
                            'has_record' => 1,
                            'issue_id' => $model->id,
                            'product_id' => $value->product_id,
                            'code' => \backend\models\Product::findCode($value->product_id),
                            'name' => \backend\models\Product::findName($value->product_id),
                            'qty' => $value->qty,
                            'status' => $model->status,
                        ]);
                    }
                }
//                array_push($data, [
//                    'has_record' => 1,
//                    'issue_id' => $model->id,
//                    'status' => $model->status,
//                ]);
            } else {
                array_push($data, [
                    'has_record' => 0,
                    'issue_id' => 0,
                    'status' => 0,
                ]);
            }
        }
        return ['status' => $status, 'data' => $data];
    }
}
