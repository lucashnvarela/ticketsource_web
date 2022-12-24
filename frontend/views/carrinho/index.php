<?php

/** @var $this yii\web\View */

use frontend\models\Carrinho;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;

$this->registerCssFile("@web/css/carrinho/index.css");

$this->title = 'Carrinho de compras';
?>

<div class="carrinho-index">
	<div class="card">
		<div class="card-header">
			<div class="header">
				<div>
					<h5 id="title">
						<ion-icon name="cart-outline"></ion-icon> <?= $this->title ?>
					</h5>
				</div>
				<p id="subtitle">Confira todas as suas escolhas</p>
			</div>
		</div>
		<?php
		ActiveForm::begin([
			'action' => ['carrinho/finalizar'],
			'method' => 'post',
		]) ?>
		<div class="card-body">
			<?php
			if (!empty($db_carrinho)) : ?>
				<div class="carrinho-lista">
					<ul>
						<?php
						foreach ($db_carrinho as $item_compra) :
							echo $this->render('@frontend/views/carrinho/item_carrinho', [
								'model_carrinho' => $item_compra,
							]);
						endforeach ?>
					</ul>
				</div>
				<div class="carrinho-detalhes">
					<h6><span>Seguro :</span> <?= number_format(Carrinho::VALOR_SEGURO, 2, ',', ' ') . "€" ?></h6>
					<h6><span>Total :</span> <?= number_format($carrinho_total, 2, ',', ' ') . "€" ?></h6>
					<?php
					if (!empty($db_carrinho)) :
						echo Html::submitButton('<ion-icon name="checkmark-outline"></ion-icon> Finalizar compra', ['class' => 'btn-default ripple']);
						if (count($db_carrinho) > 1)
							echo Html::a('<ion-icon name="close-outline"></ion-icon> Remover todos', ['carrinho/deleteall'], [
								'class' => 'btn-default',
								'data' => ['confirm' => 'Tem a certeza que pretende remover todos os bilhetes do carrinho?']
							]);
					endif ?>
				</div>
			<?php
			else : ?>
				<div class="no-data">
					<p>O seu carrinho de compras está vazio</p>
				</div>
			<?php endif ?>
		</div>
		<div class="card-footer">
		</div>
		<?php ActiveForm::end() ?>
	</div>
</div>