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
			'class' => 'navbar navbar-expand-xl fixed-top',
		],
	]);

	echo Nav::widget([
		'items' => [
			[
				'label' => '<ion-icon name="bar-chart-outline"></ion-icon> Dashboard',
				'url' => Yii::$app->homeUrl,
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
				[
					'label' => '<ion-icon name="person-add-outline"></ion-icon> Registar Novo Gestor',
					'url' => ['site/signup'],
					'linkOptions' => ['class' => 'nav-link link-create-gestor'],
					'encode' => false
				],
			],
			'options' => ['class' => 'navbar-nav nav-admin'],
		]);
	} else {
		echo Nav::widget([
			'items' => [
				[
					'label' => '<i class="fas fa-calendar-day"></i> Lista de Eventos',
					'url' => ['evento/index'],
					'linkOptions' => ['class' => 'nav-link link-eventos'],
					'encode' => false
				],
				[
					'label' => '<i class="far fa-calendar-days"></i> Calendario de Sessões',
					'url' => ['sessao/index', 'month' => date('n'), 'year' => date('Y')],
					'linkOptions' => ['class' => 'nav-link link-sessoes'],
					'encode' => false
				],
				[
					'label' => '<i class="far fa-calendar-plus"></i> Registar Novo Evento',
					'url' => ['evento/create'],
					'linkOptions' => ['class' => 'nav-link link-create-evento'],
					'encode' => false
				],
			],
			'options' => ['class' => 'navbar-nav nav-gestor'],
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