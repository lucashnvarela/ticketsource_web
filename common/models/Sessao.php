<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "sessao".
 *
 * @property int $id
 * @property int $id_evento
 * @property string $data
 * @property string $localizacao
 * @property int $lugares_disponiveis
 *
 * @property Bilhete[] $bilhetes
 * @property Evento $evento
 */
class Sessao extends \yii\db\ActiveRecord {
    /**
     * {@inheritdoc}
     */
    public static function tableName() {
        return 'sessao';
    }

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
            [['id_evento', 'data', 'localizacao', 'lugares_disponiveis'], 'required'],
            [['id_evento', 'lugares_disponiveis'], 'integer'],
            [['data'], 'safe'],
            [['localizacao'], 'string', 'max' => 45],
            [['id_evento'], 'exist', 'skipOnError' => true, 'targetClass' => Evento::class, 'targetAttribute' => ['id_evento' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels() {
        return [
            'id' => 'ID',
            'id_evento' => 'Id Evento',
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
    public function getBilhetes() {
        return $this->hasMany(Bilhete::class, ['id_sessao' => 'id']);
    }

    /**
     * Gets query for [[Evento]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getEvento() {
        return $this->hasOne(Evento::class, ['id' => 'id_evento']);
    }
}
