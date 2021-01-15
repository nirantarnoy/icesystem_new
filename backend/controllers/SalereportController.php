<?php
namespace backend\controllers;

use backend\models\SalereportSearch;
use \Yii;
use backend\models\SalecomSearch;
use yii\web\Controller;

class SalereportController extends Controller{
    public function actionIndex(){

        $searchModel = new SalereportSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $dataProvider->query->andFilterWhere(['>','qty',0]);
        $dataProvider->setSort([
            'defaultOrder'=>['route_code'=>SORT_ASC,'customer_id'=>SORT_ASC]
        ]);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
}
