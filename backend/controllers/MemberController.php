<?php

namespace backend\controllers;

use common\models\LoginForm;
use Yii;
use backend\models\Member;
use backend\models\MemberSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\Json;

class MemberController extends Controller
{
   public $enableCsrfValidation = false;
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST','GET'],
                ],
            ],
        ];
    }

    public function actionCreateMember(){
        \Yii::$app->response->format = \Yii\web\Response::FORMAT_JSON;
        $member = new \common\models\Member();
        $member->scenario = \common\models\Member::SCENARIO_CREATE;
        $member->attributes = \Yii::$app->request->post();

        if($member->validate()){
            $member->save();
            return ['status'=> true,'data'=>'Record is saved'];
        }else{
            return ['status'=> false,'data'=>$member->getErrors()];
        }
    }

    public function actionGetMember(){
        \Yii::$app->response->format = \Yii\web\Response::FORMAT_JSON;
        $member = \backend\models\Member::find()->all();
        if(count($member) > 0){
            return ['status'=> true, 'data'=> $member];
        }else{
            return ['status'=> false, 'data'=> 'Not found'];
        }
    }

    public function actionUpdateMember(){
        \Yii::$app->response->format = \Yii\web\Response::FORMAT_JSON;
        $attributes = \Yii::$app->request->post();
        $member = \common\models\Member::find()->where(['id'=>$attributes['id']])->one();

        if($member){
            $member->attributes = \Yii::$app->request->post();
            $member->save();
            return ['status'=> true,'data'=>'Record is updated'];
        }else{
            return ['status'=> false,'data'=>$member->getErrors()];
        }
    }

    public function actionDeleteMember(){
        \Yii::$app->response->format = \Yii\web\Response::FORMAT_JSON;
        $attributes = \Yii::$app->request->post();
        $member = \common\models\Member::find()->where(['id'=>$attributes['id']])->one();

        if($member){
            $member->delete();
            return ['status'=> true,'data'=>'Record is Deleted'];
        }else{
            return ['status'=> false,'data'=>$member->getErrors()];
        }
    }

    public function actionGetRoute(){
        \Yii::$app->response->format = \Yii\web\Response::FORMAT_JSON;
        $member = \backend\models\Deliveryroute::find()->all();
        if(count($member) > 0){
            return ['status'=> true, 'data'=> $member];
        }else{
            return ['status'=> false, 'data'=> 'Not found'];
        }
    }
    public function actionGetProducts(){
        \Yii::$app->response->format = \Yii\web\Response::FORMAT_JSON;
        $product = \backend\models\Product::find()->all();
        if(count($product) > 0){
            return ['status'=> true, 'data'=> $product];
        }else{
            return ['status'=> false, 'data'=> 'Not found'];
        }
    }

    public function actionGetOrder(){
        \Yii::$app->response->format = \Yii\web\Response::FORMAT_JSON;
        $order = \backend\models\Orders::find()->all();
        if(count($order) > 0){
            return ['status'=> true, 'data'=> $order];
        }else{
            return ['status'=> false, 'data'=> 'Not found'];
        }
    }

    public function actionApiLogin(){
//        if (!Yii::$app->user->isGuest) {
//            return ['status'=> false,'data'=>'Not permission'];
//        }
        $res_data = [];
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $attributes = \Yii::$app->getRequest()->getBodyParams();
        return ['status'=> true,'data'=>$attributes["username"]];
        $model = \common\models\User::find()->where(['username'=> $attributes['username'] ])->one();
        if ($model) {
            if($model->validatePassword($attributes['password'])){
                array_push($res_data, ['user_id'=>$model->id,'idToken'=>'']);
                return ['status'=> true,'data'=>$res_data];
            }else{
                return ['status'=> false,'data'=>'login fail for username '.$attributes['username']];
            }

        } else {
            return ['status'=> false,'data'=>'login fail for username '.$attributes['username']];
        }
//        $member = \common\models\Member::find()->where(['id'=>$attributes['id']])->one();
//
//        if($member){
//            $member->attributes = \Yii::$app->request->post();
//            $member->save();
//            return ['status'=> true,'data'=>'Record is updated'];
//        }else{
//            return ['status'=> false,'data'=>$member->getErrors()];
//        }
    }



    public function actionIndex()
    {
        $searchModel = new MemberSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    public function actionCreate()
    {
        $model = new Member();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    protected function findModel($id)
    {
        if (($model = Member::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }
}
