<?php

/** @var yii\web\View $this */
/** @var yii\bootstrap5\ActiveForm $form */
/** @var \common\models\LoginForm $model_login */

use yii\bootstrap5\Html;
use yii\bootstrap5\ActiveForm;

$this->registerCssFile("@web/css/login.css");

$this->title = 'Login';
?>

<div class="col-4 offset-4">
    <div class="card login-form shadow-sm">
        <div class="card-header bg-light text-center">
            <h4 class="card-title"><?= $this->title ?></h4>
            <h6 class="card-subtitle text-muted">Por favor preencha os seguintes campos</h6>
        </div>
        <div class="card-body text-left">
            <?php $form = ActiveForm::begin(['id' => 'login-form']) ?>

            <?= $form->field($model_login, 'username', [
                'options' => ['class' => 'form-group has-feedback'],
                'inputTemplate' => '{input}',
                'template' => '{beginWrapper}{label}{input}{error}{endWrapper}'
            ])
                ->label('Nome de utilizador')
                ->textInput() ?>

            <?= $form->field($model_login, 'password', [
                'options' => ['class' => 'form-group has-feedback'],
                'inputTemplate' => '{input}<div class="input-group-append"></div>',
                'template' => '{beginWrapper}{label}{input}{error}{endWrapper}'
            ])
                ->label('Palavra-passe')
                ->passwordInput() ?>

            <div class="text-center">
                <?= Html::submitButton('Login', ['class' => 'btn btn-success', 'name' => 'login-button']) ?>
            </div>

            <?php ActiveForm::end(); ?>
        </div>
        <div class="card-footer text-center">
            <h5>Ainda não tem conta ticketsource? </h5>
            <h6>O registo na plataforma ticketsource permite-lhe acompanhar as suas compras na área de cliente.</h6>

            <?= Html::a('Registar', ['/site/signup'], ['class' => 'btn btn-success', 'name' => 'signup-button']) ?>
        </div>
    </div>
</div>