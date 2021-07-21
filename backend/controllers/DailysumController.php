<?php
namespace backend\controllers;

use backend\models\Journalissue;
use backend\models\JournalissueSearch;
use backend\models\Orderline;
use backend\models\Orders;
use backend\models\OrdersposSearch;
use backend\models\WarehouseSearch;
use common\models\LoginLog;
use Yii;
use backend\models\Car;
use backend\models\CarSearch;
use yii\base\BaseObject;
use yii\filters\AccessControl;
use yii\helpers\ArrayHelper;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use kartik\mpdf\Pdf;
use yii\web\Session;

/**
 * CarController implements the CRUD actions for Car model.
 */
class DailysumController extends Controller
{
    public $enableCsrfValidation = false;
    public function actionIndex()
    {
        // $x = '2021-03-03';
        // $t_date = date('Y-m-d',strtotime($x));

        $order_date = \Yii::$app->request->post('pos_date');

        $t_date = date('Y-m-d');

        $x_date = explode('/', $order_date);
        if (count($x_date) > 1) {
            $t_date = $x_date[2] . '-' . $x_date[1] . '-' . $x_date[0];
        }

        $searchModel = new \backend\models\SalemobiledataSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $dataProvider->query->select(['code', 'name', 'price', 'SUM(qty) as qty',
            'SUM(line_total) as line_total','SUM(line_total_cash) as line_total_cash,SUM(line_total_credit) as line_total_credit',
            'SUM(line_qty_cash) as line_qty_cash','SUM(line_qty_credit) as line_qty_credit']);
        $dataProvider->query->andFilterWhere(['>', 'qty', 0]);
        $dataProvider->query->andFilterWhere(['=', 'date(order_date)', $t_date]);
       // $dataProvider->query->andFilterWhere(['=', 'order_no', 'SO-210721-0057']);

        $dataProvider->query->groupBy(['code', 'name', 'price']);
        $dataProvider->setSort([
            'defaultOrder' => ['item_pos_seq' => SORT_ASC]
        ]);

        $searchModel2 = new \backend\models\SalepospaySearch();
        $dataProvider2 = $searchModel2->search(Yii::$app->request->queryParams);
        $dataProvider2->query->select(['code', 'name', 'SUM(payment_amount) as payment_amount']);
        $dataProvider2->query->andFilterWhere(['>', 'payment_amount', 0]);
        $dataProvider2->query->andFilterWhere(['date(order_date)' => $t_date]);
        $dataProvider2->query->groupBy(['code', 'name', 'sale_channel_id']);
        $dataProvider2->setSort([
            'defaultOrder' => ['code' => SORT_ASC]
        ]);
//        $searchModel2 = new \backend\models\SalepospaySearch();
//        $dataProvider2 = $searchModel2->search(Yii::$app->request->queryParams);
//        $dataProvider2->query->select(['code', 'name', 'SUM(payment_amount) as payment_amount']);
//        $dataProvider2->query->andFilterWhere(['>', 'payment_amount', 0]);
//        $dataProvider2->query->andFilterWhere(['date(payment_date)' => $t_date]);
//        $dataProvider2->query->groupBy(['code', 'name']);
//        $dataProvider2->setSort([
//            'defaultOrder' => ['code' => SORT_ASC]
//        ]);

        return $this->render('_index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'searchModel2' => $searchModel2,
            'dataProvider2' => $dataProvider2,
            'show_pos_date' => $t_date
        ]);
    }
}
