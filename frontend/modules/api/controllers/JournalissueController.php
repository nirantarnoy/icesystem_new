<?php

namespace frontend\modules\api\controllers;

use yii\filters\VerbFilter;
use yii\web\Controller;


class JournalissueController extends Controller
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
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $req_data = \Yii::$app->request->getBodyParams();
        $route_id = $req_data['route_id'];

        $data = [];
        $status = false;
        if($route_id){
            $model = \common\models\JournalIssue::find()->where(['delivery_route_id'=>$route_id,'status'=>1])->one();
            if ($model) {
                $model_line = \common\models\JournalIssueLine::find()->where(['issue_id'=>$model->id])->all();
                if($model_line){
                    $status = true;
                    foreach ($model_line as $value) {
                        array_push($data, [
                            'id' => $value->id,
                            'issue_id' => $value->journal_issue_id,
                            'issue_no' => \backend\models\Journalissue::findNum($value->journal_issue_id),
                            'product_id' => $value->product_id,
                            'product_name' => \backend\models\Product::findName($value->product_id),
                            'issue_qty' => $value->qty,
                            'price' => 0,
                            'product_image' => '',
                        ]);
                    }
                }

            }
        }

        return ['status' => $status, 'data' => $data];
    }
}
