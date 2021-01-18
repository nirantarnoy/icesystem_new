<?php

namespace backend\controllers;

use backend\models\WarehouseSearch;
use Yii;
use backend\models\Car;
use backend\models\CarSearch;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * CarController implements the CRUD actions for Car model.
 */
class PosController extends Controller
{
   public $enableCsrfValidation = false;
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['login', 'error'],
                        'allow' => true,
                    ],
                    [
                        'actions' => ['logout', 'index','getcustomerprice'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
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
        return $this->render('index', [
           'model' => null
        ]);
    }

    public function actionGetcustomerprice(){
        $data = [];
        $customer_id = \Yii::$app->request->post('customer_id');
        if($customer_id){
            $model = \common\models\QueryCustomerPrice::find()->where(['customer_id'=>$customer_id])->all();
            if($model != null){
                foreach ($model as $value){
                    array_push($data,['product_id'=>$value->product_id,'sale_price'=>$value->sale_price]);
                }
            }

        }
        echo json_encode($data);
    }

}
