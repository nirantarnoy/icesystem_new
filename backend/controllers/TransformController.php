<?php

namespace backend\controllers;

use backend\models\Transform;
use backend\models\TransformSearch;
use backend\models\WarehouseSearch;
use common\models\JournalIssue;
use Yii;
use backend\models\Unit;
use backend\models\UnitSearch;
use yii\base\BaseObject;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * UnitController implements the CRUD actions for Unit model.
 */
class TransformController extends Controller
{
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }


    public function actionIndex()
    {
        $pageSize = \Yii::$app->request->post("perpage");
        $searchModel = new TransformSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $dataProvider->query->andFilterWhere(['reason_id' => 4]);
        $dataProvider->setSort(['defaultOrder' => ['id' => SORT_DESC]]);
        $dataProvider->pagination->pageSize = $pageSize;

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'perpage' => $pageSize,
        ]);
    }


    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    public function actionCreate()
    {
        $model = new Transform();
        $company_id = 1;
        $branch_id = 1;

        if (!empty(\Yii::$app->user->identity->company_id)) {
            $company_id = \Yii::$app->user->identity->company_id;
        }
        if (!empty(\Yii::$app->user->identity->branch_id)) {
            $branch_id = \Yii::$app->user->identity->branch_id;
        }

        $default_warehouse = 6;
        if ($company_id == 1 && $branch_id == 2) {
            $default_warehouse = 5;
        }
        if ($model->load(Yii::$app->request->post())) {

            $from_prod = \Yii::$app->request->post('line_from_product');
            $from_qty = \Yii::$app->request->post('line_from_qty');
            $to_prod = \Yii::$app->request->post('line_to_product');
            $to_qty = \Yii::$app->request->post('line_to_qty');

            $x_date = explode('/', $model->trans_date);
            $sale_date = date('Y-m-d');
            if (count($x_date) > 1) {
                $sale_date = $x_date[2] . '/' . $x_date[1] . '/' . $x_date[0];
            }
            $model->journal_no = $model->getLastNo($sale_date, $company_id, $branch_id);
            $model->trans_date = date('Y-m-d', strtotime($sale_date));
            $model->status = 1;
            $model->company_id = $company_id;
            $model->branch_id = $branch_id;
            $model->reason_id = 4; // เบิกแปรสภาพ
            if ($model->save(false)) {
                // echo "no";return;
                if ($from_prod != null) {
                    for ($i = 0; $i <= count($from_prod) - 1; $i++) {
                        if ($from_prod[$i] == '') continue;
                        $model_line = new \backend\models\Journalissueline();
                        $model_line->issue_id = $model->id;
                        $model_line->product_id = $from_prod[$i];
                        $model_line->qty = $from_qty[$i];
                        $model_line->avl_qty = 0;
                        $model_line->sale_price = 0;
                        $model_line->status = 1;
                        if ($model_line->save()) {
                            $this->updateStock($from_prod[$i], $from_qty[$i], $default_warehouse, $model->journal_no, $company_id, $branch_id);
                            $this->updateStockIn($to_prod[$i], $to_qty[$i], $default_warehouse, $model->journal_no, $company_id, $branch_id);
                        }
                    }
                }

                $session = Yii::$app->session;
                $session->setFlash('msg', 'บันทึกข้อมูลเรียบร้อย');
                return $this->redirect(['index']);
            }
        }

        return $this->render('create', [
            'model' => $model,
        ]);
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
            $model_trans->activity_type_id = 20; // 6 issue cars
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

    public function updateStockIn($product_id, $qty, $wh_id, $journal_no, $company_id, $branch_id)
    {
        if ($product_id != null && $qty > 0) {
            $model_trans = new \backend\models\Stocktrans();
            $model_trans->journal_no = $journal_no;
            $model_trans->trans_date = date('Y-m-d H:i:s');
            $model_trans->product_id = $product_id;
            $model_trans->qty = $qty;
            $model_trans->warehouse_id = $wh_id;
            $model_trans->stock_type = 1; // 1 in 2 out
            $model_trans->activity_type_id = 21; // 6 issue cars
            $model_trans->company_id = $company_id;
            $model_trans->branch_id = $branch_id;
            if ($model_trans->save(false)) {
                $model = \backend\models\Stocksum::find()->where(['warehouse_id' => $wh_id, 'product_id' => $product_id])->one();
                if ($model) {
                    $model->qty = $model->qty + (int)$qty;
                    $model->save(false);
                }
            }
        }
    }

    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post())) {
            if ($model->save()) {
                $session = Yii::$app->session;
                $session->setFlash('msg', 'บันทึกข้อมูลเรียบร้อย');
                return $this->redirect(['index']);
            }
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    public function actionDelete($id)
    {
        $this->findModel($id)->delete();
        $session = Yii::$app->session;
        $session->setFlash('msg', 'ดำเนินการเรียบร้อย');
        return $this->redirect(['index']);
    }

    protected function findModel($id)
    {
        if (($model = Transform::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }
}
