<?php

namespace common\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Evento;
use Yii;

/**
 * EventoSearch represents the model behind the search form of `common\models\Evento`.
 */
class EventoSearch extends Evento {

	public $searchstring;

	/**
	 * {@inheritdoc}
	 */
	public function rules() {
		return [
			[['searchstring', 'titulo', 'categoria'], 'safe'],
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

		if (isset($filter)) $query = Evento::find()->where(['categoria' => $filter]);
		else $query = Evento::find();

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
			'titulo' => $this->titulo,
			'categoria' => $this->categoria,
		]);
		*/

		if (isset($filter)) $query->andFilterWhere(['like', 'titulo', $this->searchstring]);
		else $query->andFilterWhere([
			'or',
			['like', 'titulo', $this->searchstring],
			['like', 'categoria', $this->searchstring],
		]);

		return $dataProvider;
	}
}
