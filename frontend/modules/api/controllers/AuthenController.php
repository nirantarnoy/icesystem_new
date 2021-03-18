<?php

namespace frontend\modules\api\controllers;

use yii\filters\VerbFilter;
use yii\web\Controller;


class AuthenController extends Controller
{
    public $enableCsrfValidation = false;

    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'login' => ['POST'],
                    'orderlist' => ['POST']
                ],
            ],
        ];
    }
    public function actionLogin()
    {
        $username = '';
        $password = '';
        $status = false;
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        //$post = file_get_contents("php://input");
        $req_data = \Yii::$app->request->getBodyParams();
        if ($req_data != null) {
            $username = $req_data['username'];
            $password = $req_data['password'];
        }
        $data = [];
        if ($username != '' && $password != '') {
            $model = \common\models\User::find()->where(['username' => $username])->one();
            if ($model) {
                if ($model->validatePassword($password)) {
                    $model_info = \backend\models\Employee::find()->where(['id' => $model->employee_ref_id])->one();
                    if ($model_info) {
                        array_push($data, [
                                'username' => $username,
                                'user_id' => '' . $model->id,
                                'emp_code' => $model_info->code,
                                'emp_name' => $model_info->fname . ' ' . $model_info->lname,
                       //         'emp_photo' => 'http://119.59.100.74/icesystem/backend/web/uploads/images/employee/' . $model_info->photo
                                'emp_photo' => 'http://192.168.60.118/icesystem/backend/web/uploads/images/employee/' . $model_info->photo
                            ]
                        );
                        $status = true;
                    }

                }
            }
        }

        return ['status' => $status, 'data' => $data];
    }
//    public function actionLogin()
//    {
//        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
//        //$post = file_get_contents("php://input");
//        $req_data = \Yii::$app->request->getBodyParams();
//        $req_data2 = \Yii::$app->getRequest()->getBodyParams();
//
//        $req_data3 = \yii::$app->request->post();
//        // return $params;
//        // print_r($req_data3);
//        $username = $req_data;
//        $password = $req_data3;
//        $data = [];
//        array_push($data, [
//            'username' => 'It is ' . $username,
//            'password' => 'It is ' . $password
//
//        ]);
//        if ($username != '' && $password != '') {
//            $model = \common\models\User::find()->where(['username' => $username])->one();
//            if ($model) {
//                if ($model->validatePassword($password)) {
//                    $model_info = \backend\models\Employee::find()->where(['id' => $model->employee_ref_id])->one();
//                    if ($model_info) {
//                        array_push($data, [
//                                'username' => $username,
//                                'user_id' => '' . $model->id,]
//                        );
//                    }
//
//                }
//
//            }
//        }
//
//        return ['status' => true, 'data' => $data];
//    }
}
