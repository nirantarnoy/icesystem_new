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
                ],
            ],
        ];
    }

    public function actionAddprodrec()
    {
        $product_id = 0;
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $req_data = \Yii::$app->request->getBodyParams();
        $product_id = $req_data['product_id'];

        $data = [];
        $status = false;

        if ($product_id) {

        }

        return ['status' => $status, 'data' => $data];
    }

}
