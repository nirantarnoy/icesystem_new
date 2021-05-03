<?php
namespace backend\models;
use common\models\LoginLog;
use Yii;
use yii\db\ActiveRecord;
date_default_timezone_set('Asia/Bangkok');

class User extends \common\models\User
{
//    public function behaviors()
//    {
//        return [
//            'timestampcdate'=>[
//                'class'=> \yii\behaviors\AttributeBehavior::className(),
//                'attributes'=>[
//                    ActiveRecord::EVENT_BEFORE_INSERT=>'created_at',
//                ],
//                'value'=> time(),
//            ],
//            'timestampudate'=>[
//                'class'=> \yii\behaviors\AttributeBehavior::className(),
//                'attributes'=>[
//                    ActiveRecord::EVENT_BEFORE_INSERT=>'updated_at',
//                ],
//                'value'=> time(),
//            ],
////            'timestampcby'=>[
////                'class'=> \yii\behaviors\AttributeBehavior::className(),
////                'attributes'=>[
////                    ActiveRecord::EVENT_BEFORE_INSERT=>'created_by',
////                ],
////                'value'=> Yii::$app->user->identity->id,
////            ],
////            'timestamuby'=>[
////                'class'=> \yii\behaviors\AttributeBehavior::className(),
////                'attributes'=>[
////                    ActiveRecord::EVENT_BEFORE_UPDATE=>'updated_by',
////                ],
////                'value'=> Yii::$app->user->identity->id,
////            ],
//            'timestampupdate'=>[
//                'class'=> \yii\behaviors\AttributeBehavior::className(),
//                'attributes'=>[
//                    ActiveRecord::EVENT_BEFORE_UPDATE=>'updated_at',
//                ],
//                'value'=> time(),
//            ],
//        ];
//    }
    public function findName($id){
        $model = User::find()->where(['id'=>$id])->one();
        return $model!= null?$model->username:'';
    }
    public function findGroup($id){
        $model = User::find()->where(['id'=>$id])->one();
        return $model!= null?$model->group_id:0;
    }

    public function findLogintime($id){
        $model = LoginLog::find()->where(['user_id'=>$id])->one();
        return $model!= null?date('H:i',strtotime($model->login_date)):'';
    }
    public function findLogindatetime($id){
        $c_date = date('Y-m-d');
        $model = LoginLog::find()->where(['user_id'=>$id, 'status'=> 1])->andFilterWhere(['date(login_date)' => $c_date])->one();
        return $model!= null?date('Y-m-d H:i:s',strtotime($model->login_date)):'';
    }
}
