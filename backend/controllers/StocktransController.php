<?php

namespace backend\controllers;

use Yii;
use backend\models\Stocktrans;
use backend\models\StocktransSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * StocktransController implements the CRUD actions for Stocktrans model.
 */
class StocktransController extends Controller
{
   public $enableCsrfValidation = false;
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
     * Lists all Stocktrans models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new StocktransSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $dataProvider->setSort(['defaultOrder'=>['id'=>SORT_DESC]]);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Stocktrans model.
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
     * Creates a new Stocktrans model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $trans_date = \Yii::$app->request->post('prodrecdate');
        $wh_id = \Yii::$app->request->post('line_warehouse_id');
        $prodid = \Yii::$app->request->post('line_item_id');
        $qty = \Yii::$app->request->post('line_qty');

        if($wh_id != null){
             for($i=0;$i<=count($wh_id)-1;$i++){
                 $model = new \backend\models\Stocktrans();
                 $model->journal_no = $model->getLastNo();
                 $model->trans_date = date('Y-m-d H:i:s');
                 $model->product_id = $prodid[$i];
                 $model->qty = $qty[$i];
                 $model->warehouse_id = $wh_id[$i];
                 $model->stock_type = 1;
                 $model->activity_type_id = 15; // 15 prod rec
                 if($model->save()){
                    $this->updateSummary($prodid[$i],$wh_id[$i],$qty[$i]);
                 }
             }
        }

        return $this->redirect(['stocktrans/index']);
    }

    public function updateSummary($product_id, $wh_id, $qty){
        if($wh_id != null && $product_id != null && $qty > 0){
            $model = \backend\models\Stocksum::find()->where(['warehouse_id'=>$wh_id,'product_id'=>$product_id])->one();
            if($model){
                $model->qty = ($model->qty + (int)$qty);
                $model->save(false);
            }else{
                $model_new = new \backend\models\Stocksum();
                $model_new->warehouse_id = $wh_id;
                $model_new->product_id = $product_id;
                $model_new->qty = $qty;
                $model_new->save(false);
            }
        }
    }

    /**
     * Updates an existing Stocktrans model.
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
     * Deletes an existing Stocktrans model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Stocktrans model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Stocktrans the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Stocktrans::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
