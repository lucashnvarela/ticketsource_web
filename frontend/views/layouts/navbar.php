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
		'brandLabel' => Html::img('@web/img/logo.png', ['class' => 'navbar-brand']),
		'brandUrl' => Yii::$app->homeUrl,
		'options' => [
			'class' => 'navbar navbar-expand-xl',
		],
	]);

	echo Nav::widget([
		'items' => [
			[
				'label' => '<ion-icon name="home-outline"></ion-icon> Home',
				'url' => ['site/index'],
				'linkOptions' => ['class' => 'nav-link link-home'],
				'encode' => false
			],
			[
				'label' => '<ion-icon name="calendar-outline"></ion-icon> Eventos',
				'url' => ['evento/index'],
				'linkOptions' => ['class' => 'nav-link link-eventos'],
				'encode' => false
			],
		],
		'options' => ['class' => 'navbar-nav me-auto nav-eventos'],
	]);

	if (Yii::$app->user->isGuest) {
		echo Nav::widget([
			'items' => [
				[
					'label' => '<ion-icon name="log-in-outline"></ion-icon>  Iniciar sessão',
					'url' => ['site/login'],
					'linkOptions' => ['class' => 'nav-link link-login'],
					'encode' => false
				],
			],
			'options' => ['class' => 'navbar-nav ms-auto nav-guest'],
		]);
	} else {
		echo Nav::widget([
			'items' => [
				[
					'label' => '<ion-icon name="cart-outline"></ion-icon> Carrinho',
					'url' => ['carrinho/index'],
					'linkOptions' => ['class' => 'nav-link link-cart'],
					'encode' => false
				],
				[
					'label' => '<ion-icon name="heart-outline"></ion-icon> Favoritos',
					'url' => ['favorito/index'],
					'linkOptions' => ['class' => 'nav-link link-wishlist'],
					'encode' => false
				],
				[
					'label' => '<ion-icon name="person-circle-outline"></ion-icon> Minha Conta',
					'url' => ['perfil/update'],
					'linkOptions' => ['class' => 'nav-link link-user'],
					'encode' => false
				],
				'<span id="username"><ion-icon name="at-outline"></ion-icon> ' . User::findOne(Yii::$app->user->id)->username . '</span>' .
					'<li class="nav-item">' .
					Html::a('<ion-icon name="log-out-outline"></ion-icon> Logout', ['site/logout'], ['data-method' => 'post', 'class' => 'nav-link link-logout']) .
					'</li>'
			],
			'options' => ['class' => 'navbar-nav ms-auto nav-loged'],
		]);
	}

	NavBar::end();
	?>
</header>