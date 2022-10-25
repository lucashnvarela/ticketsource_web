<?php

namespace frontend\models;

use Yii;

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
            [['id_user', 'id_bilhete'], 'required'],
            [['id_user', 'id_bilhete'], 'integer'],
            [['id_bilhete'], 'exist', 'skipOnError' => true, 'targetClass' => Bilhete::class, 'targetAttribute' => ['id_bilhete' => 'id']],
            [['id_user'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['id_user' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'id_user' => 'Id User',
            'id_bilhete' => 'Id Bilhete',
        ];
    }

    /**
     * Gets query for [[Bilhete]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getBilhete()
    {
        return $this->hasOne(Bilhete::class, ['id' => 'id_bilhete']);
    }

    /**
     * Gets query for [[User]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::class, ['id' => 'id_user']);
    }
}
