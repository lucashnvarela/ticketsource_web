<?php

namespace frontend\models;

use Yii;
use common\models\Evento;
use common\models\User;

/**
 * This is the model class for table "favorito".
 *
 * @property int $id
 * @property int $id_user
 * @property int $id_evento
 *
 * @property \common\models\Evento $evento
 * @property \common\models\User $user
 */
class Favorito extends \yii\db\ActiveRecord {
	/**
	 * {@inheritdoc}
	 */
	public static function tableName() {
		return 'favorito';
	}

	/**
	 * {@inheritdoc}
	 */
	public function rules() {
		return [
			[['id_evento'], 'required', 'message' => 'O campo {attribute} é obrigatório'],
			[['id_evento'], 'integer', 'message' => 'O campo {attribute} deve ser um número inteiro'],
			[['id_evento'], 'exist', 'skipOnError' => true, 'targetClass' => Evento::class, 'targetAttribute' => ['id_evento' => 'id']],

			[['id_user'], 'required', 'message' => 'O campo {attribute} é obrigatório'],
			[['id_user'], 'integer', 'message' => 'O campo {attribute} deve ser um número inteiro'],
			[['id_user'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['id_user' => 'id']],
		];
	}

	/**
	 * {@inheritdoc}
	 */
	public function attributeLabels() {
		return [
			'id' => 'id',
			'id_user' => 'id_user',
			'id_evento' => 'id_evento',
		];
	}

	/**
	 * Elimina um favorito
	 * @param int $id_user id do utilizador que deseja eliminar o favorito
	 * @param int $id_evento id do evento a eliminar
	 * @return bool True se o favorito foi eliminado com sucesso, False caso contrário
	 */
	public static function deleteUserFavorito($id_user, $id_evento): bool {
		return Favorito::find()
			->where(['id_user' => $id_user])
			->andWhere(['id_evento' => $id_evento])
			->delete();
	}

	/**
	 * Retorna todos os eventos favoritos do utilizador
	 * @param int $id_user id do utilizador
	 * @return array
	 */
	public static function getUserFavoritos($id_user): array {
		$user_favoritos = Evento::find()
			->joinWith('favorito')
			->where(['favorito.id_user' => $id_user])
			->andWhere(['favorito.id_evento' => 'evento.id'])
			->all();

		return $user_favoritos;
	}

	/**
	 * Gets query for [[Evento]].
	 *
	 * @return \yii\db\ActiveQuery
	 */
	public function getEvento() {
		return $this->hasOne(Evento::class, ['id' => 'id_evento']);
	}

	/**
	 * Gets query for [[User]].
	 *
	 * @return \yii\db\ActiveQuery
	 */
	public function getUser() {
		return $this->hasOne(User::class, ['id' => 'id_user']);
	}
}
