<?php

namespace backend\models;

use common\models\QuerySalePosData;
use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * SalegroupSearch represents the model behind the search form of `backend\models\Salegroup`.
 */
class SaleposdataSearch extends QuerySalePosData
{
    public $globalSearch;

    public function rules()
    {
        return [
            [['code', 'name','line_total'], 'safe'],
            [['globalSearch'], 'string']
        ];
    }

    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    public function search($params)
    {
        $query = QuerySalePosData::find();

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
//        $query->andFilterWhere([
//            'id' => $this->id,
//            'status' => $this->status,
//            'created_at' => $this->created_at,
//            'created_by' => $this->created_by,
//            'updated_at' => $this->updated_at,
//            'updated_by' => $this->updated_by,
//        ]);
//        if ($this->globalSearch != '') {
//            $query->orFilterWhere(['like', 'code', $this->globalSearch])
//                ->orFilterWhere(['like', 'name', $this->globalSearch]);
//        }
        return $dataProvider;
    }
}
