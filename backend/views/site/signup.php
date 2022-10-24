<?php

/** @var yii\web\View $this */
/** @var yii\bootstrap5\ActiveForm $form */
/** @var \frontend\model_signups\SignupForm $model_signup_signup */

use yii\bootstrap5\Html;
use yii\bootstrap5\ActiveForm;

$this->registerCssFile("@web/css/signup.css");

$this->title = 'Registo';
?>

<div class="h-100 d-flex flex-column justify-content-center align-items-center">
    <div class="card signup-form">
        <div class="card-header">
            <h4 class="card-title"><?= $this->title ?><br><span class="role">Gestor de Bilheteira</span></h4>
            <h6 class="card-subtitle">Por favor preencha os seguintes campos</h6>
        </div>
        <div class="card-body">
            <?php $form = ActiveForm::begin([
                'id' => 'form-signup',
                'options' => ['class' => 'd-flex flex-column align-items-center'],
            ]) ?>

            <?= $form->field($model_signup, 'username', [
                'options' => ['class' => 'input-group has-feedback'],
                'template' => '<div class="input-group-prepend"><span class="input-group-text">{label}</span></div>{input}{error}'
            ])
                ->label('Nome de utilizador :')
                ->textInput() ?>

            <?= $form->field($model_signup, 'email', [
                'options' => ['class' => 'input-group has-feedback'],
                'template' => '<div class="input-group-prepend"><span class="input-group-text">{label}</span></div>{input}{error}'
            ])
                ->label('Email :')
                ->textInput() ?>

            <?= $form->field($model_signup, 'password', [
                'options' => ['class' => 'input-group has-feedback'],
                'template' => '<div class="input-group-prepend"><span class="input-group-text">{label}</span></div>{input}{error}'
            ])
                ->label('Palavra-passe :')
                ->passwordInput() ?>

            <?= Html::submitButton('Signup', ['class' => 'btn btn-success ripple', 'name' => 'signup-button']) ?>

            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>