<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "sessao".
 *
 * @property int $id
 * @property int $evento_id
 * @property string|null $data
 * @property string|null $localizacao
 * @property int|null $lugares_disponiveis
 *
 * @property Bilhete[] $bilhetes
 * @property Evento $evento
 */
class Sessao extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'sessao';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'evento_id'], 'required'],
            [['id', 'evento_id', 'lugares_disponiveis'], 'integer'],
            [['data'], 'safe'],
            [['localizacao'], 'string', 'max' => 45],
            [['id'], 'unique'],
            [['evento_id'], 'exist', 'skipOnError' => true, 'targetClass' => Evento::class, 'targetAttribute' => ['evento_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'evento_id' => 'Evento ID',
            'data' => 'Data',
            'localizacao' => 'Localizacao',
            'lugares_disponiveis' => 'Lugares Disponiveis',
        ];
    }

    /**
     * Gets query for [[Bilhetes]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getBilhetes()
    {
        return $this->hasMany(Bilhete::class, ['id_sessao' => 'id']);
    }

    /**
     * Gets query for [[Evento]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getEvento()
    {
        return $this->hasOne(Evento::class, ['id' => 'evento_id']);
    }
}
