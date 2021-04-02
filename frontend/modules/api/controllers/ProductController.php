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
                    'list' => ['POST'],
                    'issuelist' => ['POST'],
                ],
            ],
        ];
    }

    public function actionList()
    {
        $customer_id = 0;
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $req_data = \Yii::$app->request->getBodyParams();
        $customer_id = $req_data['customer_id'];

        $data = [];
        $status = false;

        if ($customer_id) {
            $model = \common\models\QueryCustomerPrice::find()->where(['cus_id'=>$customer_id])->all();
           // $model = \common\models\QueryCustomerPrice::find()->all();
            if ($model) {
                $status = true;
                foreach ($model as $value) {
                    $product_info = \backend\models\Product::findInfo($value->product_id);
                    array_push($data, [
                        'id' => $value->product_id,
                        //'image' => 'http://192.168.1.120/icesystem/backend/web/uploads/images/products/' . $product_info->photo,
                          'image' => 'http://119.59.100.74/icesystem/backend/web/uploads/images/products/'.$product_info->photo,
                        'code' => $product_info->code,
                        'name' => $product_info->name,
                        'sale_price' => $value->sale_price,
                    ]);
                }
            }
        }


        return ['status' => $status, 'data' => $data];
    }
    public function actionIssuelist()
    {
        $customer_id = 0;
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $req_data = \Yii::$app->request->getBodyParams();
        $customer_id = $req_data['customer_id'];
        $route_id = $req_data['route_id'];
        $issue_id = $req_data['issue_id'];

        $data = [];
        $status = false;

        if ($customer_id != null && $route_id != null) {
            $model = \common\models\QuerySaleIssueProductPrice::find()->where(['cus_id'=>$customer_id,'delivery_route_id'=>$route_id])->all();
            // $model = \common\models\QueryCustomerPrice::find()->all();
            if ($model) {
                $status = true;
                foreach ($model as $value) {
                    array_push($data, [
                        'id' => $value->product_id,
                        //'image' => 'http://192.168.1.120/icesystem/backend/web/uploads/images/products/' . $product_info->photo,
                        'image' => 'http://119.59.100.74/icesystem/backend/web/uploads/images/products/'.$value->photo,
                        'code' => $value->code,
                        'name' => $value->name,
                        'sale_price' => $value->sale_price,
                    ]);
                }
            }
        }


        return ['status' => $status, 'data' => $data];
    }
}
