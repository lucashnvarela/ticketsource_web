<?php

/** @var $this yii\web\View */
/** @var $form yii\bootstrap5\ActiveForm */
/** @var $model_signup \frontend\model_signups\SignupForm */

use yii\bootstrap5\Html;
use yii\bootstrap5\ActiveForm;

$this->registerCssFile("@web/css/site/signup.css");

$this->title = 'Registo';
?>

<div class="signup-page">
    <div class="card signup-form">
        <div class="card-header">
            <h5 class="title"><i class="fa-solid fa-user-plus"></i> <?= $this->title ?></h5>
            <p class="subtitle">Por favor preencha os seguintes campos</p>
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