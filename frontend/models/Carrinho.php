<?php

namespace frontend\models;

use Yii;
use common\models\User;
use common\models\Bilhete;

/**
 * This is the model class for table "carrinho".
 *
 * @property int $id
 * @property int $id_user
 * @property int $id_bilhete
 *
 * @property Bilhete $bilhete
 * @property User $user
 */
class Carrinho extends \yii\db\ActiveRecord {

	const VALOR_SEGURO = 1.25;

	/**
	 * {@inheritdoc}
	 */
	public static function tableName() {
		return 'carrinho';
	}

	/**
	 * {@inheritdoc}
	 */
	public function rules() {
		return [
			[['id_user'], 'required', 'message' => 'O campo {attribute} é obrigatório'],
			[['id_user'], 'integer', 'message' => 'O campo {attribute} deve ser um número inteiro'],
			[['id_user'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['id_user' => 'id']],

			[['id_bilhete'], 'required', 'message' => 'O campo {attribute} é obrigatório'],
			[['id_bilhete'], 'integer', 'message' => 'O campo {attribute} deve ser um número inteiro'],
			[['id_bilhete'], 'exist', 'skipOnError' => true, 'targetClass' => Bilhete::class, 'targetAttribute' => ['id_bilhete' => 'id']],
		];
	}

	/**
	 * {@inheritdoc}
	 */
	public function attributeLabels() {
		return [
			'id' => 'id',
			'id_user' => 'id_user',
			'id_bilhete' => 'id_bilhete',
		];
	}

	/**
	 * Retorna todos os bilhetes do carrinho do utilizador autenticado
	 * @return array
	 */
	public static function getUserCarrinho(): array {
		return Carrinho::find()
			->where(['id_user' => Yii::$app->user->id])
			->all();
	}

	/**
	 * Gets query for [[Bilhete]].
	 *
	 * @return \yii\db\ActiveQuery
	 */
	public function getBilhete() {
		return $this->hasOne(Bilhete::class, ['id' => 'id_bilhete']);
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
