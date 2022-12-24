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
			'class' => 'navbar navbar-expand-xl',
		],
	]);

	echo Nav::widget([
		'items' => [
			[
				'label' => '<ion-icon name="pie-chart-outline"></ion-icon> Dashboard',
				'url' => ['site/index'],
				'linkOptions' => ['class' => 'nav-link link-dashboard'],
				'encode' => false
			],

		],
		'options' => ['class' => 'navbar-nav'],
	]);

	if (User::findOne(Yii::$app->user->id)->isAdmin()) {
		echo Nav::widget([
			'items' => [
				[
					'label' => '<ion-icon name="people-outline"></ion-icon> Lista de Utilizadores',
					'url' => ['user/index', 'sort' => 'username'],
					'linkOptions' => ['class' => 'nav-link link-users'],
					'encode' => false
				],
			],
			'options' => ['class' => 'navbar-nav nav-admin'],
		]);
	} else {
		echo Nav::widget([
			'items' => [
				[
					'label' => '<ion-icon name="today-outline"></ion-icon> Lista de Eventos',
					'url' => ['evento/index'],
					'linkOptions' => ['class' => 'nav-link link-eventos'],
					'encode' => false
				],
				[
					'label' => '<ion-icon name="calendar-outline"></ion-icon> Calendario de Sessões',
					'url' => ['sessao/index', 'month' => date('n'), 'year' => date('Y')],
					'linkOptions' => ['class' => 'nav-link link-sessoes'],
					'encode' => false
				],
			],
			'options' => ['class' => 'navbar-nav nav-gestor'],
		]);
	}

	echo Nav::widget([
		'items' => [
			'<span id="username"><ion-icon name="at-outline"></ion-icon> ' . User::findOne(Yii::$app->user->id)->username . '</span>' .
				'<li class="nav-item">' .
				Html::a('<ion-icon name="log-out-outline"></ion-icon> Logout', ['site/logout'], ['data-method' => 'post', 'class' => 'nav-link link-logout']) .
				'</li>'
		],
		'options' => ['class' => 'navbar-nav ms-auto nav-logout'],
	]);

	NavBar::end();
	?>
</header>