<?php

namespace backend\controllers;


use backend\models\ScrapSearch;
use Yii;
use backend\models\Stocksum;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * StocksumController implements the CRUD actions for Stocksum model.
 */
class ScrapreportController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    public function actionIndex()
    {
        $searchModel = new ScrapSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
//        $dataProvider->query->andFilterWhere(['activity_type_id'=>15]);
        $dataProvider->pagination->pageSize = 300;
        $dataProvider->query->andFilterWhere(['>', 'qty', 0]);
        // $dataProvider->query->andFilterWhere(['is not', 'product_id', new \yii\db\Expression('null')]);
        $dataProvider->setSort(['defaultOrder' => ['trans_date' => SORT_ASC, 'product_id' => SORT_ASC]]);

        $model_bottom = $dataProvider->getModels();

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'model_bottom' => $model_bottom,
        ]);
    }


    protected function findModel($id)
    {
        if (($model = Stocksum::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
