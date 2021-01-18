<?php

namespace backend\controllers;

use backend\models\WarehouseSearch;
use Yii;
use backend\models\Car;
use backend\models\CarSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * CarController implements the CRUD actions for Car model.
 */
class PosController extends Controller
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
            if($model){

            }

        }
    }

}
