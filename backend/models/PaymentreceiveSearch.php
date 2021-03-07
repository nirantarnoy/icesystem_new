<?php

namespace backend\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\Paymentreceive;

/**
 * PaymentreceiveSearch represents the model behind the search form of `backend\models\Paymentreceive`.
 */
class PaymentreceiveSearch extends Paymentreceive
{
    public $globalSearch;

    public function rules()
    {
        return [
            [['id', 'customer_id', 'created_at', 'crated_by', 'updated_at', 'updated_by', 'status'], 'integer'],
            [['trans_date', 'journal_no'], 'safe'],
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

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = Paymentreceive::find();

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

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'trans_date' => $this->trans_date,
            'customer_id' => $this->customer_id,
            'created_at' => $this->created_at,
            'crated_by' => $this->crated_by,
            'updated_at' => $this->updated_at,
            'updated_by' => $this->updated_by,
            'status' => $this->status,
        ]);

        if ($this->globalSearch != '') {
            $query->orFilterWhere(['like', 'journal_no', $this->globalSearchs]);

        }

        return $dataProvider;
    }
}
