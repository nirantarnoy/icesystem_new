<?php

namespace backend\controllers;

use backend\models\PlansummarySearch;
use Yii;
use backend\models\Plan;
use backend\models\PlanSearch;
use yii\base\BaseObject;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * PlanController implements the CRUD actions for Plan model.
 */
class PlanController extends Controller
{
   public $enableCsrfValidation = false;
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST','GET'],
                ],
            ],
        ];
    }

    /**
     * Lists all Plan models.
     * @return mixed
     */
    public function actionIndex()
    {
        $pageSize = \Yii::$app->request->post("perpage");
        $searchModel = new PlanSearch();
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
     * Displays a single Plan model.
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

    public function actionCreate()
    {
        $company_id = 1;
        $branch_id = 1;
        if (!empty(\Yii::$app->user->identity->company_id)) {
            $company_id = \Yii::$app->user->identity->company_id;
        }
        if (!empty(\Yii::$app->user->identity->branch_id)) {
            $branch_id = \Yii::$app->user->identity->branch_id;
        }
        $model = new Plan();

        if ($model->load(Yii::$app->request->post())) {
            $product_id = \Yii::$app->request->post('line_prod_id');
            $qty = \Yii::$app->request->post('line_qty');
            $removelist = \Yii::$app->request->post('remove_list');

            $model->company_id = $company_id;
            $model->branch_id = $branch_id;
            $model->status = 1;
            $model->journal_no = $model->getLastNo(date('Y-m-d'), $company_id, $branch_id);
            if ($model->save()) {
                if ($product_id != null) {
                    for ($i = 0; $i <= count($product_id) - 1; $i++) {
                        if ($product_id[$i] == null || $product_id == '') continue;
                        $model_line = new \backend\models\Planline();
                        $model_line->plan_id = $model->id;
                        $model_line->product_id = $product_id[$i];
                        $model_line->qty = $qty[$i];
                        $model_line->status = 1;
                        $model_line->save();
                    }
                }
            }
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Plan model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $model_line = \backend\models\Planline::find()->where(['plan_id' => $id])->all();

        if ($model->load(Yii::$app->request->post())) {
            $product_id = \Yii::$app->request->post('line_prod_id');
            $qty = \Yii::$app->request->post('line_qty');
            $removelist = \Yii::$app->request->post('removelist');

            if ($model->save()) {
                if ($product_id != null) {
                    for ($i = 0; $i <= count($product_id) - 1; $i++) {
                        if ($product_id[$i] == null || $product_id == '') continue;

                        $model_check = \backend\models\Planline::find()->where(['plan_id' => $id, 'product_id' => $product_id[$i]])->one();
                        if ($model_check) {
                            $model_check->qty = $qty[$i];
                            $model_check->save();
                        } else {
                            $model_line = new \backend\models\Planline();
                            $model_line->plan_id = $model->id;
                            $model_line->product_id = $product_id[$i];
                            $model_line->qty = $qty[$i];
                            $model_line->status = 1;
                            $model_line->save();
                        }

                    }
                }
                if ($removelist != '') {
                    $x = explode(',', $removelist);
                    if (count($x) > 0) {
                        for ($m = 0; $m <= count($x) - 1; $m++) {
                            \common\models\PlanLine::deleteAll(['id' => $x[$m]]);
                        }
                    }
                }
            }
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
            'model_line' => $model_line,
        ]);
    }


    public function actionDelete($id)
    {
        if(\backend\models\Planline::deleteAll(['plan_id'=>$id])){
            $this->findModel($id)->delete();
        }


        return $this->redirect(['index']);
    }

    protected function findModel($id)
    {
        if (($model = Plan::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    public function actionCalsummary(){
        $pageSize = \Yii::$app->request->post("perpage");
        $searchModel = new PlansummarySearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $dataProvider->setSort(['defaultOrder' => ['id' => SORT_DESC]]);
        $dataProvider->pagination->pageSize = $pageSize;

        return $this->render('plansummary', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'perpage' => $pageSize,
        ]);
    }
}
