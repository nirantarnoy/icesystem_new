<?php

namespace frontend\modules\api\controllers;

use yii\filters\VerbFilter;
use yii\web\Controller;


class CustomerController extends Controller
{
    public $enableCsrfValidation = false;

    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'list' => ['POST'],
                ],
            ],
        ];
    }

    public function actionList()
    {
        $company_id = 1;
        $branch_id = 1;
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $req_data = \Yii::$app->request->getBodyParams();
        $route_id = $req_data['route_id'];
        $company_id = $req_data['company_id'];
        $branch_id = $req_data['branch_id'];

        $data = [];
        $status = false;
        if ($route_id) {
            $model = \common\models\Customer::find()->where(['delivery_route_id' => $route_id, 'company_id' => $company_id, 'branch_id' => $branch_id])->all();
            if ($model) {
                $status = true;
                foreach ($model as $value) {
                    array_push($data, [
                        'id' => $value->id,
                        'code' => $value->code,
                        'name' => $value->name,
                        'route_id' => $value->delivery_route_id
                    ]);
                }
            }
        }

        return ['status' => $status, 'data' => $data];
    }
}
