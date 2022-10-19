<?php

/** @var yii\web\View $this */

use yii\bootstrap5\Html;
use yii\bootstrap5\Nav;
use yii\bootstrap5\NavBar;

$this->registerCssFile("@web/css/navbar.css");

?>
<header>
	<?php
	NavBar::begin([
		'brandLabel' => Html::img('@web/img/logo.png', ['class' => 'navbar-brand']),
		'brandUrl' => Yii::$app->homeUrl,
		'options' => [
			'class' => 'navbar navbar-expand-md fixed-top',
		],
	]);

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

	echo Nav::widget([
		'items' => [
			[
				'label' => 'Eventos',
				'url' => ['#'],
				'linkOptions' => ['class' => 'ti-ticket nav-link nav-event'],
			],
		],
		'options' => ['class' => 'navbar-nav ms-auto'],
	]);


	if (Yii::$app->user->isGuest) {
		echo Html::a('Iniciar sessão / Registo', ['/site/login'], ['class' => 'btn btn-outline-success btn-login', 'name' => 'login-button']);
	} else {
		echo Nav::widget([
			'items' => [
				['label' => 'Carrinho', 'url' => ['#'], 'linkOptions' => ['class' => 'ti-shopping-cart nav-link nav-cart']],
				['label' => 'Wishlist', 'url' => ['#'], 'linkOptions' => ['class' => 'ti-heart nav-link nav-wishlist']],
				['label' => 'Minha Conta', 'url' => ['#'], 'linkOptions' => ['class' => 'ti-user nav-link nav-user']],
				['label' => '/ Logout', 'url' => ['/site/logout'], 'linkOptions' => ['data-method' => 'post', 'class' => 'nav-link nav-logout']],
			],
			'options' => ['class' => 'navbar-nav'],
		]);
	}

	NavBar::end();
	?>

</header>