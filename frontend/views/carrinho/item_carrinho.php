<?php

/** @var $this yii\web\View */
/** @var $model_bilhete common\models\Bilhete */
/** @var $model_carrinho frontend\models\Carrinho */

use yii\helpers\Html;

$this->registerCssFile("@web/css/carrinho/item_carrinho.css");

$model_bilhete = $model_carrinho->bilhete;

$sessao_mes = datefmt_format(
	datefmt_create('pt_PT', IntlDateFormatter::FULL, IntlDateFormatter::FULL, 'Europe/Lisbon', IntlDateFormatter::GREGORIAN, "MMM"),
	strtotime($model_bilhete->sessao->data)
);
$sessao_dia = datefmt_format(
	datefmt_create('pt_PT', IntlDateFormatter::FULL, IntlDateFormatter::FULL, 'Europe/Lisbon', IntlDateFormatter::GREGORIAN, "E"),
	strtotime($model_bilhete->sessao->data)
);
?>

<li class="carrinho-item">
	<div class="date">
		<p id="month"><?= substr($sessao_mes, 0, -1) ?></p>
		<p id="day"><?= date('d', strtotime($model_bilhete->sessao->data)) ?></p>
		<p id="weekday"><?= substr($sessao_dia, 0, $sessao_dia != 'sábado' ? 3 : 4) ?></p>
	</div>

	<div class="detalhes">
		<p><span>Evento : </span><?= $model_bilhete->sessao->evento->titulo ?></p>
		<p><span>Número do Lugar : </span><?= $model_bilhete->numero_lugar ?></p>
	</div>

	<p><?= number_format($model_bilhete->sessao->preco, 2, ',', ' ') . 	"€" ?></p>

	<?= Html::a('<ion-icon name="close-outline"></ion-icon> Remover', ['carrinho/delete', 'id' => $model_carrinho->id], [
		'class' => 'btn-default',
		'data' => ['confirm' => 'Tem a certeza que pretende remover este bilhete do carrinho?', 'method' => 'post']
	]) ?>
	<?php if ($model_bilhete->isIndisponivel()) : ?>
		<div class="blocker">
			<h6>Indisponível</h6>
		</div>
	<?php endif ?>
</li>