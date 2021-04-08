<?php

namespace backend\controllers;

use backend\models\BranchSearch;
use Yii;
use backend\models\Adjustment;
use backend\models\AdjustmentSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * AdjustmentController implements the CRUD actions for Adjustment model.
 */
class AdjustmentController extends Controller
{
    /**
     * {@inheritdoc}
     */
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

    /**
     * Lists all Adjustment models.
     * @return mixed
     */
    public function actionIndex()
    {
        $pageSize = \Yii::$app->request->post("perpage");
        $searchModel = new AdjustmentSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $dataProvider->setSort(['defaultOrder' => ['id' => SORT_DESC]]);
        $dataProvider->pagination->pageSize = $pageSize;

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'perpage' => $pageSize,
        ]);
    }

    /**
     * Displays a single Adjustment model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Adjustment model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Adjustment();

        if ($model->load(Yii::$app->request->post())) {
            $product = \Yii::$app->request->post('line_product_id');
            $warehouse = \Yii::$app->request->post('line_warehouse_id');
            $qty = \Yii::$app->request->post('line_qty');
            $stock_type = \Yii::$app->request->post('line_stock_type');

            $x_date = explode('/', $model->trans_date);
            $sale_date = date('Y-m-d');
            if (count($x_date) > 1) {
                $sale_date = $x_date[2] . '/' . $x_date[1] . '/' . $x_date[0];
            }

            $model->journal_no = '';
            $model->trans_date = date('Y-m-d', strtotime($sale_date));
            if($model->save()){
                if($product != null){
                    for($i=0;$i<=count($product)-1;$i++){
                        $model_line = new \backend\models\Stocktrans();
                        $model_line->journal_stock_id = $model->id;
                        $model_line->trans_date = date('Y-m-d H:i:s');
                        $model_line->product_id = $product[$i];
                        $model_line->warehouse_id = $warehouse[$i];
                        $model_line->qty = $qty[$i];
                        $model_line->stock_type = $stock_type[$i];
                        $model_line->activity_type_id = 6;
                        if($model_line->save(false)){
                            $model_stock = \backend\models\Stocksum::find()->where(['warehouse_id'=>$warehouse[$i],'product_id'=>$product[$i]])->one();
                            if($model_stock){
                                if($stock_type[$i] == 1){
                                    $model_stock->qty = $model_stock->qty + (int)$qty[$i];
                                }else if($stock_type[$i] == 2){
                                    $model_stock->qty = $model_stock->qty - (int)$qty[$i];
                                }
                                    $model_stock->save(false);
                            }
                        }
                    }
                }
                return $this->redirect(['index']);
            }
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Adjustment model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Adjustment model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        if(\backend\models\Stocktrans::deleteAll(['journal_stock_id'=>$id])){
            $this->findModel($id)->delete();
        }

        return $this->redirect(['index']);
    }

    /**
     * Finds the Adjustment model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Adjustment the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Adjustment::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
