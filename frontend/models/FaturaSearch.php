<?php

namespace frontend\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use frontend\models\Fatura;

/**
 * FaturaSearch represents the model behind the search form of `frontend\models\Fatura`.
 */
class FaturaSearch extends Fatura {

	public $searchstring;

	/**
	 * {@inheritdoc}
	 */
	public function rules() {
		return [
			[['id', 'id_user'], 'integer'],
			[['searchstring', 'data'], 'safe'],
			[['total'], 'number'],
		];
	}

	/**
	 * {@inheritdoc}
	 */
	public function scenarios() {
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
	public function search($params) {
		$query = Fatura::find()
			->where(['id_user' => \Yii::$app->user->id]);

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
		/*
        $query->andFilterWhere([
            'id' => $this->id,
            'id_user' => $this->id_user,
            'data' => $this->data,
            'total' => $this->total,
        ]);
		*/

		$query->andFilterWhere([
			'or',
			['like', 'data', $this->searchstring],
			['like', 'total', $this->searchstring],
		]);

		return $dataProvider;
	}
}
