<?php

namespace frontend\modules\api\controllers;

use yii\filters\VerbFilter;
use yii\web\Controller;


class ProductionController extends Controller
{
    public $enableCsrfValidation = false;

    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'addprodrec' => ['POST'],
                    'warehouselist' => ['POST'],
                    'addreprocesswip' => ['POST'],
                ],
            ],
        ];
    }

    public function actionAddprodrec()
    {
        $company_id = 0;
        $branch_id = 0;
        $product_id = 0;
        $warehouse_id = 0;
        $user_id = 0;
        $qty = 0;
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $req_data = \Yii::$app->request->getBodyParams();
        $company_id = $req_data['company_id'];
        $branch_id = $req_data['branch_id'];
        $product_id = $req_data['product_id'];
        $warehouse_id = $req_data['warehouse_id'];
        $qty = $req_data['qty'];
        $user_id = $req_data['user_id'];
        $production_type = $req_data['production_type'];

        $data = [];
        $status = false;

        if ($product_id && $warehouse_id && $qty) {
            $model_journal = new \backend\models\Stockjournal();
            $model_journal->journal_no = $model_journal->getLastNo($company_id, $branch_id);
            $model_journal->trans_date = date('Y-m-d');

            $model_journal->company_id = $company_id;
            $model_journal->branch_id = $branch_id;
            if ($model_journal->save(false)) {
                $model = new \backend\models\Stocktrans();
                $model->journal_no = $model_journal->journal_no;
                $model->journal_id = $model_journal->id;
                $model->trans_date = date('Y-m-d H:i:s');
                $model->product_id = $product_id;
                $model->qty = $qty;
                $model->warehouse_id = $warehouse_id;
                $model->stock_type = 1;
                $model->activity_type_id = 15; // 15 prod rec
                $model->production_type = $production_type;
                $model->company_id = $company_id;
                $model->branch_id = $branch_id;
                if ($model->save()) {
                    $status = 1;
                    $this->updateSummary($product_id, $warehouse_id, $qty);
                }
            }
            $model = \backend\models\Stockjournal::find()->where(['id' => $model_journal->id])->one();
            $model_line = \backend\models\Stocktrans::find()->where(['journal_id' => $model_journal->id])->all();

            $session = \Yii::$app->session;
            $session->setFlash('msg-index', 'slip_prodrec_index.pdf');
            $session->setFlash('after-save', true);

            //  $this->renderPartial('_printtoindex', ['model' => $model, 'model_line' => $model_line, 'change_amount' => 0]);
        }

        return ['status' => $status, 'data' => $data];
    }

    public function updateSummary($product_id, $wh_id, $qty)
    {
        if ($wh_id != null && $product_id != null && $qty > 0) {
            $model = \backend\models\Stocksum::find()->where(['warehouse_id' => $wh_id, 'product_id' => $product_id])->one();
            if ($model) {
                $model->qty = ($model->qty + (int)$qty);
                $model->save(false);
            } else {
                $model_new = new \backend\models\Stocksum();
                $model_new->warehouse_id = $wh_id;
                $model_new->product_id = $product_id;
                $model_new->qty = $qty;
                $model_new->save(false);
            }
        }
    }

    public function actionWarehouselist()
    {
        $company_id = 0;
        $branch_id = 0;
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $req_data = \Yii::$app->request->getBodyParams();
        $company_id = $req_data['company_id'];
        $branch_id = $req_data['branch_id'];

        $data = [];
        $status = false;

        if ($company_id) {
            $model = \common\models\Warehouse::find()->where(['company_id' => $company_id, 'branch_id' => $branch_id])->all();
            // $model = \common\models\QueryCustomerPrice::find()->all();
            if ($model) {
                $status = true;
                foreach ($model as $value) {
                    // $product_info = \backend\models\Product::findInfo($value->product_id);
                    array_push($data, [
                        'id' => $value->id,
                        //'image' => 'http://192.168.1.120/icesystem/backend/web/uploads/images/products/' . $product_info->photo,
                        //'image' => 'http://119.59.100.74/icesystem/backend/web/uploads/images/products/' . $product_info->photo,
                        'code' => $value->code,
                        'name' => $value->name,
                    ]);
                }
            }
        }

        return ['status' => $status, 'data' => $data];
    }

    public function actionAddreprocesswip()
    {
        $company_id = 0;
        $branch_id = 0;
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $req_data = \Yii::$app->request->getBodyParams();
        $product_id = $req_data['product_id'];
        // $warehouse_id = $req_data['warehouse_id'];
        $qty = $req_data['qty'];
        $reason = $req_data['reason'];
        $company_id = $req_data['company_id'];
        $branch_id = $req_data['branch_id'];

        $data = [];
        $status = false;

        if ($company_id != null && $product_id != null && $branch_id != null) {
            $model = new \common\models\IssueReprocess();
            $model->journal_no = 'IW-';
            $model->trans_date = date('Y-m-d H:i:s');
            $model->status = 1;
            $model->created_at = time();
            $model->created_by = 1;
            $model->reason = $reason;
            $model->company_id = $company_id;
            $model->branch_id = $branch_id;
            if ($model->save(false)) {
                $model_line = new \common\models\IssueReprocessLine();
                $model_line->issue_id = $model->id;
                $model_line->product_id = $product_id;
                $model_line->to_warehouse_id = 0;
                $model_line->qty = $qty;
                $model_line->status = 1;
                if ($model_line->save(false)) {
                    $this->updatestock($product_id, $qty, $company_id, $branch_id);
                    $status = 1;
                }
            }
        }

        return ['status' => $status, 'data' => $data];
    }

    public function updatestock($product_id, $qty, $company_id, $branch_id)
    {
        if ($product_id != null && $qty != null) {
            $warehouse_id = $this->findReprocesswarehouse($company_id, $branch_id);
            $model_trans = new \backend\models\Stocktrans();
            $model_trans->journal_no = 'IW-21';
            $model_trans->trans_date = date('Y-m-d H:i:s');
            $model_trans->product_id = $product_id;
            $model_trans->qty = $qty;
            $model_trans->warehouse_id = $warehouse_id;
            $model_trans->stock_type = 2; // 1 in 2 out
            $model_trans->activity_type_id = 20; // 6 issue car
            $model_trans->company_id = $company_id;
            $model_trans->branch_id = $branch_id;
            if ($model_trans->save(false)) {

                $model = \common\models\StockSum::find()->where(['company_id' => $company_id, 'branch_id' => $branch_id, 'product_id' => $product_id, 'warehouse_id' => $warehouse_id])->one();
                if ($model) {
                    $model->qty = ($model->qty - $qty);
                    $model->save(false);
                }
//                $model = \backend\models\Stocksum::find()->where(['warehouse_id' => $wh_id, 'product_id' => $product_id])->one();
//                if ($model) {
//                    $model->qty = $model->qty - (int)$qty;
//                    $model->save(false);
//                }
            }

        }
    }

    public function findReprocesswarehouse($company_id, $branch_id)
    {
        $id = 0;
        if ($company_id != null && $branch_id != null) {
            $model = \backend\models\Warehouse::find()->where(['company_id' => $company_id, 'branch_id' => $branch_id, 'is_reprocess' => 1])->one();
            if ($model) {
                $id = $model->id;
            }
        }
        return $id;
    }

}
