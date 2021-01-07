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
        return $this->render('index',[
            'model_file' => $model_file
        ]);
    }

    public function actionImportcustomer()
    {
//echo "ok naja";return;
            $uploaded = UploadedFile::getInstanceByName( 'file_customer');
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

                        $model_dup = \backend\models\Customer::find()->where(['name'=>trim($rowData[3])])->one();
                        if ($model_dup != null) {
                            continue;
                        }

                        $modelx = new \backend\models\Customer();
                        $modelx->code = $rowData[2];
                        $modelx->name = $rowData[3];
                        $modelx->description = $rowData[3];
                        $modelx->contact_name = $rowData[5];
                        $modelx->location_info = $rowData[9];
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
}
