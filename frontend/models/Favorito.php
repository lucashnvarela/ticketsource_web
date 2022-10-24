<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "favorito".
 *
 * @property int $id
 * @property int $id_user
 * @property int $id_evento
 *
 * @property Evento $evento
 * @property User $user
 */
class Favorito extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'favorito';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'id_user', 'id_evento'], 'required'],
            [['id', 'id_user', 'id_evento'], 'integer'],
            [['id'], 'unique'],
            [['id_evento'], 'exist', 'skipOnError' => true, 'targetClass' => Evento::class, 'targetAttribute' => ['id_evento' => 'id']],
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
            'id_evento' => 'Id Evento',
        ];
    }

    /**
     * Gets query for [[Evento]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getEvento()
    {
        return $this->hasOne(Evento::class, ['id' => 'id_evento']);
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
