<?php

namespace common\models;

use Yii;
use yii\base\NotSupportedException;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\web\IdentityInterface;

/**
 * User model
 *
 * @property integer $id
 * @property string $username
 * @property string $password_hash
 * @property string $password_reset_token
 * @property string $verification_token
 * @property string $email
 * @property string $auth_key
 * @property integer $status
 * @property integer $created_at
 * @property integer $updated_at
 * @property string $password write-only password
 */
class User extends ActiveRecord implements IdentityInterface {
	const STATUS_DELETED = 0;
	const STATUS_INACTIVE = 9;
	const STATUS_ACTIVE = 10;

	const ROLE_ADMIN = 'admin';
	const ROLE_GESTOR = 'gestorBilheteira';
	const ROLE_CLIENTE = 'cliente';

	/**
	 * {@inheritdoc}
	 */
	public static function tableName() {
		return '{{%user}}';
	}

	/**
	 * {@inheritdoc}
	 */
	public function behaviors() {
		return [
			TimestampBehavior::class,
		];
	}

	/**
	 * {@inheritdoc}
	 */
	public function rules() {
		return [
			['status', 'default', 'value' => self::STATUS_ACTIVE],
			['status', 'in', 'range' => [self::STATUS_ACTIVE, self::STATUS_INACTIVE, self::STATUS_DELETED]],
		];
	}

	/**
	 * Retorna true se o utilizador tiver um perfil, false caso contrário
	 * @return bool 
	 */
	public static function hasPerfil(): bool {
		return Perfil::find()
			->where(['id_user' => Yii::$app->user->id])
			->exists();
	}

	/**
	 * Retorna o status do utilizador autenticado
	 * @return string
	 */
	public function getStatus(): string {
		$status_list = [
			0 => 'eliminado',
			9 => 'inativo',
			10 => 'ativo',
		];

		return $status_list[$this->status];
	}

	/**
	 * Define o status do utilizador como inativo
	 * @return bool
	 */
	public function setInactive(): bool {
		$this->status = self::STATUS_INACTIVE;
		return $this->save();
	}

	/**
	 * Retorna true se o utilizador estiver com o status a inativo, false caso contrário
	 * @return bool
	 */
	public function isInactive(): bool {
		return $this->status == self::STATUS_INACTIVE;
	}

	/**
	 * Define o status do utilizador como ativo
	 * @return bool
	 */
	public function setActive(): bool {
		$this->status = self::STATUS_ACTIVE;
		return $this->save();
	}

	/**
	 * Retorna true se o utilizador estiver com o status a ativo, false caso contrário
	 * @return bool 
	 */
	public function isActive(): bool {
		return $this->status == self::STATUS_ACTIVE;
	}

	/**
	 * Define o status do utilizador como eliminado
	 * @return bool
	 */
	public function setDeleted(): bool {
		$this->status = self::STATUS_DELETED;
		return $this->save();
	}

	/**
	 * Retorna true se o utilizador estiver com o status a eliminado, false caso contrário
	 * @return bool
	 */
	public function isDeleted(): bool {
		return $this->status == self::STATUS_DELETED;
	}

	/**
	 * Retorna true se o utilizador for cliente, false caso contrário
	 * @return bool
	 */
	public function isCliente(): bool {
		return Yii::$app->authManager->getAssignment(User::ROLE_CLIENTE, $this->id) != null ? true : false;
	}

	/**
	 * Retorna true se o utilizador for gestor de bilheteira, false caso contrário
	 * @return bool
	 */
	public function isGestor(): bool {
		return Yii::$app->authManager->getAssignment(User::ROLE_GESTOR, $this->id) != null ? true : false;
	}

	/**
	 * Retorna true se o utilizador for admin, false caso contrário
	 * @return bool
	 */
	public function isAdmin(): bool {
		return Yii::$app->authManager->getAssignment(User::ROLE_ADMIN, $this->id) != null ? true : false;
	}

	/**
	 * Retorna um array com as classes dos icons e ordenação para as colunas username, created_at e status
	 * @return array
	 */
	public static function tableSort($sort_orders) {
		$attr = array_keys($sort_orders)[0];
		$sort = array_values($sort_orders)[0];

		$columns = ['username', 'created_at', 'status'];
		$fontawesome = [
			'DEFAULT' => 'fas fa-arrow-right-arrow-left',
			'DESC' => [
				'A-Z' => 'fas fa-arrow-up-z-a',
				'1-9' => 'fas fa-arrow-down-9-1',
			],
			'ASC' => [
				'A-Z' => 'fas fa-arrow-down-a-z',
				'1-9' => 'fas fa-arrow-up-1-9',
			]
		];

		$sort_config = array();
		foreach ($columns as $label) {
			if ($label != $attr) {
				$sort_config[$label] = [
					'class' => $fontawesome['DEFAULT'],
					'sort' => $label != 'username' ? '-' . $label : $label,
				];
			} else {
				$sort_config[$label] = [
					'class' => $fontawesome[$sort != SORT_ASC ?
						($attr != 'status' ? 'DESC' : 'ASC') : ($attr != 'status' ? 'ASC' : 'DESC')][$label != 'created_at' ? 'A-Z' : '1-9'],
					'sort' => $sort != SORT_ASC ? $label : '-' . $label,
				];
			}
		}

		return $sort_config;
	}

	/**
	 * @brif Gets query for [[Perfil]].
	 *
	 * @return \yii\db\ActiveQuery
	 */
	public function getPerfil() {
		return $this->hasOne(Perfil::class, ['id_user' => 'id']);
	}

	/**
	 * {@inheritdoc}
	 */
	public static function findIdentity($id) {
		return static::findOne(['id' => $id, 'status' => self::STATUS_ACTIVE]);
	}

	/**
	 * {@inheritdoc}
	 */
	public static function findIdentityByAccessToken($token, $type = null) {
		throw new NotSupportedException('"findIdentityByAccessToken" is not implemented.');
	}

	/**
	 * Finds user by username
	 *
	 * @param string $username
	 * @return static|null
	 */
	public static function findByUsername($username) {
		return static::findOne(['username' => $username]);
	}

	/**
	 * Finds user by password reset token
	 *
	 * @param string $token password reset token
	 * @return static|null
	 */
	public static function findByPasswordResetToken($token) {
		if (!static::isPasswordResetTokenValid($token)) {
			return null;
		}

		return static::findOne([
			'password_reset_token' => $token,
			'status' => self::STATUS_ACTIVE,
		]);
	}

	/**
	 * Finds user by verification email token
	 *
	 * @param string $token verify email token
	 * @return static|null
	 */
	public static function findByVerificationToken($token) {
		return static::findOne([
			'verification_token' => $token,
			'status' => self::STATUS_INACTIVE
		]);
	}

	/**
	 * Finds out if password reset token is valid
	 *
	 * @param string $token password reset token
	 * @return bool
	 */
	public static function isPasswordResetTokenValid($token) {
		if (empty($token)) {
			return false;
		}

		$timestamp = (int) substr($token, strrpos($token, '_') + 1);
		$expire = Yii::$app->params['user.passwordResetTokenExpire'];
		return $timestamp + $expire >= time();
	}

	/**
	 * {@inheritdoc}
	 */
	public function getId() {
		return $this->getPrimaryKey();
	}

	/**
	 * {@inheritdoc}
	 */
	public function getAuthKey() {
		return $this->auth_key;
	}

	/**
	 * {@inheritdoc}
	 */
	public function validateAuthKey($authKey) {
		return $this->getAuthKey() === $authKey;
	}

	/**
	 * Validates password
	 *
	 * @param string $password password to validate
	 * @return bool if password provided is valid for current user
	 */
	public function validatePassword($password) {
		return Yii::$app->security->validatePassword($password, $this->password_hash);
	}

	/**
	 * Generates password hash from password and sets it to the model
	 *
	 * @param string $password
	 */
	public function setPassword($password) {
		$this->password_hash = Yii::$app->security->generatePasswordHash($password);
	}

	/**
	 * Generates "remember me" authentication key
	 */
	public function generateAuthKey() {
		$this->auth_key = Yii::$app->security->generateRandomString();
	}

	/**
	 * Generates new password reset token
	 */
	public function generatePasswordResetToken() {
		$this->password_reset_token = Yii::$app->security->generateRandomString() . '_' . time();
	}

	/**
	 * Generates new token for email verification
	 */
	public function generateEmailVerificationToken() {
		$this->verification_token = Yii::$app->security->generateRandomString() . '_' . time();
	}

	/**
	 * Removes password reset token
	 */
	public function removePasswordResetToken() {
		$this->password_reset_token = null;
	}
}
