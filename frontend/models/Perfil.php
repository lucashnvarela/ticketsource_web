<?php

namespace frontend\models;

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
class Perfil extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'perfil';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_user', 'nome', 'nif', 'pais', 'distrito', 'morada', 'telefone'], 'required'],
            [['id_user', 'nif', 'telefone'], 'integer'],
            [['nome', 'pais', 'distrito'], 'string', 'max' => 45],
            [['morada'], 'string', 'max' => 90],
            [['nif'], 'unique'],
            [['telefone'], 'unique'],
            [['id_user'], 'unique'],
            [['id_user'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['id_user' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id_user' => 'Id User',
            'nome' => 'Nome',
            'nif' => 'Nif',
            'pais' => 'Pais',
            'distrito' => 'Distrito',
            'morada' => 'Morada',
            'telefone' => 'Telefone',
        ];
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
