<?php

namespace frontend\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use frontend\models\Favorito;
use Yii;

/**
 * FavoritoSearch represents the model behind the search form of `frontend\models\Favorito`.
 */
class FavoritoSearch extends Favorito {

	public $searchstring;

	/**
	 * {@inheritdoc}
	 */
	public function rules() {
		return [
			[['id', 'id_user', 'id_evento'], 'integer'],
			[['searchstring'], 'safe'],

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
		$filter = Yii::$app->request->get('filter');

		if (isset($filter))
			$query = Favorito::find()
				->where(['id_user' => Yii::$app->user->id])
				->joinWith('evento')
				->where(['evento.categoria' => $filter]);
		else
			$query = Favorito::find()
				->where(['id_user' => Yii::$app->user->id]);


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
			'id_evento' => $this->id_evento,
		]);
		*/

		if (isset($filter))
			$query
				->joinWith('evento')
				->andFilterWhere(['like', 'evento.titulo', $this->searchstring]);
		else $query
			->joinWith('evento')
			->andFilterWhere([
				'or',
				['like', 'evento.titulo', $this->searchstring],
				['like', 'evento.categoria', $this->searchstring],
			]);

		return $dataProvider;
	}
}
