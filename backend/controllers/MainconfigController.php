<?php

namespace backend\controllers;

use backend\models\Uploadfile;
use common\models\LoginForm;
use Yii;
use backend\models\Member;
use backend\models\MemberSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\Json;
use yii\web\UploadedFile;

class MainconfigController extends Controller
{
    public function actionIndex()
    {
        $model_file = new Uploadfile();
        return $this->render('index', [
            'model_file' => $model_file
        ]);
    }

//    public function actionImportcustomer()
//    {
//            $uploaded = UploadedFile::getInstanceByName( 'file_customer');
//            if (!empty($uploaded)) {
//                //echo "ok";return;
//                $upfiles = time() . "." . $uploaded->getExtension();
//                // if ($uploaded->saveAs(Yii::$app->request->baseUrl . '/uploads/files/' . $upfiles)) {
//                if ($uploaded->saveAs('../web/uploads/files/customers/' . $upfiles)) {
//                    //  echo "okk";return;
//                    // $myfile = Yii::$app->request->baseUrl . '/uploads/files/' . $upfiles;
//                    $myfile = '../web/uploads/files/customers/' . $upfiles;
//                    $file = fopen($myfile, "r");
//                    fwrite($file, "\xEF\xBB\xBF");
//
//                    setlocale(LC_ALL, 'th_TH.TIS-620');
//                    $i = -1;
//                    $res = 0;
//                    $data = [];
//                    while (($rowData = fgetcsv($file, 10000, ",")) !== FALSE) {
//                        $i += 1;
//                        $catid = 0;
//                        $qty = 0;
//                        $price = 0;
//                        $cost = 0;
//                        if ($rowData[1] == '' || $i == 0) {
//                            continue;
//                        }
//
//                        $model_dup = \backend\models\Customer::find()->where(['name'=>trim($rowData[1])])->one();
//                        if ($model_dup != null) {
//                            continue;
//                        }
//
//                        $route_id = $this->checkRoute($rowData[11]);
//                        $group_id = $this->checkCustomergroup($rowData[13]);
//                        $type_id = $this->checkCustomertype($rowData[14]);
//                       // $payment_method = $this->checkPaymethod($rowData[4]);
//                        $payment_term = $this->checkPayterm($rowData[6]);
//
//                        $modelx = new \backend\models\Customer();
//                        $modelx->code = $rowData[0];
//                        $modelx->name = $rowData[1];
//                        $modelx->description = $rowData[1];
//                        $modelx->contact_name = '';
//                        $modelx->branch_no = $rowData[2];
//                        $modelx->location_info = $rowData[10];
//                        $modelx->customer_group_id = $group_id;
//                        $modelx->customer_type_id = $type_id;
//                        $modelx->delivery_route_id = $route_id;
//                        $modelx->address = $rowData[4];
//                        $modelx->address2 = $rowData[3];
//                        $modelx->phone = $rowData[15];
//                      //  $modelx->payment_method_id = $payment_method;
//                        $modelx->payment_term_id = $payment_term;
//                        $modelx->status = 1;
//                        if ($modelx->save(false)) {
//                            $res += 1;
//                        }
//                    }
//                    //    print_r($qty_text);return;
//
//                    if ($res > 0) {
//                        $session = Yii::$app->session;
//                        $session->setFlash('msg', 'นำเข้าข้อมูลเรียบร้อย');
//                        return $this->redirect(['index']);
//                    } else {
//                        $session = Yii::$app->session;
//                        $session->setFlash('msg-error', 'พบข้อมผิดพลาด');
//                        return $this->redirect(['index']);
//                    }
//                    // }
//                    fclose($file);
////            }
////        }
//                }
//            }
//    }
    public function actionImportcustomer()
    {
        $uploaded = UploadedFile::getInstanceByName('file_customer');
        if (!empty($uploaded)) {
            //echo "ok";return;
            $upfiles = time() . "." . $uploaded->getExtension();
            // if ($uploaded->saveAs(Yii::$app->request->baseUrl . '/uploads/files/' . $upfiles)) {
            if ($uploaded->saveAs('../web/uploads/files/customers/' . $upfiles)) {
                //  echo "okk";return;
                // $myfile = Yii::$app->request->baseUrl . '/uploads/files/' . $upfiles;
                $myfile = '../web/uploads/files/customers/' . $upfiles;
                $file = fopen($myfile, "r");
                fwrite($file, "\xEF\xBB\xBF");

                setlocale(LC_ALL, 'th_TH.TIS-620');
                $i = -1;
                $res = 0;
                $data = [];
                while (($rowData = fgetcsv($file, 10000, ",")) !== FALSE) {
                    $i += 1;
                    $catid = 0;
                    $qty = 0;
                    $price = 0;
                    $cost = 0;
                    if ($rowData[1] == '' || $i == 0) {
                        continue;
                    }

                    $model_dup = \backend\models\Customer::find()->where(['name' => trim($rowData[1])])->one();
                    if ($model_dup != null) {
                        continue;
                    }

                    $route_id = $this->checkRoute($rowData[3]);
                    $group_id = $this->checkCustomergroup($rowData[4]);
                    $type_id = $this->checkCustomertype($rowData[5]);
                    $payment_method = $this->checkPaymethod($rowData[12]);
                    $payment_term = $this->checkPayterm($rowData[14]);

                    $modelx = new \backend\models\Customer();
                    $modelx->code = $rowData[0];
                    $modelx->name = $rowData[1];
                    $modelx->description = $rowData[11];
                    $modelx->contact_name = $rowData[9];
                    $modelx->branch_no = $rowData[2];
                    $modelx->location_info = '';//$rowData[10];
                    $modelx->customer_group_id = $group_id;
                    $modelx->customer_type_id = $type_id;
                    $modelx->delivery_route_id = $route_id;
                    $modelx->address = $rowData[7];
                    $modelx->address2 = $rowData[8];
                    $modelx->phone = $rowData[10];
                    //  $modelx->payment_method_id = $payment_method;
                    $modelx->payment_term_id = $payment_term;
                    $modelx->status = 1;
                    if ($modelx->save(false)) {
                        $sale_price_group = $this->checkPricegroup($rowData[5],$rowData[6],$type_id);
                        $res += 1;
                    }
                }
                //    print_r($qty_text);return;

                if ($res > 0) {
                    $session = Yii::$app->session;
                    $session->setFlash('msg', 'นำเข้าข้อมูลเรียบร้อย');
                    return $this->redirect(['index']);
                } else {
                    $session = Yii::$app->session;
                    $session->setFlash('msg-error', 'พบข้อมผิดพลาด');
                    return $this->redirect(['index']);
                }
                // }
                fclose($file);
//            }
//        }
            }
        }
    }

    public function actionImportemployee()
    {
        $uploaded = UploadedFile::getInstanceByName('file_employee');
        if (!empty($uploaded)) {
            //echo "ok";return;
            $upfiles = time() . "." . $uploaded->getExtension();
            // if ($uploaded->saveAs(Yii::$app->request->baseUrl . '/uploads/files/' . $upfiles)) {
            if ($uploaded->saveAs('../web/uploads/files/customers/' . $upfiles)) {
                //  echo "okk";return;
                // $myfile = Yii::$app->request->baseUrl . '/uploads/files/' . $upfiles;
                $myfile = '../web/uploads/files/customers/' . $upfiles;
                $file = fopen($myfile, "r");
                fwrite($file, "\xEF\xBB\xBF");

                setlocale(LC_ALL, 'th_TH.TIS-620');
                $i = -1;
                $res = 0;
                $data = [];
                while (($rowData = fgetcsv($file, 10000, ",")) !== FALSE) {
                    $i += 1;
                    $catid = 0;
                    $qty = 0;
                    $price = 0;
                    $cost = 0;
                    if ($rowData[1] == '' || $i == 0) {
                        continue;
                    }

                    $model_dup = \backend\models\Employee::find()->where(['fname' => trim($rowData[2])])->one();
                    if ($model_dup != null) {
                        continue;
                    }


                    $modelx = new \backend\models\Employee();
                    $modelx->code = $rowData[1];
                    $modelx->fname = $rowData[2];
                    $modelx->lname = $rowData[3];
                    $modelx->status = 1;
                    if ($modelx->save(false)) {
                        $res += 1;
                    }
                }
                //    print_r($qty_text);return;

                if ($res > 0) {
                    $session = Yii::$app->session;
                    $session->setFlash('msg', 'นำเข้าข้อมูลเรียบร้อย');
                    return $this->redirect(['index']);
                } else {
                    $session = Yii::$app->session;
                    $session->setFlash('msg-error', 'พบข้อมผิดพลาด');
                    return $this->redirect(['index']);
                }
                // }
                fclose($file);
//            }
//        }
            }
        }
    }

    public function checkRoute($name)
    {
        $id = 0;
        if ($name != '') {
            $model = \backend\models\Deliveryroute::find()->where(['code' => $name])->one();
            if ($model) {
                $id = $model->id;
            } else {
                $model_new = new \backend\models\Deliveryroute();
                $model_new->code = $name;
                $model_new->name = $name;
                $model_new->description = $name;
                // $model_new->status = 1;
                if ($model_new->save()) {
                    $id = $model_new->id;
                }
            }
        }
        return $id;
    }

    public function checkCustomergroup($name)
    {
        $id = 0;
        if ($name != '') {
            $model = \backend\models\Customergroup::find()->where(['name' => $name])->one();
            if ($model) {
                $id = $model->id;
            } else {
                $model_new = new \backend\models\Customergroup();
                $model_new->code = $name;
                $model_new->name = $name;
                $model_new->description = $name;
                $model_new->status = 1;
                if ($model_new->save()) {
                    $id = $model_new->id;
                }
            }
        }
        return $id;
    }

    public function checkCustomertype($name)
    {
        $id = 0;
        if ($name != '') {
            $model = \backend\models\Customertype::find()->where(['code' => $name])->one();
            if ($model) {
                $id = $model->id;
            } else {
                $model_new = new \backend\models\Customertype();
                $model_new->code = $name;
                $model_new->name = $name;
                $model_new->description = $name;
                $model_new->status = 1;
                if ($model_new->save(false)) {
                    $id = $model_new->id;
                }
            }
        }
        return $id;
    }

    public function checkPaymethod($name)
    {
        $id = 0;
        if ($name != '') {
            $model = \backend\models\Paymentmethod::find()->where(['code' => $name])->one();
            if ($model) {
                $id = $model->id;
            } else {
                $model_new = new \backend\models\Paymentmethod();
                $model_new->code = $name;
                $model_new->name = $name;
                $model_new->note = $name;
                $model_new->status = 1;
                if ($model_new->save()) {
                    $id = $model_new->id;
                }
            }
        }
        return $id;
    }

    public function checkPayterm($name)
    {
        $id = 0;
        if ($name != '') {
            $model = \backend\models\Paymentterm::find()->where(['code' => $name])->one();
            if ($model) {
                $id = $model->id;
            } else {
                $model_new = new \backend\models\Paymentterm();
                $model_new->code = $name;
                $model_new->name = $name;
                $model_new->description = $name;
                $model_new->status = 1;
                if ($model_new->save()) {
                    $id = $model_new->id;
                }
            }
        }
        return $id;
    }

    public function checkPricegroup($code,$name,$type_id)
    {
        $id = 0;
        if ($code != '') {
            $model = \backend\models\Pricegroup::find()->where(['code' => $code])->one();
            if ($model) {
                 $model_add_type = \common\models\PriceCustomerType::find()->where(['price_group_id'=>$model->id,'customer_type_id'=>$type_id])->one();
                 if(!$model_add_type){
                     $add_model = new \common\models\PriceCustomerType();
                     $add_model->price_group_id = $model->id;
                     $add_model->customer_type_id = $type_id;
                     $add_model->status = 1;
                     $add_model->save();
                 }
            } else {
                $model_new = new \backend\models\Pricegroup();
                $model_new->code = $code;
                $model_new->name = $name;
                $model_new->description = $name;
                $model_new->status = 1;
                if ($model_new->save()) {
                    $model_add_type = \common\models\PriceCustomerType::find()->where(['price_group_id'=>$model_new->id,'customer_type_id'=>$type_id])->one();
                    if(!$model_add_type){
                        $add_model = new \common\models\PriceCustomerType();
                        $add_model->price_group_id = $model_new->id;
                        $add_model->customer_type_id = $type_id;
                        $add_model->status = 1;
                        $add_model->save();
                    }
                }
            }
        }
        return $id;
    }

}
