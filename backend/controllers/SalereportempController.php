<?php
namespace backend\controllers;

use backend\models\SalereportbyempSearch;
use backend\models\SalereportempSearch;
use \Yii;
use yii\web\Controller;

class SalereportempController extends Controller{
    public function actionIndex(){

        $searchModel = new SalereportempSearch();
//print_r(Yii::$app->request->queryParams);
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
     //   $dataProvider->query->andFilterWhere(['>','qty',0])->andFilterWhere(['customer_id'=>2247]);
        $dataProvider->query->andFilterWhere(['>','qty',0]);
        $dataProvider->setSort([
            'defaultOrder'=>['emp_id'=>SORT_ASC,'order_date'=>SORT_ASC,'payment_method_id'=>SORT_ASC,'customer_id'=>SORT_ASC,'product_id'=>SORT_ASC]
        ]);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
    public function actionEmpcomlist(){

        $searchModel = new SalereportbyempSearch();
//print_r(Yii::$app->request->queryParams);
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        //   $dataProvider->query->andFilterWhere(['>','qty',0])->andFilterWhere(['customer_id'=>2247]);
//        $dataProvider->query->andFilterWhere(['>','qty',0]);
//        $dataProvider->setSort([
//            'defaultOrder'=>['emp_id'=>SORT_ASC,'order_date'=>SORT_ASC,'payment_method_id'=>SORT_ASC,'customer_id'=>SORT_ASC,'product_id'=>SORT_ASC]
//        ]);

        return $this->render('empcomlist', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
}
