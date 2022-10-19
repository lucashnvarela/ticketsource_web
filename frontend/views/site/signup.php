<?php

/** @var yii\web\View $this */
/** @var yii\bootstrap5\ActiveForm $form */
/** @var \frontend\model_signups\SignupForm $model_signup_signup */

use yii\bootstrap5\Html;
use yii\bootstrap5\ActiveForm;

$this->registerCssFile("@web/css/signup.css");

$this->title = 'Registo';
?>

<div class="col-4 offset-4">
    <div class="card signup-form">
        <div class="card-header bg-light text-center">
            <h4 class="card-title"><?= $this->title ?></h4>
            <h6 class="card-subtitle text-muted">Por favor preencha os seguintes campos</h6>
        </div>
        <div class="card-body">
            <?php $form = ActiveForm::begin(['id' => 'form-signup']) ?>

            <?= $form->field($model_signup, 'username', [
                'options' => ['class' => 'input-group has-feedback'],
                'template' => '<div class="input-group-prepend">
                <span class="input-group-text">{label}</span>
                </div>{input}{error}'
            ])
                ->label('Nome de utilizador :')
                ->textInput() ?>

            <?= $form->field($model_signup, 'email', [
                'options' => ['class' => 'input-group has-feedback'],
                'template' => '<div class="input-group-prepend">
                <span class="input-group-text">{label}</span>
                </div>{input}{error}'
            ])
                ->label('Email :')
                ->textInput() ?>

            <?= $form->field($model_signup, 'password', [
                'options' => ['class' => 'input-group has-feedback'],
                'template' => '<div class="input-group-prepend">
                <span class="input-group-text">{label}</span>
                </div>{input}{error}'
            ])
                ->label('Palavra-passe :')
                ->passwordInput() ?>

            <div class="text-center">
                <?= Html::submitButton('Signup', ['class' => 'btn btn-success ripple', 'name' => 'signup-button']) ?>
            </div>

            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>