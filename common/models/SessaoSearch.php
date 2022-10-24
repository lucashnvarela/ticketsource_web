<?php

namespace common\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Sessao;

/**
 * SessaoSearch represents the model behind the search form of `common\models\Sessao`.
 */
class SessaoSearch extends Sessao
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'evento_id', 'lugares_disponiveis'], 'integer'],
            [['data', 'localizacao'], 'safe'],
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
        $query = Sessao::find();

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
            'evento_id' => $this->evento_id,
            'data' => $this->data,
            'lugares_disponiveis' => $this->lugares_disponiveis,
        ]);

        $query->andFilterWhere(['like', 'localizacao', $this->localizacao]);

        return $dataProvider;
    }
}
