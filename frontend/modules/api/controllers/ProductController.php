<?php

namespace frontend\modules\api\controllers;

use yii\web\Controller;


class ProductController extends Controller
{

    public function actionProductlist()
    {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
//        $req_data = \Yii::$app->request->getBodyParams();
//        $student_id = $req_data['student_id'];

        $data = [];
        $status = false;
        $model = \common\models\Product::find()->all();
        if ($model) {
            $status = true;
            foreach ($model as $value) {
                array_push($data, [
                    'id' => $value->id,
                    'image' => $value->photo,
                    'code' => $value->code,
                    'name' => $value->name,
                    'sale_price' => $value->sale_price,
                ]);
            }
        }

        return ['status' => $status, 'data' => $data];
    }
}
