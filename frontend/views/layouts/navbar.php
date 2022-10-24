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
		'brandLabel' => Html::img('@web/img/logo.png', ['class' => 'navbar-brand']),
		'brandUrl' => Yii::$app->homeUrl,
		'options' => [
			'class' => 'navbar navbar-expand-lg fixed-top',
		],
	]);

	/*
	echo Html::tag(
		'div',
		Html::tag('input', '', ['class' => 'form-control', 'type' => 'search', 'placeholder' => 'Pesquisar'])
			. Html::tag(
				'button',
				Html::tag('i', '', ['class' => 'ti-search']),
				['class' => 'btn btn-search', 'type' => 'submit']
			),
		['class' => 'input-group search-bar rounded']
	);
	*/

	echo Nav::widget([
		'items' => [
			[
				'label' => 'Eventos',
				'url' => ['#'],
				'linkOptions' => ['class' => 'ti-ticket nav-link link-event'],
			],
		],
		'options' => ['class' => 'navbar-nav me-auto'],
	]);

	if (Yii::$app->user->isGuest) {
		echo Nav::widget([
			'items' => [
				[
					'label' => 'Iniciar sessão',
					'url' => ['site/login'],
					'linkOptions' => ['class' => 'nav-link link-login']
				],
				[
					'label' => ' Registar',
					'url' => ['/site/signup'],
					'linkOptions' => ['class' => 'nav-link link-signup']
				],
			],
			'options' => ['class' => 'navbar-nav ms-auto login-signup'],
		]);
	} else {
		echo Nav::widget([
			'items' => [
				[
					'label' => 'Carrinho',
					'url' => ['#'],
					'linkOptions' => ['class' => 'ti-shopping-cart nav-link link-cart']
				],
				[
					'label' => 'Wishlist',
					'url' => ['#'],
					'linkOptions' => ['class' => 'ti-heart nav-link link-wishlist']
				],
				[
					'label' => 'Minha Conta',
					'url' => ['#'],
					'linkOptions' => ['class' => 'ti-user nav-link link-user']
				],
				'<li class="nav-item">
					<span id="username">(' . User::findOne(Yii::$app->user->id)->username . ')</span>' .
					Html::a('Logout', ['site/logout'], ['data-method' => 'post', 'class' => 'nav-link link-logout']) .
					'</li>'
			],
			'options' => ['class' => 'navbar-nav ms-auto'],
		]);
	}

	NavBar::end();
	?>
</header>