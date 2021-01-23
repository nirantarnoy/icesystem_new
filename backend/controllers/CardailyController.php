<?php

namespace backend\controllers;

use backend\models\StreamAssignSearch;
use Yii;
use backend\models\Cardaily;
use backend\models\CardailySearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * CardailyController implements the CRUD actions for Cardaily model.
 */
class CardailyController extends Controller
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
     * Lists all Cardaily models.
     * @return mixed
     */
    public function actionIndex()
    {
        // print_r(Yii::$app->request->queryParams);return;
        $route_type_id = null;
        $car_name = null;
        if (isset(Yii::$app->request->queryParams['CardailySearch'])) {
            $route_type_id = Yii::$app->request->queryParams['CardailySearch']['route_id'];
        }
        if (isset(Yii::$app->request->queryParams['CardailySearch'])) {
            $car_name = Yii::$app->request->queryParams['CardailySearch']['car_name'];
        }

        $car_search_text = \Yii::$app->request->post('car_name');

        $searchModel = new CardailySearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        //  echo $route_type_id;return;
        $query = \common\models\QueryCarRoute::find();
        if ($route_type_id != null) {
            $query = $query->andFilterWhere(['delivery_route_id' => $route_type_id]);
        }
        if ($car_name != null) {
            $query = $query->andFilterWhere(['OR', ['LIKE', 'name', $car_name], ['LIKE', 'code', $car_name]]);
        }
        $model_car = $query->all();

        return $this->render('_index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'model_car' => $model_car
        ]);
//        $searchModel = new CardailySearch();
//        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        // $dataProvider->pagination->pageSize = 1000;
        // $model = \backend\models\Cardaily::find()->all();

        // print_r($model);return;

//        return $this->render('_index', [
//            'searchModel' => $searchModel,
//            'dataProvider' => $dataProvider,
//        ]);
    }

    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    public function actionCreate()
    {
        $model = new Cardaily();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Cardaily model.
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
     * Deletes an existing Cardaily model.
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
     * Finds the Cardaily model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Cardaily the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Cardaily::findOne($id)) !== null) {
            return $model;
        }
        throw new NotFoundHttpException('The requested page does not exist.');
    }

    public function actionAddemp()
    {
        $t_date = null;
        $car_id = \Yii::$app->request->post('selected_car');
        $t_date = \Yii::$app->request->post('selected_date');
        $emp_id = \Yii::$app->request->post('line_car_emp_id');

        if ($t_date == null) {
            $t_date = date('Y-m-d');
        }
        // print_r($emp_id);return;
        if ($car_id) {
            if (count($emp_id) > 0) {
                for ($i = 0; $i <= count($emp_id) - 1; $i++) {
                    $this->checkOld($emp_id[$i], $car_id, $t_date);
                    $model = new \backend\models\Cardaily();
                    $model->car_id = $car_id;
                    $model->employee_id = $emp_id[$i];
                    $model->trans_date = $t_date;
                    $model->status = 1;
                    $model->save(false);
                }
            }
        }
        return $this->redirect(['index']);
    }

    public function checkOld($emp_id, $car_id, $t_date)
    {
        $model = \backend\models\Cardaily::find()->where(['car_id' => $car_id, 'employee_id' => $emp_id, 'date(trans_date)' => $t_date])->one();
        if ($model) {
            \backend\models\Cardaily::deleteAll(['car_id' => $car_id, 'employee_id' => $emp_id, 'date(trans_date)' => $t_date]);
        }
    }

    public function actionCopydailytrans()
    {
        $f_date = \Yii::$app->request->post('from_date');
        $t_date = \Yii::$app->request->post('to_date');
        $res = 0;

        // echo "ok";return;

        if ($f_date != '' && $t_date != '') {
            $from_date = null;
            $to_date = null;
            $a = explode('/', $f_date);
            if (count($a) > 1) {
                $from_date = $a[2] . '/' . $a[1] . '/' . $a[0];
            }
            $b = explode('/', $t_date);
            if (count($b) > 1) {
                $to_date = $b[2] . '/' . $b[1] . '/' . $b[0];
            }

            $model = \backend\models\Cardaily::find()->where(['AND', ['>=', 'date(trans_date)', $from_date], ['<=', 'date(trans_date)', $to_date]])->all();
            if ($model) {
                //foreach ($model as $value) {

                    foreach ($model as $line_value) {
                        if ($this->check_dup($line_value->employee_id,$line_value->car_id, date('Y-m-d', strtotime($to_date)))) {
                            continue;
                        }
                        $model_assign_line = new \backend\models\Cardaily();
                        $model_assign_line->car_id = $line_value->car_id;
                        $model_assign_line->employee_id = $line_value->employee_id;
                        $model_assign_line->status = 1;
                        $model_assign_line->trans_date = date('Y-m-d', strtotime($to_date));
                        if ($model_assign_line->save(false)) {
                            $res += 1;
                        }
                    }
                //}
            }
            if ($res > 0) {
                $session = Yii::$app->session;
                $session->setFlash('msg', 'บันทึกรายการเรียบร้อย');
                return $this->redirect(['cardaily/index']);
            }
        }
        return $this->redirect(['cardaily/index']);
    }
    public function check_dup($emp_id, $car_id , $t_date)
    {
        $model = 0;
        $model = \backend\models\Cardaily::find()->where(['employee_id' => $emp_id,'car_id'=>$car_id])->andFilterWhere(['AND', ['>=', 'date(trans_date)', $t_date], ['<=', 'date(trans_date)', $t_date]])->count();
        return $model;
    }
}
