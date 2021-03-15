<?php

namespace frontend\modules\api\controllers;

use yii\web\Controller;


class AuthenController extends Controller
{

    public function actionLogin()
    {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        //$post = file_get_contents("php://input");
        $req_data = \Yii::$app->request->getBodyParams();
        $req_data2 = \Yii::$app->getRequest()->getBodyParams();

        $req_data3 = \yii::$app->request->post();
        // return $params;
        // print_r($req_data3);
        $username = $req_data;
        $password = $req_data3;
        $data = [];
        array_push($data, [
            'username' => 'It is ' . $username,
            'password' => 'It is ' . $password

        ]);
        if ($username != '' && $password != '') {
            $model = \common\models\User::find()->where(['username' => $username])->one();
            if ($model) {
                if ($model->validatePassword($password)) {
                    $model_info = \backend\models\Employee::find()->where(['id' => $model->employee_ref_id])->one();
                    if ($model_info) {
                        array_push($data, [
                                'username' => $username,
                                'user_id' => '' . $model->id,]
                        );
                    }

                }

            }
        }

        return ['status' => true, 'data' => $data];
    }
}