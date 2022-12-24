<?php

/** @var $this yii\web\View */

$this->registerCssFile("@web/css/site/index.css");

$this->title = 'Dashboard';
?>

<div class="dashboard-page">
	<div class="dashboard-row">
		<div class="card info-form">
			<div class="card-body">
				<h4>№ de Eventos</h4>
				<h4><?= $nEventos ?></h4>
			</div>
		</div>
		<div class="card info-form">
			<div class="card-body">
				<h4>№ de Sessões</h4>
				<h4><?= $nSessoes ?></h4>
			</div>
		</div>
		<div class="card info-form">
			<div class="card-body">
				<h4>№ de Bilhetes</h4>
				<h4><?= $nBilhetes ?></h4>
			</div>
		</div>
		<div class="card info-form">
			<div class="card-body">
				<h4>Rendimentos</h4>
				<h4><?= $tRendimentos ?><span>€</span></h4>
			</div>
		</div>
	</div>
</div>