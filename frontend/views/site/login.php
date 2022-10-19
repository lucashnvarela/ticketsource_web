<?php

/** @var yii\web\View $this */
/** @var yii\bootstrap5\ActiveForm $form */
/** @var \common\models\LoginForm $model_login */

use yii\bootstrap5\Html;
use yii\bootstrap5\ActiveForm;

$this->registerCssFile("@web/css/login.css");

$this->title = 'Iniciar sessão';
?>

<div class="col-4 offset-4">
    <div class="card login-form">
        <div class="card-header bg-light text-center">
            <h4 class="card-title"><?= $this->title ?></h4>
            <h6 class="card-subtitle text-muted">Por favor preencha os seguintes campos</h6>
        </div>
        <div class="card-body">
            <?php $form = ActiveForm::begin(['id' => 'login-form']) ?>

            <?= $form->field($model_login, 'username', [
                'options' => ['class' => 'input-group has-feedback'],
                'template' => '<div class="input-group-prepend">
                <span class="input-group-text">{label}</span>
                </div>{input}{error}'
            ])
                ->label('Nome de utilizador :')
                ->textInput() ?>

            <?= $form->field($model_login, 'password', [
                'options' => ['class' => 'input-group has-feedback'],
                'template' => '<div class="input-group-prepend">
                <span class="input-group-text">{label}</span>
                </div>{input}{error}'
            ])
                ->label('Palavra-passe :')
                ->passwordInput() ?>

            <div class="text-center">
                <?= Html::submitButton('Login', ['class' => 'btn btn-success ripple', 'name' => 'login-button']) ?>
            </div>

            <?php ActiveForm::end(); ?>
        </div>
        <div class="card-footer text-center">
            <h6>Ainda não tem conta ticketsource? <?= Html::a('Registe-se já', ['/site/signup'], ['class' => 'btn-signup', 'name' => 'signup-link']) ?></h6>
        </div>
    </div>
</div>