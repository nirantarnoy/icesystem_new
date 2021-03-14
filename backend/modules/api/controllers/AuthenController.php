<?php

namespace backend\modules\api\controllers;

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
            'username' =>  'It is '.$username,
            'password' => 'It is '.$password

        ]);
        if ($username != '' && $password != '') {
            $model = \common\models\User::find()->where(['username' => $username])->one();
            if ($model) {
                if ($model->validatePassword($password)) {
                    $model_info = \backend\models\Employee::find()->where(['id' => $model->employee_ref_id])->one();
                    if ($model_info) {
                        array_push($data, [
                                'username' => $username,
                                'user_id' => '' . $model->id
//                                'student_no' => $model_info->student_no,
//                                'student_id' => $model_info->id,
//                                'image' => 'http://app.sst.ac.th/uploads/images/student/' . $model_info->photo,
//                                //'image' => '',
//                                'fname' => $model_info->first_name,
//                                'lname' => $model_info->last_name,
//                                'gender' => \backend\helpers\GenderType::getTypeById($model_info->gender),
//                                'nickname' => '' . $model_info->nick_name,
//                                'phone' => '' . $model_info->phone2,
//                                'email' => '' . $model_info->email,
//                                'dob' => '',//.date('d/m/Y', strtotime($model_info->dob)),
//                                //'edu_grade' => '',
//                                'edu_grade' => \backend\models\Classroom::findName($model_info->edu_grade),
//                                'idToken' => '',
//                                'expiresIn' => '90']
                        );
                    }

                }

            }
        }

        return ['status' => true, 'data' => $data];
    }
}
