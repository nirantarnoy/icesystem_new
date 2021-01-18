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

        $view_com_date = \Yii::$app->request->post('com_date');
        $view_emp_id = \Yii::$app->request->post('emp_id');
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
            'view_com_date' => $view_com_date,
            'view_emp_id' => $view_emp_id
        ]);
    }
}
