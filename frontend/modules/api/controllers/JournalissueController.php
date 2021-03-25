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
        $issue_date = $req_data['issue_date'];

        $data = [];
        $status = false;
        if($route_id){
            $trans_date = date('Y/m/d');
            $t_date = null;
            $exp_order_date = explode(' ', $issue_date);
            if ($exp_order_date != null) {
                if (count($exp_order_date) > 1) {
                    $x_date = explode('-', $exp_order_date[0]);
                    if (count($x_date) > 1) {
                        $t_date = $x_date[0] . "/" . $x_date[1] . "/" . $x_date[2];
                    }
                }
            }
            if ($t_date != null) {
                $trans_date = $t_date;
            }
            $model = \common\models\JournalIssue::find()->one();
            $model = \common\models\JournalIssue::find()->where(['delivery_route_id'=>$route_id,'date(trans_date)'=>$trans_date])->one();
            if ($model) {
                $model_line = \common\models\JournalIssueLine::find()->where(['issue_id'=>$model->id])->all();
                if($model_line){
                    $status = true;
                    foreach ($model_line as $value) {
                        $product_image = \backend\models\Product::findPhoto($value->product_id);
                        array_push($data, [
                            'id' => $value->id,
                            'issue_id' => $value->issue_id,
                            'issue_no' => \backend\models\Journalissue::findNum($value->issue_id),
                            'product_id' => $value->product_id,
                            'product_name' => \backend\models\Product::findName($value->product_id),
                            'image' => 'http://192.168.1.120/icesystem/backend/web/uploads/images/products/'.$product_image,
                            'issue_qty' => $value->qty,
                            'avl_qty' => $value->avl_qty,
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
