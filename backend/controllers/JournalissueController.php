<?php

namespace backend\controllers;

use backend\models\LocationSearch;
use Yii;
use backend\models\Journalissue;
use backend\models\JournalissueSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * JournalissueController implements the CRUD actions for Journalissue model.
 */
class JournalissueController extends Controller
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
     * Lists all Journalissue models.
     * @return mixed
     */
    public function actionIndex()
    {
        $pageSize = \Yii::$app->request->post("perpage");
        $searchModel = new JournalissueSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $dataProvider->setSort(['defaultOrder' => ['id' => SORT_DESC]]);
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
        $model = new Journalissue();

        if ($model->load(Yii::$app->request->post())) {
            $prod_id = \Yii::$app->request->post('line_prod_id');
            $line_qty = \Yii::$app->request->post('line_qty');
            $line_issue_price = \Yii::$app->request->post('line_issue_line_price');

            $x_date = explode('/', $model->trans_date);
            $sale_date = date('Y-m-d');
            if (count($x_date) > 1) {
                $sale_date = $x_date[2] . '/' . $x_date[1] . '/' . $x_date[0];
            }
            $model->journal_no = $model->getLastNo($sale_date);
            $model->trans_date = date('Y-m-d', strtotime($sale_date));
            $model->status = 1;
            if ($model->save()) {
                if (count($prod_id) > 0) {
                    for ($i = 0; $i <= count($prod_id) - 1; $i++) {
                        if ($prod_id[$i] == '') continue;

                        $model_line = new \backend\models\Journalissueline();
                        $model_line->issue_id = $model->id;
                        $model_line->product_id = $prod_id[$i];
                        $model_line->qty = $line_qty[$i];
                        $model_line->sale_price = $line_issue_price[$i];
                        $model_line->status = 1;
                        $model_line->save();
                    }
                }
                return $this->redirect(['view', 'id' => $model->id]);
            }

        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $model_line = \backend\models\Journalissueline::find()->where(['issue_id' => $id])->all();

        if ($model->load(Yii::$app->request->post())) {
            $prod_id = \Yii::$app->request->post('line_prod_id');
            $line_qty = \Yii::$app->request->post('line_qty');
            $line_issue_price = \Yii::$app->request->post('line_issue_line_price');

            $x_date = explode('/', $model->trans_date);
            $sale_date = date('Y-m-d');
            if (count($x_date) > 1) {
                $sale_date = $x_date[2] . '/' . $x_date[1] . '/' . $x_date[0];
            }

            $model->trans_date = date('Y-m-d', strtotime($sale_date));
            $model->status = 1;
            if ($model->save()) {
                if (count($prod_id) > 0) {
                    for ($i = 0; $i <= count($prod_id) - 1; $i++) {
                        if ($prod_id[$i] == '') continue;

                        $model_chk = \backend\models\Journalissueline::find()->where(['issue_id' => $model->id, 'product_id' => $prod_id[$i]])->one();
                        if ($model_chk) {
                            $model_chk->qty = $line_qty[$i];
                            $model_chk->save();
                        } else {
                            $model_line = new \backend\models\Journalissueline();
                            $model_line->issue_id = $model->id;
                            $model_line->product_id = $prod_id[$i];
                            $model_line->qty = $line_qty[$i];
                            $model_line->sale_price = $line_issue_price[$i];
                            $model_line->status = 1;
                            $model_line->save();
                        }
                    }
                }
                return $this->redirect(['view', 'id' => $model->id]);
            }
        }

        return $this->render('update', [
            'model' => $model,
            'model_line' => $model_line
        ]);
    }

    public function actionDelete($id)
    {
        if ($this->findModel($id)->delete()) {
            \backend\models\Journalissueline::deleteAll(['issue_id' => $id]);
        }

        return $this->redirect(['index']);
    }

    protected function findModel($id)
    {
        if (($model = Journalissue::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    public function actionFindPricegroup()
    {
        $html = '';
        $route_id = \Yii::$app->request->post('route_id');
        $price_group_list = [];

        if ($route_id > 0) {
            $model = \backend\models\Customer::find()->select(['customer_type_id'])->where(['delivery_route_id' => $route_id])->groupBy('customer_type_id')->one();
            if ($model) {
                $model_prod_price = \common\models\QueryCategoryPrice::find()->where(['customer_type_id' => $model->customer_type_id])->all();
                if ($model_prod_price) {
                    foreach ($model_prod_price as $value) {
                        $html .= '<tr>';
                        $html .= '<td>
                                <input type="hidden" class="line-prod-id" name="line_prod_id[]"
                                       value="' . $value->product_id . '">
                                ' . $value->code . '
                            </td>';
                        $html .= ' <td>' . $value->name . '</td>';
                        $html .= '
                                <td>
                                <input type="hidden" class="line-issue-sale-price" name="line_issue_line_price[]" value="'.$value->sale_price.'">
                                <input type="number" class="line-qty form-control" name="line_qty[]" value="0" min="0">
                                </td>
                                <td style="text-align: center">
                                    <div class="btn btn-danger btn-sm" onclick="deleteline($(this))"><i
                                                class="fa fa-trash"></i>
                                    </div>
                                </td>
                                ';
                        $html .= '</tr>';
                    }
                }
            }
        }

        return $html;
    }
}