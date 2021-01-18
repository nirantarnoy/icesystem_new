<?php

namespace backend\controllers;

use backend\models\Orderline;
use backend\models\WarehouseSearch;
use Yii;
use backend\models\Orders;
use backend\models\OrdersSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

class OrdersController extends Controller
{
    public $enableCsrfValidation = false;

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
        $pageSize = \Yii::$app->request->post("perpage");
        $searchModel = new OrdersSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $dataProvider->pagination->pageSize = $pageSize;

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'perpage' => $pageSize,
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
        $model = new Orders();

        if ($model->load(Yii::$app->request->post())) {
            $line_customer_id = \Yii::$app->request->post('line_customer_id');
            $line_price = \Yii::$app->request->post('line_qty_cal');
            // print_r($line_customer_id);
//            print "<pre>";
//            print_r($_POST);
//            print "</pre>";
            // return;

            $x_date = explode('/',$model->order_date);
            $sale_date = date('Y-m-d');
            if(count($x_date)>1){
                $sale_date = $x_date[2].'/'.$x_date[1].'/'.$x_date[0];
            }
            $model->order_date = date('Y-m-d', strtotime($sale_date));
            $model->status = 1;
            if ($model->save()) {
                if (count($line_customer_id) > 0) {
                    $product_list = \backend\models\Product::find()->all();
                    for ($i = 0; $i <= count($line_customer_id) - 1; $i++) {
                        $cust_id = $line_customer_id[$i];
                        $x_id = -1;
                        foreach ($product_list as $prods) {
                            if (\Yii::$app->request->post($prods->code) != null) {
                                $x_id += 1;
                                // $prod_line = \Yii::$app->request->post($prods->code);
                                $prod_line_qty = \Yii::$app->request->post('line_qty_' . $prods->code);
                                $line_sale_price = \Yii::$app->request->post('line_sale_price_'.$prods->code);
                                // print_r($prod_line_qty);return;

                                //  if(count($prod_line) > 0){
                                // for($x=0;$x<=count($prod_line)-1;$x++){
                                $model_line = new \backend\models\Orderline();
                                $model_line->order_id = $model->id;
                                $model_line->customer_id = $line_customer_id[$i];
                                $model_line->product_id = $prods->id;
                                $model_line->qty = $prod_line_qty[$i];
                                $model_line->price = $line_sale_price[$i];
                                $model_line->line_total =$prod_line_qty[$i] * $line_sale_price[$i] ;
                                $model_line->save(false);
                                // }
                                //  }

                            }
                        }

                    }
                }
//                if (count($prod_id) > 0) {
//                    for ($i = 0; $i <= count($prod_id) - 1; $i++) {
//                        // echo $prod_id[0];return;
//                        $modelline = new \backend\models\Orderline();
//                        $modelline->order_id = $model->id;
//                        $modelline->product_id = $prod_id[$i];
//                        $modelline->qty = $qty[$i];
//                        $modelline->price = $price[$i];
//                        $modelline->line_total = $qty[$i] * $price[$i];
//                        $modelline->status = 0;
//                        $modelline->save(false);
//                    }
//                }
                $session = Yii::$app->session;
                $session->setFlash('msg', 'บันทึกรายการเรียบร้อย');
                return $this->redirect(['index']);
            }
        }
        return $this->render('create', [
            'model' => $model,
        ]);
    }

    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $model_line = \backend\models\Orderline::find()->where(['order_id' => $id])->all();

        if ($model->load(Yii::$app->request->post())) {
//            $prod_id = \Yii::$app->request->post('product_id');
//            $qty = \Yii::$app->request->post('line_qty');
//            $price = \Yii::$app->request->post('line_price');
            $removelist = Yii::$app->request->post('removelist');
            $line_customer_id = \Yii::$app->request->post('line_customer_id');
            $line_price = \Yii::$app->request->post('line_qty_cal');
            //        print_r($line_customer_id);
//            print "<pre>";
            //       print_r($_POST);
//            print "</pre>";
            //         return;
            $x_date = explode('/',$model->order_date);
            $sale_date = date('Y-m-d');
            if(count($x_date)>1){
                $sale_date = $x_date[2].'/'.$x_date[1].'/'.$x_date[0];
            }
            $model->order_date = date('Y-m-d', strtotime($sale_date));
            $model->status = 1;
            if ($model->save()) {

                if (count($line_customer_id) > 0) {
                    $product_list = \backend\models\Product::find()->all();
                    for ($i = 0; $i <= count($line_customer_id) - 1; $i++) {
                        $cust_id = $line_customer_id[$i];
                        $x_id = -1;
                        foreach ($product_list as $prods) {
                            if (\Yii::$app->request->post($prods->code) != null) {
                                $x_id += 1;
                                // $prod_line = \Yii::$app->request->post($prods->code);
                                $prod_line_qty = \Yii::$app->request->post('line_qty_' . $prods->code);
                                $line_sale_price = \Yii::$app->request->post('line_sale_price_'.$prods->code);
                             //  print_r($line_sale_price);return;
                                $model_has = $this->check_has_line($model->id, $line_customer_id[$i], $prods->id);
                                if ($model_has != null) {
                                    // echo "has ";return;
                                    $model_has->qty = $prod_line_qty[$i];
                                    $model_has->price = $line_sale_price[$i];
                                    $model_has->line_total = ($prod_line_qty[$i] * $line_sale_price[$i]);
                                    $model_has->save(false);
                                } else {
                                    $model_line = new \backend\models\Orderline();
                                    $model_line->order_id = $model->id;
                                    $model_line->customer_id = $line_customer_id[$i];
                                    $model_line->product_id = $prods->id;
                                    $model_line->qty = $prod_line_qty[$i];
                                    $model_line->price = $line_sale_price[$i];
                                    $model_line->line_total =$prod_line_qty[$i] * $line_sale_price[$i] ;
                                    $model_line->save(false);
                                }

                            }
                        }

                    }
                }


//                if (count($prod_id) > 0) {
//                    //echo "hello";return;
//                    for ($i = 0; $i <= count($prod_id) - 1; $i++) {
//                        //echo "hello";return;
//                        $model_chk = \backend\models\Orderline::find()->where(['product_id' => $prod_id[$i], 'order_id' => $model->id])->one();
//                        if ($model_chk) {
//                            $model_chk->qty = $qty[$i];
//                            $model_chk->price = $price[$i];
//                            $model_chk->line_total = $qty[$i] * $price[$i];
//                            $model_chk->save(false);
//                        } else {
//                            //echo "hello sd";return;
//                            $modelline = new \backend\models\Orderline();
//                            $modelline->order_id = $model->id;
//                            $modelline->product_id = $prod_id[$i];
//                            $modelline->qty = $qty[$i];
//                            $modelline->price = $price[$i];
//                            $modelline->line_total = $qty[$i] * $price[$i];
//                            $modelline->status = 0;
//                            $modelline->save(false);
//                        }
//                    }
//                }
                if (count($removelist)) {
                    // count($removelist);return;
                    $rec_del = explode(',', $removelist);
//                    print_r($rec_del);return;
                    for ($i = 0; $i <= count($rec_del) - 1; $i++) {
                        \backend\models\Orderline::deleteAll(['order_id' => $model->id, 'customer_id' => $rec_del[$i]]);
                    }

                }
                $session = Yii::$app->session;
                $session->setFlash('msg', 'บันทึกข้อมูลค้าเรียบร้อย');
                return $this->redirect(['index']);
            }
        }

        return $this->render('update', [
            'model' => $model,
            'model_line' => $model_line
        ]);
    }

    public function check_has_line($order_id, $customer_id, $prod_id)
    {
        $model = \backend\models\Orderline::find()->where(['order_id' => $order_id, 'customer_id' => $customer_id, 'product_id' => $prod_id])->one();
        return $model;
    }

    public function actionDelete($id)
    {
        Orderline::deleteAll(['order_id'=>$id]);
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    protected function findModel($id)
    {
        if (($model = Orders::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }

    public function actionFindCustomer($id)
    {
        $model = \common\models\Customer::find()->where(['delivery_route_id' => $id])->all();
        if ($model != null) {
            foreach ($model as $value) {
                echo "<option value='" . $value->id . "'>$value->name</option>";
            }
        } else {
            echo "<option></option>";
        }
    }
    public function actionFindCarData()
    {
        $id = \Yii::$app->request->post('id');
        if($id){
            $model = \common\models\SaleGroup::find()->where(['delivery_route_id' => $id])->one();
            if ($model) {
                $model_car = \backend\models\Car::find()->where(['sale_group_id'=>$model->id])->all();
                foreach ($model_car as $value) {
                    echo "<option value='" . $value->id . "'>$value->name</option>";
                }
            } else {
                echo "<option></option>";
            }
        }else{
            echo "<option></option>";
        }

    }

    public function actionFindSaledata()
    {
        $id = \Yii::$app->request->post('id');
        $html = '';
        $model = \common\models\Customer::find()->where(['delivery_route_id' => $id])->all();
        $html .= '<thead>';
        $html .= '<tr>';
        $html .= '<th style="width: 5%;text-align: center">#</th>';
        $html .= '<th style="width: 8%">รหัสลูกค้า</th>';
        $html .= '<th style="width: 15%">ชื่อลูกค้า</th>';
        $html .= $this->getProductcolumn($id);
        $html .= '<th style="width: 8%;text-align: right">รวมจำนวน</th>';
        $html .= '<th style="text-align: right">รวมเงิน</th>';
        $html .= '<th style="text-align: center">-</th>';
        $html .= '</tr>';
        $html .= '</thead>';

        if (1 > 0) {
            $html .= '<tbody>';
            $i = 0;
            foreach ($model as $value) {
                $i += 1;
                $html .= '<tr>';
                $html .= '<td style="text-align: center">' . $i . '</td>';
                $html .= '<td>' . \backend\models\Customer::findCode($value->id) . '<input type="hidden" class="line-customer-id" name="line_customer_id[]" value="' . $value->id . '"></td>';
                $html .= '<td>' . \backend\models\Customer::findName($value->id) . '</td>';
                $html .= $this->getProducttextfield($id);
                $html .= '<td style="text-align: right"><input type="text" disabled class="form-control line-qty-cal" name="line_qty_cal[]" style="text-align: right"></td>';
                $html .= '<td style="text-align: right"><input type="text" disabled class="form-control line-total-price" style="text-align: right"></td>';
                $html .= '<td style="text-align: center"><div class="btn btn-danger btn-sm" onclick="removeorderline($(this))">ลบ</div></td>';
                $html .= '</tr>';
            }
            $html .= '</tbody>';
        }
        // $html = '<tr><td><input type="text" name="line_customer_id[]" value="niran"></td></tr>';
        echo $html;
    }

    public function getProductcolumn($route_id)
    {
        $html = '';
        $model = \common\models\QueryProductFromRoute::find()->where(['delivery_route_id' => $route_id])->all();
        foreach ($model as $value) {
            $new_price = '<span style="color: red">'.$value->sale_price.'</span>';
            $html .= '<th style="text-align: center">' . $value->code.' ( '.$new_price.' ) ' . '</th>';
        }
        return $html;
    }

    public function getProducttextfield($route_id)
    {
        $html = '';
        $model = \common\models\QueryProductFromRoute::find()->where(['delivery_route_id' => $route_id])->all();
        $i = 0;
        foreach ($model as $value) {

            $i += 1;
            $input_name = "line_qty_" . $value->code . "[]";
            $input_name_price = "line_sale_price_".$value->code."[]";
            $line_prod_code = $value->code . '[]';
            $html .= '<td>
                       <input type="hidden" class="line-qty-' . $i . '">
                       <input type="hidden" class="line-product-code" name="' . $line_prod_code . '" value="' . $value->code . '">
                       <input type="hidden" class="line-sale-price" name="'.$input_name_price.'" value="' . $value->sale_price . '">
                       <input type="number" name="' . $input_name . '" data-var="'.$value->sale_price.'" style="text-align: center" class="form-control" min="0" value="0" onchange="line_qty_cal($(this))">
                  </td>';
        }
        return $html;
    }

    public function actionFindSaledataUpdate()
    {
        $id = \Yii::$app->request->post('id');
        $html = '';
        $model = \common\models\QueryOrderUpdate::find()->where(['order_id' => $id])->all();
        $html .= '<thead>';
        $html .= '<tr>';
        $html .= '<th style="width: 5%;text-align: center">#</th>';
        $html .= '<th style="width: 8%">รหัสลูกค้า</th>';
        $html .= '<th style="width: 15%">ชื่อลูกค้า</th>';
        $html .= $this->getProductcolumnUpdate($id);
        $html .= '<th style="width: 8%;text-align: right">รวมจำนวน</th>';
        $html .= '<th style="text-align: right">รวมเงิน</th>';
        $html .= '<th style="text-align: center">-</th>';
        $html .= '</tr>';
        $html .= '</thead>';

        if (1 > 0) {
            $html .= '<tbody>';
            $i = 0;
            foreach ($model as $value) {
                $i += 1;
                $html .= '<tr>';
                $html .= '<td style="text-align: center">' . $i . '</td>';
                $html .= '<td>' . $value->code . '<input type="hidden" class="line-customer-id" name="line_customer_id[]" value="' . $value->customer_id . '"></td>';
                $html .= '<td>' . $value->name . '</td>';
                $html .= $this->getProducttextfieldUpdate($id, $value->customer_id);
                $html .= '</tr>';
            }
            $html .= '</tbody>';
        }
        // $html = '<tr><td><input type="text" name="line_customer_id[]" value="niran"></td></tr>';
        echo $html;
    }

    public function getProductcolumnUpdate($order_id)
    {
        $html = '';
        $model = \common\models\OrderLine::find()->select(['product_id','price'])->where(['order_id' => $order_id])->groupBy(['product_id'])->all();
        foreach ($model as $value) {
            $new_price = '<span style="color: red">'.$value->price.'</span>';
            $html .= '<th style="text-align: center">' . \backend\models\Product::findCode($value->product_id).' ( '.$new_price.' ) ' . '</th>';
          //  $html .= '<th style="text-align: center">' . \backend\models\Product::findCode($value->product_id) . '</th>';
        }
        return $html;
    }

    public function getProducttextfieldUpdate($order_id, $customer_id)
    {
        $html = '';
        $model = \common\models\OrderLine::find()->where(['order_id' => $order_id, 'customer_id' => $customer_id])->all();
        $i = 0;
        $line_total_qty = 0;
        $line_total_price = 0;
        foreach ($model as $value) {
            $i += 1;
            $line_prod_code = \backend\models\Product::findCode($value->product_id) . "[]";
            $input_name = "line_qty_" . $line_prod_code;
            $input_name_price = "line_sale_price_".$line_prod_code;

            $line_total_qty = $line_total_qty + $value->qty;
            $line_total_price = $line_total_price + ($value->qty * $value->price);

            $html .= '<td>
                       <input type="hidden" class="line-qty-' . $i . '">
                       <input type="hidden" class="line-product-code" name="' . $line_prod_code . '" value="' . $line_prod_code . '">
                       <input type="hidden" class="line-sale-price" name="'.$input_name_price.'" value="' . $value->price . '">
                       <input type="number" name="' . $input_name . '" data-var="'.$value->price.'" style="text-align: center" value="' . $value->qty . '" class="form-control" min="0" onchange="line_qty_cal($(this))">
                  </td>';
        }
        $html .= '<td style="text-align: right"><input type="text" disabled class="form-control line-qty-cal" name="line_qty_cal[]" style="text-align: right" value="' . number_format($line_total_qty) . '"></td>';
        $html .= '<td style="text-align: right"><input type="text" disabled class="form-control line-total-price" style="text-align: right"  value="' . number_format($line_total_price) . '"></td>';
        $html .= '<td style="text-align: center"><div class="btn btn-danger btn-sm" onclick="removeorderline($(this))">ลบ</div></td>';
        return $html;
    }
}
