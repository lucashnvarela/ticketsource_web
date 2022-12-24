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
			['nome', 'required', 'message' => 'O campo {attribute} é obrigatório'],
			['nome', 'string', 'max' => 45],

			['nif', 'integer', 'message' => 'O campo {attribute} é inválido'],
			['nif', 'required', 'message' => 'O campo {attribute} é obrigatório'],
			['nif', 'unique', 'targetClass' => 'common\models\Perfil', 'message' => 'Já existe um utilizador com este NIF'],
			['nif', 'match', 'pattern' => '/^[0-9]{9}$/', 'message' => 'O campo {attribute} é inválido'],

			['pais', 'trim'],
			['pais', 'required', 'message' => 'O campo {attribute} é obrigatório'],
			['pais', 'string', 'max' => 45],

			['distrito', 'trim'],
			['distrito', 'required', 'message' => 'O campo {attribute} é obrigatóri'],
			['distrito', 'string', 'max' => 45],

			['morada', 'trim'],
			['morada', 'required', 'message' => 'O campo {attribute} é obrigatório'],
			['morada', 'string', 'max' => 90],

			['telefone', 'integer', 'message' => 'O campo {attribute} é inválido'],
			['telefone', 'required', 'message' => 'O campo {attribute} é obrigatório'],
			['telefone', 'unique', 'targetClass' => 'common\models\Perfil', 'message' => 'Já existe um utilizador com este número de telefone'],
			['telefone', 'match', 'pattern' => '/^[0-9]{9}$/', 'message' => 'O campo {attribute} é inválido'],

			['id_user', 'required', 'message' => 'O campo {attribute} é obrigatório'],
			['id_user', 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['id_user' => 'id']],
		];
	}

	/**
	 * {@inheritdoc}
	 */
	public function attributeLabels() {
		return [
			'nome' => 'nome completo',
			'nif' => 'NIF',
			'pais' => 'país',
			'distrito' => 'distrito',
			'morada' => 'morada',
			'telefone' => 'número de telefone',
		];
	}

	public static function addPerfil($id_user) {
		$model_perfil = new Perfil();
		$model_perfil->id_user = $id_user;
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
