<?php

/** @var \yii\web\View $this */
/** @var string $content */

use common\widgets\Alert;
use frontend\assets\AppAsset;
use yii\bootstrap5\Html;
use yii\bootstrap5\Nav;
use yii\bootstrap5\NavBar;

$this->registerCssFile("@web/css/themify-icons.css");
$this->registerCssFile("@web/css/main.css");

AppAsset::register($this);
?>
<?php $this->beginPage() ?>

<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>" class="h-100">

<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <?php $this->registerCsrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>

<body class="d-flex flex-column h-100">
    <?php $this->beginBody() ?>

    <header>
        <?php
        NavBar::begin([
            'brandLabel' => Html::img('@web/img/logo.png', ['class' => 'navbar-brand']),
            'brandUrl' => Yii::$app->homeUrl,
            'options' => [
                'class' => 'navbar navbar-expand-md bg-light fixed-top shadow-sm',
            ],
        ]);

        echo Nav::widget([
            'items' => [
                [
                    'label' => 'Eventos',
                    'items' => [
                        ['label' => 'Música', 'url' => ['#']],
                        ['label' => 'Festivais', 'url' => ['#']],
                        ['label' => 'Teatro', 'url' => ['#']],
                        ['label' => 'Desporto', 'url' => ['#']],
                    ],
                    'linkOptions' => ['class' => 'ti-ticket nav-link nav-event'],
                ],
            ],
            'options' => ['class' => 'navbar-nav ms-auto'],
        ]);

        /*
        echo Html::tag(
            'div',
            Html::tag('input', '', ['class' => 'form-control', 'type' => 'search', 'placeholder' => 'Pesquisar'])
                . Html::tag(
                    'button',
                    Html::tag('i', '', ['class' => 'fa fa-search']),
                    ['class' => 'btn btn-success btn-search', 'type' => 'submit']
                ),
            ['class' => 'input-group search-bar rounded']
        );
        */

        if (!Yii::$app->user->isGuest) {
            echo Html::a('Iniciar sessão / Registo', ['/site/login'], ['class' => 'btn btn-outline-success rounded-pill btn-login', 'name' => 'login-button']);

            /*
            echo Nav::widget([
                'items' => [
                    ['label' => 'Signup', 'url' => ['/site/signup']],
                    ['label' => 'Login', 'url' => ['/site/login']],
                ],
                'options' => ['class' => 'navbar-nav'],
            ]);
            */
        } else {
            echo Nav::widget([
                'items' => [
                    [
                        'label' => 'Carrinho',
                        'url' => ['#'],
                        'linkOptions' => ['class' => 'ti-shopping-cart nav-link nav-cart'],
                    ],
                    [
                        'label' => 'Minha conta',
                        'items' => [
                            ['label' => 'Bilhetes', 'url' => ['#']],
                            ['label' => 'Favoritos', 'url' => ['#']],
                            ['label' => 'Perfil', 'url' => ['#']],
                            '<hr class="dropdown-divider">',
                            ['label' => 'Logout', 'url' => ['/site/logout'], 'linkOptions' => ['data-method' => 'post']],
                        ],
                        'linkOptions' => ['class' => 'ti-user'],
                    ],
                ],
                'options' => ['class' => 'navbar-nav'],
            ]);
        }

        NavBar::end();
        ?>

    </header>

    <main role="main">
        <div class="main container">
            <?= Alert::widget() ?>
            <?= $content ?>
        </div>
    </main>

    <?php $this->endBody() ?>
</body>

</html>
<?php $this->endPage(); ?>