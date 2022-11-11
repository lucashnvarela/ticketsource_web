<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "perfil".
 *
 * @property int $id_user
 * @property string $nome
 * @property int $nif
 * @property string $pais
 * @property string $distrito
 * @property string $morada
 * @property int $telefone
 *
 * @property User $user
 */
class Perfil extends \yii\db\ActiveRecord {
	const minLength = 99999999;
	const maxLength = 999999999;

	/**
	 * {@inheritdoc}
	 */
	public static function tableName() {
		return 'perfil';
	}

	/**
	 * {@inheritdoc}
	 */
	public function rules() {
		return [
			['nome', 'trim'],
			['nome', 'required', 'message' => 'Necessário introduzir um nome completo'],
			['nome', 'string', 'max' => 45],

			['nif', 'integer', 'message' => 'NIF inválido'],
			['nif', 'required', 'message' => 'Necessário introduzir o NIF'],
			['nif', 'unique', 'targetClass' => 'common\models\Perfil', 'message' => 'Já existe um utilizador com este NIF'],
			[
				'nif', 'integer',
				'min' => self::minLength, 'tooSmall' => 'NIF inválido',
				'max' => self::maxLength, 'tooBig' => 'NIF inválido'
			],

			['pais', 'trim'],
			['pais', 'required', 'message' => 'Necessário introduzir um país'],
			['pais', 'string', 'max' => 45],

			['distrito', 'trim'],
			['distrito', 'required', 'message' => 'Necessário introduzir um distrito'],
			['distrito', 'string', 'max' => 45],

			['morada', 'trim'],
			['morada', 'required', 'message' => 'Necessário introduzir uma morada'],
			['morada', 'string', 'max' => 90],

			['telefone', 'integer', 'message' => 'Número de telefone inválido'],
			['telefone', 'required', 'message' => 'Necessário introduzir um número de telefone'],
			['telefone', 'unique', 'targetClass' => 'common\models\Perfil', 'message' => 'Já existe um utilizador com este número de telefone'],
			[
				'telefone', 'integer',
				'min' => self::minLength, 'tooSmall' => 'Número de telefone inválido',
				'max' => self::maxLength, 'tooBig' => 'Número de telefone inválido'
			],

			['id_user', 'required'],
			['id_user', 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['id_user' => 'id']],
		];
	}

	/**
	 * {@inheritdoc}
	 */
	public function attributeLabels() {
		return [
			'nome' => 'Nome completo',
			'nif' => 'NIF',
			'pais' => 'Pais',
			'distrito' => 'Distrito',
			'morada' => 'Morada',
			'telefone' => 'Telefone',
		];
	}

	public static function addPerfil($user_id) {
		$model_perfil = new Perfil();
		$model_perfil->id_user = $user_id;
		return $model_perfil;
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
