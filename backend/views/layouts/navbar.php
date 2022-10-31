<?php

/** @var yii\web\View $this */

use yii\bootstrap5\Html;
use yii\bootstrap5\Nav;
use yii\bootstrap5\NavBar;
use common\models\User;

$this->registerCssFile("@web/css/layouts/navbar.css");
?>

<header>
    <?php
    NavBar::begin([
        'options' => [
            'class' => 'navbar navbar-expand-lg fixed-top',
        ],
    ]);

    echo Nav::widget([
        'items' => [
            [
                'label' => '<i class="fa-solid fa-chart-column"></i> Dashboard',
                'url' => Yii::$app->homeUrl,
                'linkOptions' => ['class' => 'nav-link link-dashboard'],
                'encode' => false
            ],

        ],
        'options' => ['class' => 'navbar-nav'],
    ]);

    if (!Yii::$app->authManager->getAssignment('admin', Yii::$app->user->id)) {
        echo Nav::widget([
            'items' => [
                [
                    'label' => '<i class="fa-regular fa-calendar-days"></i> Calendario de Eventos',
                    'url' => ['sessao/index', 'month' => date('n'), 'year' => date('Y')],
                    'linkOptions' => ['class' => 'nav-link link-eventos'],
                    'encode' => false
                ],
                [
                    'label' => '<i class="fa-regular fa-calendar-plus"></i> Registar Novo Evento',
                    'url' => ['evento/create'],
                    'linkOptions' => ['class' => 'nav-link link-create-evento'],
                    'encode' => false
                ],
            ],
            'options' => ['class' => 'navbar-nav nav-gestor'],
        ]);
    } else {
        echo Nav::widget([
            'items' => [
                [
                    'label' => '<i class="fa-solid fa-users"></i> Lista de Utilizadores',
                    'url' => ['user/index'],
                    'linkOptions' => ['class' => 'nav-link link-users'],
                    'encode' => false
                ],
                [
                    'label' => '<i class="fa-solid fa-user-plus"></i> Registar Novo Gestor',
                    'url' => ['site/signup'],
                    'linkOptions' => ['class' => 'nav-link link-create-gestor'],
                    'encode' => false
                ],
            ],
            'options' => ['class' => 'navbar-nav nav-admin'],
        ]);
    }

    echo Nav::widget([
        'items' => [
            '<li class="nav-item">
				<span id="username">(' . User::findOne(Yii::$app->user->id)->username . ')</span>' .
                Html::a('Logout', ['site/logout'], ['data-method' => 'post', 'class' => 'nav-link link-logout']) .
                '</li>'
        ],
        'options' => ['class' => 'navbar-nav ms-auto nav-logout'],
    ]);

    NavBar::end();
    ?>
</header>