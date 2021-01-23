<?php

namespace backend\controllers;

use backend\models\WarehouseSearch;
use Yii;
use backend\models\Car;
use backend\models\CarSearch;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * CarController implements the CRUD actions for Car model.
 */
class PosController extends Controller
{
   public $enableCsrfValidation = false;
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['login', 'error'],
                        'allow' => true,
                    ],
                    [
                        'actions' => ['logout', 'index','getcustomerprice','closesale'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
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
        return $this->render('index', [
           'model' => null
        ]);
    }

    public function actionGetcustomerprice(){
        $data = [];
        $data_cus_price = [];
        $data_basic_price = [];
        $customer_id = \Yii::$app->request->post('customer_id');
        if($customer_id){
            $model = \common\models\QueryCustomerPrice::find()->where(['customer_id'=>$customer_id])->all();
            if($model != null){
                foreach ($model as $value){
                    array_push($data_cus_price,['product_id'=>$value->product_id,'sale_price'=>$value->sale_price,'price_name'=>$value->name]);
                }
            }

        }
        $model_basic_price = \backend\models\Product::find()->all();
        if($model_basic_price){
            foreach ($model_basic_price as $value){
                array_push($data_basic_price,['product_id'=>$value->id,'sale_price'=>$value->sale_price]);
            }
        }
        array_push($data,$data_cus_price,$data_basic_price);
        echo json_encode($data);
    }

    public function actionClosesale(){
        $pay_total_amount = \Yii::$app->request->post('pay_total_amount');
        $pay_amount = \Yii::$app->request->post('pay_amount');
        $pay_change = \Yii::$app->request->post('sale_pay_change');
        $payment_type = \Yii::$app->request->post('sale_pay_type');

        $customer_id = \Yii::$app->request->post('customer_id');
        $product_list = \Yii::$app->request->post('cart_product_id');
        $line_qty = \Yii::$app->request->post('cart_qty');
        $line_price = \Yii::$app->request->post('cart_price');

        //echo $customer_id;return;

        if($customer_id){
              $model_order = new \backend\models\Orders();
              $model_order->order_no = $model_order->getLastNo();
              $model_order->order_date = date('Y-m-d');
              $model_order->customer_id = $customer_id;
              $model_order->sale_channel_id = 2;
              $model_order->status = 1;
              if($model_order->save(false)){
                  if(count($product_list) > 0){
                      for($i=0;$i<=count($product_list)-1;$i++){
                          $model_order_line = new \backend\models\Orderline();
                          $model_order_line->order_id = $model_order->id;
                          $model_order_line->product_id  = $product_list[$i];
                          $model_order_line->qty = $line_qty[$i];
                          $model_order_line->price = $line_price[$i];
                          $model_order_line->line_total = ($line_price[$i] * $line_qty[$i]);
                          $model_order_line->status = 1;
                          $model_order_line->save(false);
                      }
                  }
              }
        }

        return $this->redirect(['pos/index']);
    }

}
