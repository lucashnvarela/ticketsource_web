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
    <div class="card signup-form shadow-sm">
        <div class="card-header bg-light text-center">
            <h4 class="card-title"><?= $this->title ?></h4>
            <h6 class="card-subtitle text-muted">Por favor preencha os seguintes campos</h6>
        </div>
        <div class="card-body text-left">
            <?php $form = ActiveForm::begin(['id' => 'form-signup']) ?>

            <?= $form->field($model_signup, 'username', [
                'options' => ['class' => 'form-group has-feedback'],
                'inputTemplate' => '{input}',
                'template' => '{beginWrapper}{label}{input}{error}{endWrapper}'
            ])
                ->label('Nome de utilizador')
                ->textInput() ?>

            <?= $form->field($model_signup, 'email', [
                'options' => ['class' => 'form-group has-feedback'],
                'inputTemplate' => '{input}',
                'template' => '{beginWrapper}{label}{input}{error}{endWrapper}'
            ])
                ->label('Email')
                ->textInput() ?>

            <?= $form->field($model_signup, 'password', [
                'options' => ['class' => 'form-group has-feedback'],
                'inputTemplate' => '{input}',
                'template' => '{beginWrapper}{label}{input}{error}{endWrapper}'
            ])
                ->label('Palavra-passe')
                ->passwordInput() ?>

            <div class="text-center">
                <?= Html::submitButton('Criar conta', ['class' => 'btn btn-success', 'name' => 'signup-button']) ?>
            </div>

            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>