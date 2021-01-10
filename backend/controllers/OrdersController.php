<?php

namespace backend\controllers;

use backend\models\WarehouseSearch;
use Yii;
use backend\models\Orders;
use backend\models\OrdersSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * OrdersController implements the CRUD actions for Orders model.
 */
class OrdersController extends Controller
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
     * Lists all Orders models.
     * @return mixed
     */
    public function actionIndex()
    {
        $pageSize = \Yii::$app->request->post("perpage");
        $searchModel = new OrdersSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $dataProvider->pagination->pageSize = $pageSize;

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'perpage' => $pageSize,
        ]);
    }

    /**
     * Displays a single Orders model.
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
     * Creates a new Orders model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Orders();

        if ($model->load(Yii::$app->request->post())) {
            $prod_id = \Yii::$app->request->post('product_id');
            $qty = \Yii::$app->request->post('line_qty');
            $price = \Yii::$app->request->post('line_price');

            if($model->save()){
                if (count($prod_id) >0) {
                    for ($i = 0; $i <= count($prod_id) - 1; $i++) {
                        // echo $prod_id[0];return;
                        $modelline = new \backend\models\Orderline();
                        $modelline->order_id = $model->id;
                        $modelline->product_id = $prod_id[$i];
                        $modelline->qty = $qty[$i];
                        $modelline->price = $price[$i];
                        $modelline->line_total = $qty[$i] * $price[$i];
                        $modelline->status = 0;
                        $modelline->save(false);
                    }
                }
                $session = Yii::$app->session;
                $session->setFlash('msg', 'บันทึกรายการเรียบร้อย');
                return $this->redirect(['index']);
            }
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Orders model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $model_line = \backend\models\Orderline::find()->where(['order_id' => $id])->all();

        if ($model->load(Yii::$app->request->post())) {
            $prod_id = \Yii::$app->request->post('product_id');
            $qty = \Yii::$app->request->post('line_qty');
            $price = \Yii::$app->request->post('line_price');
            $removelist = Yii::$app->request->post('removelist');

            if($model->save()){
                if (count($prod_id) > 0) {
                    //echo "hello";return;
                    for ($i = 0; $i <= count($prod_id) - 1; $i++) {
                        //echo "hello";return;
                        $model_chk = \backend\models\Orderline::find()->where(['product_id' => $prod_id[$i],'order_id'=>$model->id])->one();
                        if ($model_chk) {
                            $model_chk->qty = $qty[$i];
                            $model_chk->price = $price[$i];
                            $model_chk->line_total = $qty[$i] * $price[$i];
                            $model_chk->save(false);
                        } else {
                            //echo "hello sd";return;
                            $modelline = new \backend\models\Orderline();
                            $modelline->order_id = $model->id;
                            $modelline->product_id = $prod_id[$i];
                            $modelline->qty = $qty[$i];
                            $modelline->price = $price[$i];
                            $modelline->line_total = $qty[$i] * $price[$i];
                            $modelline->status = 0;
                            $modelline->save(false);
                        }
                    }
                }
                if (count($removelist)) {
                    // count($removelist);return;
                    $rec_del = explode(',', $removelist);
//                    print_r($rec_del);return;
                    for ($i = 0; $i <= count($rec_del) - 1; $i++) {
                        \backend\models\Orderline::deleteAll(['id' => $rec_del[$i]]);
                    }

                }
                $session = Yii::$app->session;
                $session->setFlash('msg', 'บันทึกข้อมูลค้าเรียบร้อย');
                return $this->redirect(['index']);
            }
        }

        return $this->render('update', [
            'model' => $model,
            'model_line' => $model_line
        ]);
    }

    /**
     * Deletes an existing Orders model.
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
     * Finds the Orders model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Orders the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Orders::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }

    public function actionFindCustomer($id){
        $model = \common\models\Customer::find()->where(['delivery_route_id' => $id])->all();
        if ($model != null) {
            foreach ($model as $value) {
                echo "<option value='" . $value->id . "'>$value->name</option>";
            }
        } else {
            echo "<option></option>";
        }
    }
}
