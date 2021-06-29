<?php

namespace backend\models;


use common\models\QueryPlan;
use yii\base\BaseObject;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use yii\web\Session;

class PlansummarySearch extends QueryPlan
{
    public $globalSearch;

    public function rules()
    {
        return [
            [['id', 'customer_id',], 'integer'],
            [['journal_no', 'trans_date'], 'safe'],
            [['globalSearch'], 'string']
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    public function search($params)
    {
        $query = QueryPlan::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }


//        if (!empty(\Yii::$app->user->identity->company_id)) {
//            $query->andFilterWhere(['plan.company_id' => \Yii::$app->user->identity->company_id]);
//        }
//        if (!empty(\Yii::$app->user->identity->branch_id)) {
//            $query->andFilterWhere(['plan.branch_id' => \Yii::$app->user->identity->branch_id]);
//        }


//        $sale_date = null;
//        if ($this->trans_date != null) {
//            $x_date = explode('/', $this->trans_date);
//            $sale_date = date('Y-m-d');
//            if (count($x_date) > 1) {
//                $sale_date = $x_date[2] . '/' . $x_date[1] . '/' . $x_date[0];
//            }
//            $this->trans_date = date('Y-m-d', strtotime($sale_date));
//            $query->andFilterWhere(['date(trans_date)' => date('Y-m-d', strtotime($sale_date))]);
//        }else{
//            $this->trans_date = date('Y-m-d');
//            $query->andFilterWhere(['date(trans_date)' => date('Y-m-d')]);
//        }

        if ($this->globalSearch != '') {
            $query
                ->orFilterWhere(['like', 'code', $this->globalSearch])
                ->orFilterWhere(['like', 'customer_name', $this->globalSearch])
                ->orFilterWhere(['like', 'customer_code', $this->globalSearch]);
        }


        return $dataProvider;
    }
}
