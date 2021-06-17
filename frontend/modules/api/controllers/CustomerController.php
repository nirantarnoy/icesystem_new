<?php

namespace frontend\modules\api\controllers;

use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\UploadedFile;


class CustomerController extends Controller
{
    public $enableCsrfValidation = false;

    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'list' => ['POST'],
                    'assetlist' => ['POST'],
                    'assetchecklist' => ['POST'],
                ],
            ],
        ];
    }

    public function actionList()
    {
        $company_id = 1;
        $branch_id = 1;
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $req_data = \Yii::$app->request->getBodyParams();
        $route_id = $req_data['route_id'];
        $company_id = $req_data['company_id'];
        $branch_id = $req_data['branch_id'];

        $data = [];
        $status = false;
        if ($route_id) {
            $model = \common\models\Customer::find()->where(['delivery_route_id' => $route_id, 'company_id' => $company_id, 'branch_id' => $branch_id])->all();
            if ($model) {
                $status = true;
                foreach ($model as $value) {
                    array_push($data, [
                        'id' => $value->id,
                        'code' => $value->code,
                        'name' => $value->name,
                        'route_id' => $value->delivery_route_id
                    ]);
                }
            }
        }

        return ['status' => $status, 'data' => $data];
    }

    public function actionAssetlist()
    {
        $company_id = 1;
        $branch_id = 1;
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $req_data = \Yii::$app->request->getBodyParams();
        $customer_id = $req_data['customer_id'];
        $company_id = $req_data['company_id'];
        $branch_id = $req_data['branch_id'];

        $data = [];
        $status = false;
        if ($customer_id) {
            $model = \common\models\CustomerAsset::find()->where(['customer_id' => $customer_id, 'company_id' => $company_id, 'branch_id' => $branch_id])->all();
            if ($model) {
                $status = true;
                foreach ($model as $value) {
                    array_push($data, [
                        'id' => $value->id,
                        'product_id' => $value->product_id,
                        'code' => \backend\models\Product::findCode($value->product_id),
                        'name' => \backend\models\Product::findName($value->product_id),
                        'qty' => $value->qty,
                        'status' => $value->status,
                        'photo' => '',
                    ]);
                }
            }
        }

        return ['status' => $status, 'data' => $data];
    }

    public function actionAssetchecklist()
    {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $req_data = \Yii::$app->request->getBodyParams();
       // $image = base64_decode($req_data['image']);
        //$image = mb_convert_encoding(base64_decode($req_data['image']), 'UTF-8', 'UTF-8');
        // $image = $_FILES['image']['tmp_name'];
        $status = 0;
        //$image = UploadedFile::getInstanceByName('image');
        $name = time(). uniqid().'.jpg';//$req_data['name'];
//        if(is_object($image)){
//            $status = 1000;
//            $filename = time()."_".uniqid().'.'.$image->extension;
//            $imagePath = \Yii::$app->getUrlManager()->baseUrl."/uploads/".$filename;
//            move_uploaded_file($_FILES['image']['tmp_name'],$imagePath);
//        }

        //  move_uploaded_file($_FILES['image']['tmp_name'],$imagePath);
     //   $realimage = \Yii::$app->getUrlManager()->baseUrl . '/uploads/assetcheck/' . $image;
       // move_uploaded_file($_FILES['image']['tmp_name'],$imagePath);
//        $realimage = \Yii::getAlias('@frontend/web/').'uploads/assetcheck/' . $image;
//        file_put_contents($name, $realimage);

        $base64_string = $req_data['image'];
        $outputfile = "uploads/assetcheck/".time().".jpg" ;
        //save as image.jpg in uploads/ folder

        $filehandler = fopen($outputfile, 'wb' );
        //file open with "w" mode treat as text file
        //file open with "wb" mode treat as binary file

        fwrite($filehandler, base64_decode($base64_string));
        // we could add validation here with ensuring count($data)>1

        // clean up the file resource
        fclose($filehandler);


        return ['status' => 1, 'data' => $base64_string];

    }
}
