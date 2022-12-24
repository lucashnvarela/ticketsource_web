<?php

namespace common\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Sessao;

/**
 * SessaoSearch represents the model behind the search form of `common\models\Sessao`.
 */
class SessaoSearch extends Sessao {

	public $searchstring;

	/**
	 * {@inheritdoc}
	 */
	public function rules() {
		return [
			[['searchstring', 'data', 'localizacao'], 'safe'],
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

		if (isset($params['filter'])) {
			$query = Sessao::find()
				->where([array_keys($params)[1] => array_values($params)[1]])
				->joinWith('evento')
				->andWhere(['evento.categoria' => $params['filter']]);
		} else {
			$query = Sessao::find()
				->where([array_keys($params)[1] => array_values($params)[1]]);
		}

		// add conditions that should always apply here

		$dataProvider = new ActiveDataProvider(['query' => $query]);

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
			'id_evento' => $this->id_evento,
			'data' => $this->data,
			'numero_lugares' => $this->numero_lugares,
			'preco' => $this->preco,
		]);
		*/

		if (array_keys($params)[1] != 'data') {
			$query->andFilterWhere([
				'or',
				['like', 'data', $this->searchstring],
				['like', 'localizacao', $this->searchstring],
			]);
		} else $query
			->joinWith('evento')
			->andFilterWhere([
				'or',
				['like', 'localizacao', $this->searchstring],
				['like', 'evento.titulo', $this->searchstring],
				['like', 'evento.categoria', $this->searchstring],
			]);

		return $dataProvider;
	}
}
