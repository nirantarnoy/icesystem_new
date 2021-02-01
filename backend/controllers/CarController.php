<?php

namespace backend\controllers;

use backend\models\Customer;
use backend\models\WarehouseSearch;
use Yii;
use backend\models\Car;
use backend\models\CarSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;

/**
 * CarController implements the CRUD actions for Car model.
 */
class CarController extends Controller
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
     * Lists all Car models.
     * @return mixed
     */
    public function actionIndex()
    {
        $pageSize = \Yii::$app->request->post("perpage");
        $searchModel = new CarSearch();
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
     * Displays a single Car model.
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
     * Creates a new Car model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Car();
        if ($model->load(Yii::$app->request->post())) {
            $emp_list = $model->emp_id;
            // print_r($emp_list);return;
            $photo = UploadedFile::getInstance($model, 'photo');
            if (!empty($photo)) {
                $photo_name = time() . "." . $photo->getExtension();
                $photo->saveAs(Yii::getAlias('@backend') . '/web/uploads/images/car/' . $photo_name);
                $model->photo = $photo_name;
            }
            if ($model->save()) {
                if (count($emp_list) > 0) {
                    for ($i = 0; $i <= count($emp_list) - 1; $i++) {
                        $model_check = \common\models\CarEmp::find()->where(['car_id' => $model->id,'emp_id' => $emp_list[$i]])->one();
                        if ($model_check) {
                        } else {
                            $model_x = new \common\models\CarEmp();
                            $model_x->car_id = $model->id;
                            $model_x->emp_id = $emp_list[$i];
                            $model_x->status = 1;
                            $model_x->save();
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

    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $emp_select_list = [];
        $model_emp = \common\models\CarEmp::find()->where(['car_id' => $id])->all();
        foreach ($model_emp as $xx){
            array_push($emp_select_list,$xx->emp_id);
        }
//        print_r($model_emp);return;
        if ($model->load(Yii::$app->request->post())) {
            $photo = UploadedFile::getInstance($model, 'photo');
            if (!empty($photo)) {
                $photo_name = time() . "." . $photo->getExtension();
                $photo->saveAs(Yii::getAlias('@backend') . '/web/uploads/images/car/' . $photo_name);
                $model->photo = $photo_name;
            }
            $emp_list = $model->emp_id;
            if ($model->save()) {
                if ($emp_list != null) {
                    for ($i = 0; $i <= count($emp_list) - 1; $i++) {
                        $model_check = \common\models\CarEmp::find()->where(['car_id' => $model->id,'emp_id' => $emp_list[$i]])->one();
                        if ($model_check) {
                        } else {
                            $model_x = new \common\models\CarEmp();
                            $model_x->car_id = $model->id;
                            $model_x->emp_id = $emp_list[$i];
                            $model_x->status = 1;
                            $model_x->save();
                        }
                    }
                }
                $session = Yii::$app->session;
                $session->setFlash('msg', 'บันทึกข้อมูลเรียบร้อย');
                return $this->redirect(['index']);
            }
        }

        return $this->render('update', [
            'model' => $model,
            'emp_select_list' => $emp_select_list
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
        if (($model = Car::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }
    public function actionDeletephoto()
    {
        $id = \Yii::$app->request->post('delete_id');
        if ($id) {
            $photo = $this->getPhotoName($id);
            if ($photo != '') {
                if (unlink('../web/uploads/images/car/' . $photo)) {
                    Car::updateAll(['photo' => ''], ['id' => $id]);
                }
            }

        }
        return $this->redirect(['car/update', 'id' => $id]);
    }
    public function getPhotoName($id)
    {
        $photo_name = '';
        if ($id) {
            $model = Car::find()->where(['id' => $id])->one();
            if ($model) {
                $photo_name = $model->photo;
            }
        }
        return $photo_name;
    }
}
