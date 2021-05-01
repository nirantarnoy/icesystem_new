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
                        $car_info = $this->getCar($model_info->id);
                        array_push($data, [
                                'username' => $username,
                                'user_id' => '' . $model->id,
                                'emp_code' => $model_info->code,
                                'emp_name' => $model_info->fname . ' ' . $model_info->lname,
                                'emp_photo' => 'http://119.59.100.74/icesystem/backend/web/uploads/images/employee/' . $model_info->photo,
                          //      'emp_photo' => 'http://192.168.1.120/icesystem/backend/web/uploads/images/employee/' . $model_info->photo,
                                'emp_route_id' => $car_info ==null?0:$car_info[0]['route_id'],
                                'emp_route_name' => $car_info ==null?0:$car_info[0]['route_name'],
                                'emp_car_id' => $car_info ==null?0:$car_info[0]['car_id'],
                                'emp_car_name' => $car_info ==null?0:$car_info[0]['car_name'],
                            ]
                        );
                        $status = true;
                    }

                }
            }
        }

        return ['status' => $status, 'data' => $data];
    }

    public function getCar($emp_id){
       $data = [];
       if($emp_id){
           $model = \common\models\CarDaily::find()->where(['employee_id'=>$emp_id,'date(trans_date)'=>date('Y-m-d')])->one();
           if($model){
               array_push($data,[
                   'car_id'=> $model->car_id,
                   'car_name' => \backend\models\Car::findName($model->car_id),
                   'route_id' => \backend\models\Car::findRouteId($model->car_id),
                   'route_name' => \backend\models\Car::findRouteName($model->car_id),
               ]);
           }
       }
       return $data;
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
