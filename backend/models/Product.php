<?php
namespace backend\models;
use Yii;
use yii\db\ActiveRecord;
date_default_timezone_set('Asia/Bangkok');

class Product extends \common\models\Product
{
    public function behaviors()
    {
        return [
            'timestampcdate'=>[
                'class'=> \yii\behaviors\AttributeBehavior::className(),
                'attributes'=>[
                    ActiveRecord::EVENT_BEFORE_INSERT=>'created_at',
                ],
                'value'=> time(),
            ],
            'timestampudate'=>[
                'class'=> \yii\behaviors\AttributeBehavior::className(),
                'attributes'=>[
                    ActiveRecord::EVENT_BEFORE_INSERT=>'updated_at',
                ],
                'value'=> time(),
            ],
            'timestampcby'=>[
                'class'=> \yii\behaviors\AttributeBehavior::className(),
                'attributes'=>[
                    ActiveRecord::EVENT_BEFORE_INSERT=>'created_by',
                ],
                'value'=> Yii::$app->user->id,
            ],
            'timestamuby'=>[
                'class'=> \yii\behaviors\AttributeBehavior::className(),
                'attributes'=>[
                    ActiveRecord::EVENT_BEFORE_UPDATE=>'updated_by',
                ],
                'value'=> Yii::$app->user->id,
            ],
//            'timestampcompany'=>[
//                'class'=> \yii\behaviors\AttributeBehavior::className(),
//                'attributes'=>[
//                    ActiveRecord::EVENT_BEFORE_INSERT=>'company_id',
//                ],
//                'value'=> isset($_SESSION['user_company_id'])? $_SESSION['user_company_id']:1,
//            ],
//            'timestampbranch'=>[
//                'class'=> \yii\behaviors\AttributeBehavior::className(),
//                'attributes'=>[
//                    ActiveRecord::EVENT_BEFORE_INSERT=>'branch_id',
//                ],
//                'value'=> isset($_SESSION['user_branch_id'])? $_SESSION['user_branch_id']:1,
//            ],
            'timestampupdate' => [
                'class' => \yii\behaviors\AttributeBehavior::className(),
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_UPDATE => 'updated_at',
                ],
                'value' => time(),
            ],
        ];
    }

    public static function findCode($id){
        $model = Product::find()->select('code')->where(['id'=>$id])->one();
        return $model != null?$model->code:'';
    }
    public static function findName($id){
        $model = Product::find()->select('name')->where(['id'=>$id])->one();
        return $model !=null?$model->name:'';
    }
    public static function findPhoto($id){
        $model = Product::find()->where(['id'=>$id])->one();
        return $model !=null?$model->photo:'';
    }
    public static function findInfo($id){
        $model = Product::find()->where(['id'=>$id])->one();
        return $model !=null?$model : null;
    }
//    public function findUnitid($code){
//        $model = Unit::find()->where(['name'=>$code])->one();
//        return count($model)>0?$model->id:0;
//    }

}
