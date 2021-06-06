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
                    'warehouselist' =>['POST'],
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
    public function actionWarehouselist()
    {
        $company_id = 0;
        $branch_id = 0;
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $req_data = \Yii::$app->request->getBodyParams();
        $company_id = $req_data['company_id'];
        $branch_id = $req_data['branch_id'];

        $data = [];
        $status = false;

        if ($company_id) {
            $model = \common\models\Warehouse::find()->where(['company_id'=>$company_id,'branch_id'=>$branch_id])->all();
            // $model = \common\models\QueryCustomerPrice::find()->all();
            if ($model) {
                $status = true;
                foreach ($model as $value) {
                    // $product_info = \backend\models\Product::findInfo($value->product_id);
                    array_push($data, [
                        'id' => $value->id,
                        //'image' => 'http://192.168.1.120/icesystem/backend/web/uploads/images/products/' . $product_info->photo,
                        //'image' => 'http://119.59.100.74/icesystem/backend/web/uploads/images/products/' . $product_info->photo,
                        'code' => $value->code,
                        'name' => $value->name,
                    ]);
                }
            }
        }

        return ['status' => $status, 'data' => $data];
    }

}
