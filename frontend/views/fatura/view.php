<?php

/** @var $this yii\web\View */
/** @var $model_fatura frontend\models\Fatura */
/** @var $model_faturabilhete frontend\models\FaturaBilhete */

use frontend\models\Carrinho;
use yii\helpers\Html;

$this->registerCssFile("@web/css/fatura/view.css");

$this->title = 'Fatura' . ' #' . $model_fatura->id . strtotime($model_fatura->data);
?>

<div class="fatura-view">
	<div class="card">
		<div class="card-header">
			<div class="header">
				<div>
					<h5 id="title">
						<ion-icon name="ticket-outline"></ion-icon> Bilhetes
					</h5>
				</div>
				<p id="subtitle"><?= $this->title ?></p>
			</div>
		</div>
		<div class="card-body">
			<div class="fatura-lista">
				<ul>
					<?php
					foreach ($model_fatura->getBilhetes() as $model_faturabilhete) :
						echo $this->render('@frontend/views/fatura_bilhete/form', [
							'model_faturabilhete' => $model_faturabilhete,
						]);
					endforeach ?>
				</ul>
			</div>
			<div class="fatura-detalhes">
				<h6><span>Seguro :</span> <?= number_format(Carrinho::VALOR_SEGURO, 2, ',', ' ') . "€" ?></h6>
				<h6><span>Total :</span> <?= number_format($model_fatura->total, 2, ',', ' ') . "€" ?></h6>
				<?= Html::a('<ion-icon name="chevron-back-outline"></ion-icon> Voltar', ['fatura/index'], ['class' => 'btn-default']) ?>
			</div>
		</div>
	</div>
</div>