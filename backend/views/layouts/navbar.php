<?php

/** @var yii\web\View $this */

use yii\bootstrap5\Html;
use yii\bootstrap5\Nav;
use yii\bootstrap5\NavBar;
use common\models\User;

$this->registerCssFile("@web/css/navbar.css");
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
                'label' => 'Dashboard',
                'url' => Yii::$app->homeUrl,
                'linkOptions' => ['class' => 'ti-dashboard nav-link link-dashboard'],
            ],
        ],
        'options' => ['class' => 'navbar-nav'],
    ]);

    if (!Yii::$app->authManager->getAssignment('admin', Yii::$app->user->id)) {
        echo Nav::widget([
            'items' => [
                [
                    'label' => 'Eventos',
                    'items' => [
                        ['label' => 'Lista de Eventos', 'url' => ['evento/index']],
                        ['label' => 'Adicionar Evento', 'url' => ['evento/create']],
                    ],
                    'linkOptions' => [
                        'class' => 'ti-ticket nav-link link-event'
                    ]
                ]

            ],
            'options' => ['class' => 'navbar-nav'],
        ]);
    } else {
        echo Nav::widget([
            'items' => [
                [
                    'label' => 'Utilizadores',
                    'items' => [
                        ['label' => 'Lista de Utlizadores', 'url' => ['user/index']],
                        ['label' => 'Adicionar Gestor', 'url' => ['site/signup']],
                    ],
                    'linkOptions' => [
                        'class' => 'ti-user nav-link link-user'
                    ]
                ]
            ],
            'options' => ['class' => 'navbar-nav'],
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