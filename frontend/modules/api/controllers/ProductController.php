<?php

namespace frontend\modules\api\controllers;

use yii\filters\VerbFilter;
use yii\web\Controller;


class ProductController extends Controller
{
    public $enableCsrfValidation = false;

    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'list' => ['GET'],
                ],
            ],
        ];
    }

    public function actionList()
    {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $req_data = \Yii::$app->request->getBodyParams();
       // $student_id = $req_data['customer_id'];

        $data = [];
        $status = false;
        $model = \common\models\Product::find()->where(['<>', 'id', 23])->all();
        if ($model) {
            $status = true;
            foreach ($model as $value) {
                array_push($data, [
                    'id' => $value->id,
                    'image' => 'http://192.168.1.120/icesystem/backend/web/uploads/images/products/' . $value->photo,
                    //  'image' => 'http://119.59.100.74/icesystem/backend/web/uploads/images/products/'.$value->photo,
                    'code' => $value->code,
                    'name' => $value->name,
                    'sale_price' => $value->sale_price,
                ]);
            }
        }

        return ['status' => $status, 'data' => $data];
    }
}
