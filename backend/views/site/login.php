<?php

/** @var $this yii\web\View */
/** @var $form yii\bootstrap5\ActiveForm */
/** @var $model_login \common\models\LoginForm */

use yii\bootstrap5\Html;
use yii\bootstrap5\ActiveForm;
use common\widgets\Alert;

$this->registerCssFile("@web/css/site/login.css");

$this->title = 'Iniciar sessão';
?>

<div class="login-page">
    <div class="card login-form">
        <div class="card-header">
            <h5 class="title"><i class="fa-solid fa-user-check"></i> <?= $this->title ?></h5>
            <p class="subtitle">Por favor preencha os seguintes campos</p>
        </div>
        <div class="card-body">
            <?php
            $form = ActiveForm::begin(['id' => 'login-form']) ?>

            <?= $form->field($model_login, 'username', [
                'options' => ['class' => 'input-group has-feedback'],
                'template' => '<div class="input-group-prepend"><span class="input-group-text">{label}</span></div>{input}{error}'
            ])
                ->label('Nome de utilizador :')
                ->textInput() ?>

            <?= $form->field($model_login, 'password', [
                'options' => ['class' => 'input-group has-feedback'],
                'template' => '<div class="input-group-prepend"><span class="input-group-text">{label}</span></div>{input}{error}'
            ])
                ->label('Palavra-passe :')
                ->passwordInput() ?>

            <?= Html::submitButton('Login', ['class' => 'btn btn-success ripple', 'name' => 'login-button']) ?>

            <?php ActiveForm::end(); ?>
        </div>
    </div>
    <?= Alert::widget() ?>
</div>