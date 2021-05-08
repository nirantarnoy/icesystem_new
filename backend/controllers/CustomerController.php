<?php

namespace backend\controllers;

use backend\models\CustomersalehistorySearch;
use backend\models\CustomersalepaySearch;
use backend\models\DeliveryrouteSearch;
use backend\models\Product;
use Yii;
use backend\models\Customer;
use backend\models\CustomerSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;

/**
 * CustomerController implements the CRUD actions for Customer model.
 */
class CustomerController extends Controller
{
    public $enableCsrfValidation = false;
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST','GET'],
                ],
            ],
        ];
    }

    /**
     * Lists all Customer models.
     * @return mixed
     */
    public function actionIndex()
    {
        $pageSize = 50;
        $pageSize = \Yii::$app->request->post("perpage");
        $searchModel = new CustomerSearch();
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
     * Displays a single Customer model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        $searchModel = new CustomersalehistorySearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $dataProvider->query->andFilterWhere(['customer_id'=>$id]);

        $searchModel2 = new CustomersalepaySearch();
        $dataProvider2 = $searchModel2->search(Yii::$app->request->queryParams);
        $dataProvider2->query->andFilterWhere(['customer_id'=>$id]);

        return $this->render('view', [
            'model' => $this->findModel($id),
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'searchModel2' => $searchModel2,
            'dataProvider2' => $dataProvider2,
        ]);
    }

    /**
     * Creates a new Customer model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Customer();

        if ($model->load(Yii::$app->request->post())) {
//            $group = \Yii::$app->request->post('customer_group_id');
//            $route = \Yii::$app->request->post('delivery_route_id');
//            $status = \Yii::$app->request->post('status');
//            $cust_type = \Yii::$app->request->post('customer_type_id');
//
//            $model->customer_group_id = $group;
//            $model->delivery_route_id = $route;
//            $model->customer_type_id = $cust_type;
//            $model->status = $status;
            $photo = UploadedFile::getInstance($model, 'shop_photo');
            if (!empty($photo)) {
                $photo_name = time() . "." . $photo->getExtension();
                $photo->saveAs(Yii::getAlias('@backend') . '/web/uploads/images/customer/' . $photo_name);
                $model->shop_photo = $photo_name;
            }

            $model->code = $model->getLastNo();
            $model->sort_name = $model->sort_name == null?'':$model->sort_name;
            if($model->save(false)){
                $session = Yii::$app->session;
                $session->setFlash('msg', 'บันทึกข้อมูลเรียบร้อย');
                return $this->redirect(['index']);
            }
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Customer model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post())) {
//            $group = \Yii::$app->request->post('customer_group_id');
//            $route = \Yii::$app->request->post('delivery_route_id');
//            $status = \Yii::$app->request->post('status');
//            $cust_type = \Yii::$app->request->post('customer_type_id');
//
//            $model->customer_group_id = $group;
//            $model->delivery_route_id = $route;
//            $model->customer_type_id = $cust_type;
//            $model->status = $status;
            $photo = UploadedFile::getInstance($model, 'shop_photo');
            if (!empty($photo)) {
                $photo_name = time() . "." . $photo->getExtension();
                $photo->saveAs(Yii::getAlias('@backend') . '/web/uploads/images/customer/' . $photo_name);
                $model->shop_photo = $photo_name;
            }
            $model->sort_name = $model->sort_name == null?'':$model->sort_name;
            if($model->save(false)){
                $session = Yii::$app->session;
                $session->setFlash('msg', 'บันทึกข้อมูลเรียบร้อย');
                return $this->redirect(['index']);
            }
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Customer model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();
        $session = Yii::$app->session;
        $session->setFlash('msg', 'ดำเนินการเรียบร้อย');
        return $this->redirect(['index']);
    }

    /**
     * Finds the Customer model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Customer the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Customer::findOne($id)) !== null) {
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
                if (unlink('../web/uploads/images/customer/' . $photo)) {
                    Customer::updateAll(['shop_photo' => ''], ['id' => $id]);
                }
            }

        }
        return $this->redirect(['customer/update', 'id' => $id]);
    }
    public function getPhotoName($id)
    {
        $photo_name = '';
        if ($id) {
            $model = Customer::find()->where(['id' => $id])->one();
            if ($model) {
                $photo_name = $model->shop_photo;
            }
        }
        return $photo_name;
    }
}
