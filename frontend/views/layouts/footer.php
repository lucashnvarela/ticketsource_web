<?php

/** @var yii\web\View $this */

use yii\helpers\Html;

$this->registerCssFile("@web/css/layouts/footer.css");
?>

<footer>
	<div class="footer">
		<div class="links">
			<h5>Loja</h5>
			<div>
				<?= Html::a('Pesquisar', ['evento/index']) ?>
				<span>/</span>
				<?= Html::a('Carrinho de compras', ['carrinho/index']) ?>
				<span>/</span>
				<?= Html::a('Favoritos', ['favorito/index']) ?>
				<span>/</span>
				<?php
				if (Yii::$app->user->isGuest) echo Html::a('Minha Conta', ['site/login']);
				else echo Html::a('Minha Conta', ['perfil/update']);
				?>
				<span>/</span>
				<?= Html::a('Login', ['site/login']) ?>
				<span>/</span>
				<?= Html::a('Registo', ['site/signup']) ?>
			</div>
		</div>
		<div class="eventos">
			<h5>Eventos</h5>
			<div>
				<?= Html::a('Desporto', ['evento/index']) ?>
				<span>/</span>
				<?= Html::a('Música', ['evento/index']) ?>
				<span>/</span>
				<?= Html::a('Teatro', ['evento/index']) ?>
				<span>/</span>
				<?= Html::a('Festival', ['evento/index']) ?>
			</div>
		</div>
		<div class="social">
			<h5>Siga-nos</h5>
			<div>
				<a href="#">
					<ion-icon name="logo-facebook"></ion-icon>Facebook
				</a>
				<span>/</span>
				<a href="#">
					<ion-icon name="logo-instagram"></ion-icon>Instagram
				</a>
				<span>/</span>
				<a href="#">
					<ion-icon name="logo-twitter"></ion-icon>Twitter
				</a>
				<span>/</span>
				<a href="#">
					<ion-icon name="logo-youtube"></ion-icon>Youtube
				</a>
			</div>
		</div>
	</div>
</footer>