<?php

namespace backend\controllers;

use Yii;
use backend\models\Paymentreceive;
use backend\models\PaymentreceiveSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;

class PaymentreceiveController extends Controller
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

    /**
     * Lists all Paymentreceive models.
     * @return mixed
     */
    public function actionIndex()
    {
        $pageSize = \Yii::$app->request->post("perpage");
        $searchModel = new \backend\models\PaymentreceiveSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $dataProvider->setSort(['defaultOrder' => ['id' => SORT_DESC]]);
        $dataProvider->pagination->pageSize = $pageSize;

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'perpage' => $pageSize,
        ]);
    }

    /**
     * Displays a single Paymentreceive model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Paymentreceive model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Paymentreceive();

        if ($model->load(Yii::$app->request->post())) {

            $line_order = \Yii::$app->request->post('line_order_id');
            $line_pay_type = \Yii::$app->request->post('line_pay_type');
            $line_pay = \Yii::$app->request->post('line_pay');
            $line_number = \Yii::$app->request->post('line_number');

            $uploaded_file = UploadedFile::getInstancesByName('line_doc');

            $xdate = explode('/', $model->trans_date);
            $t_date = date('Y-m-d H:i:s');
            if (count($xdate) > 1) {
                $t_date = $xdate[2] . '-' . $xdate[1] . '-' . $xdate[0] . ' ' . date('H:i:s');
            }

            $model->trans_date = date('Y-m-d H:i:s', strtotime($t_date));
            $model->journal_no = $model->getLastNo(date('Y-m-d'));
            $model->status = 1;
            if ($model->save()) {
                if ($line_order != null) {
                    if (count($line_order) > 0) {
                        for ($i = 0; $i <= count($line_order) - 1; $i++) {
                            $model_line = new \common\models\PaymentReceiveLine();
                            $model_line->order_id = $line_order[$i];
                            $model_line->payment_receive_id = $model->id;
                            $model_line->payment_amount = $line_pay[$i];
                            $model_line->payment_channel_id = $line_pay_type[$i];
                            $model_line->status = 1;

                            if($i==$line_number[$i]){
                                if (!empty($uploaded_file)) {
                                    foreach ($uploaded_file as $files) {
                                        $file_name = time() . '.' . $files->getExtension();
                                        $files->saveAs(Yii::getAlias('@backend') . '/web/uploads/files/receive/' . $file_name);
                                        $model_line->doc = $file_name;
                                    }
                                }

                            }

                            if($model_line->save()){
                                $this->updatePaymenttransline($model->customer_id,$line_order[$i],$line_pay[$i],1);
                            }
                        }
                    }
                }
                $session = Yii::$app->session;
                $session->setFlash('msg', 'บันทึกข้อมูลเรียบร้อย');
                return $this->redirect(['index']);
            }

        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    public function updatePaymenttransline($customer_id, $order_id, $pay_amt, $pay_type){
        if($customer_id != null && $order_id != null && $pay_amt > 0){
            $model = \backend\models\Paymenttransline::find()->where(['customer_id'=>$customer_id,'order_ref_id'=>$order_id])->andFilterWhere(['payment_method_id'=>2])->one();
            if($model){
//                if($pay_type == 0){
//                    $model->payment_amount = ($model->payment_amount - (float)$pay_amt);
//                }else{
                    $model->payment_amount = ($model->payment_amount + (float)$pay_amt);
//                }

                $model->save(false);
            }
        }
    }

    /**
     * Updates an existing Paymentreceive model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $model_line = \common\models\PaymentReceiveLine::find()->where(['payment_receive_id'=>$id])->all();

        if ($model->load(Yii::$app->request->post())) {

            $line_order = \Yii::$app->request->post('line_order_id');
            $line_pay_type = \Yii::$app->request->post('line_pay_type');
            $line_pay = \Yii::$app->request->post('line_pay');
            $line_id = \Yii::$app->request->post('line_id');
            $line_number = \Yii::$app->request->post('line_number');

            $uploaded_file = UploadedFile::getInstancesByName('line_doc');

            $xdate = explode('/', $model->trans_date);
            $t_date = date('Y-m-d H:i:s');
            if (count($xdate) > 1) {
                $t_date = $xdate[2] . '-' . $xdate[1] . '-' . $xdate[0] . ' ' . date('H:i:s');
            }

            $model->trans_date = date('Y-m-d H:i:s', strtotime($t_date));
            if ($model->save()) {
                if ($line_order != null) {
                    if (count($line_order) > 0) {
                        for ($i = 0; $i <= count($line_order) - 1; $i++) {

                            if($line_id != null){
                                $model_chk = \common\models\PaymentReceiveLine::find()->where(['id'=>$line_id[$i]])->one();
                                if($model_chk){
                                    $model_chk->payment_channel_id = $line_pay_type[$i];
                                    $model_chk->payment_amount = $line_pay[$i];
                                }
                            }else{
                                $model_line = new \common\models\PaymentReceiveLine();
                                $model_line->order_id = $line_order[$i];
                                $model_line->payment_receive_id = $model->id;
                                $model_line->payment_amount = $line_pay[$i];
                                $model_line->status = 1;
                                if($i==$line_number[$i]){
                                    if (!empty($uploaded_file)) {
                                        foreach ($uploaded_file as $files) {
                                            $file_name = time() . '.' . $files->getExtension();
                                            $files->saveAs(Yii::getAlias('@backend') . '/web/uploads/files/receive/' . $file_name);
                                            $model_line->doc = $file_name;
                                        }
                                    }

                                }

                                $model_line->save();
                            }
                        }
                    }
                }
                $session = Yii::$app->session;
                $session->setFlash('msg', 'บันทึกข้อมูลเรียบร้อย');
                return $this->redirect(['index']);
            }
        }

        return $this->render('update', [
            'model' => $model,
            'model_line'=> $model_line
        ]);
    }

    /**
     * Deletes an existing Paymentreceive model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        if($id){
            $model = \backend\models\Paymentreceive::find()->where(['id'=>$id])->one();
            if($model){
                $model_line = \common\models\PaymentReceiveLine::find()->where(['payment_receive_id'=>$id])->one();
                if($model_line){
                    $this->updatePaymenttransline($model->customer_id,$model_line->order_id,$model_line->payment_amount,0);
                    if(\common\models\PaymentReceiveLine::deleteAll(['payment_receive_id'=>$id])){
                        $this->findModel($id)->delete();
                    }
                }
            }

//            if(\common\models\PaymentReceiveLine::deleteAll(['payment_receive_id'=>$id])){
//                $this->findModel($id)->delete();
//            }
        }

        return $this->redirect(['index']);
    }

    /**
     * Finds the Paymentreceive model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Paymentreceive the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Paymentreceive::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    public function actionGetitem()
    {
        $cus_id = \Yii::$app->request->post('customer_id');
        $html = '';
        $total_amount = 0;
        if ($cus_id) {
            $model = \common\models\QuerySalePaySummary::find()->where(['customer_id' => $cus_id])->andFilterWhere(['>','remain_amount',0])->all();
            if ($model) {
//                $html = $cus_id;
                $i = 0;
                foreach ($model as $value) {
                    $i += 1;
                    $total_amount = $total_amount + ($value->remain_amount == null ? 0 : $value->remain_amount);
                    $html .= '<tr>';
                    $html .= '<td style="text-align: center">' . $i . '</td>';
                    $html .= '<td style="text-align: center">' . \backend\models\Orders::getNumber($value->order_id) . '</td>';
                    $html .= '<td style="text-align: center">' . date('d/m/Y', strtotime($value->order_date)) . '</td>';
                    $html .= '<td>
                            <select name="line_pay_type[]" id=""  class="form-control" onchange="checkpaytype($(this))">
                                <option value="0">เงินสด</option>
                                <option value="1">โอนธนาคาร</option>
                            </select>
                            <input type="file" class="line-doc" name="line_doc[]" style="display: none">
                            <input type="hidden" class="line-order-id" name="line_order_id[]" value="' . $value->order_id . '">
                            <input type="hidden" class="line-number" name="line_number[]" value="'.($i-1).'">
                    </td>';
//                    $html .= '<td style="text-align: center"><input type="file" class="form-control"></td>';
                    $html .= '<td>
                            <input type="text" class="form-control line-remain" style="text-align: right" name="line_remain[]" value="' . number_format($value->remain_amount, 2) . '" readonly>
                            <input type="hidden" class="line-remain-qty" value="'.$value->remain_amount.'">
                            </td>';
                    $html .= '<td><input type="number" class="form-control line-pay" name="line_pay[]" value="" onchange="linepaychange($(this))"></td>';
                    $html .= '</tr>';

                }
                $html .= '<tr><td colspan="4" style="text-align: right">รวม</td><td style="text-align: right;font-weight: bold">' . number_format($total_amount, 2) . '</td><td></td></tr>';
            }
        }

        echo $html;
    }
}
