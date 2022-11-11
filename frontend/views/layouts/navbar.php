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
				'label' => '<i class="fas fa-calendar-day"></i> Eventos',
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
					'label' => '<i class="fas fa-user-check"></i> Iniciar sessão',
					'url' => ['site/login'],
					'linkOptions' => ['class' => 'nav-link link-login'],
					'encode' => false
				],
				[
					'label' => '<i class="fas fa-user-plus"></i> Registar',
					'url' => ['site/signup'],
					'linkOptions' => ['class' => 'nav-link link-signup'],
					'encode' => false
				],
			],
			'options' => ['class' => 'navbar-nav ms-auto nav-guest'],
		]);
	} else {
		echo Nav::widget([
			'items' => [
				[
					'label' => '<i class="fas fa-cart-shopping"></i> Carrinho',
					'url' => ['carrinho/index'],
					'linkOptions' => ['class' => 'nav-link link-cart'],
					'encode' => false
				],
				[
					'label' => '<i class="fas fa-heart"></i> Wishlist',
					'url' => ['favorito/index'],
					'linkOptions' => ['class' => 'nav-link link-wishlist'],
					'encode' => false
				],
				[
					'label' => '<i class="fas fa-user-large"></i> Minha Conta',
					'url' => ['perfil/update'],
					'linkOptions' => ['class' => 'nav-link link-user'],
					'encode' => false
				],
				'<li class="nav-item">
					<span id="username">(' . User::findOne(Yii::$app->user->id)->username . ')</span>' .
					Html::a('Logout', ['site/logout'], ['data-method' => 'post', 'class' => 'nav-link link-logout']) .
					'</li>'
			],
			'options' => ['class' => 'navbar-nav ms-auto nav-loged'],
		]);
	}

	NavBar::end();
	?>
</header>