<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "carrinho".
 *
 * @property int $id
 * @property int $user_id
 * @property int $bilhete_id
 *
 * @property Bilhete $bilhete
 * @property User $user
 */
class Carrinho extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'carrinho';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'user_id', 'bilhete_id'], 'required'],
            [['id', 'user_id', 'bilhete_id'], 'integer'],
            [['id'], 'unique'],
            [['bilhete_id'], 'exist', 'skipOnError' => true, 'targetClass' => Bilhete::class, 'targetAttribute' => ['bilhete_id' => 'id']],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['user_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'User ID',
            'bilhete_id' => 'Bilhete ID',
        ];
    }

    /**
     * Gets query for [[Bilhete]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getBilhete()
    {
        return $this->hasOne(Bilhete::class, ['id' => 'bilhete_id']);
    }

    /**
     * Gets query for [[User]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::class, ['id' => 'user_id']);
    }
}
