<?php

use yii\helpers\Html;

/** @var $this yii\web\View */
/** @var $model_evento common\models\Evento */

use backend\models\UploadForm;
use common\models\Evento;

$this->registerCssFile("@web/css/evento/view.css");

$this->title = 'Evento - ' . $model_evento->titulo;
?>

<div class="evento-view">
	<div class="card">
		<div class="card-header">
			<div class="evento-image">
				<img src=<?= UploadForm::getImageDir() . $model_evento->nome_pic  ?>>
			</div>
			<div class="evento-detalhes">
				<div id="title">
					<h5><?= $model_evento->titulo ?></h5>
				</div>
				<div id="categoria">
					<?= Html::tag('h5', $model_evento->categoria, [
						'class' => 'btn-' . Evento::getCategoriaBtnClass($model_evento->categoria),
					]) ?>
				</div>
				<div class="fav-link">
					<?php
					if (!Yii::$app->user->isGuest) :
						if ($model_evento->isFavorito()) :
							echo Html::a('<ion-icon name="heart-dislike-outline"></ion-icon> Remover dos Favoritos', ['favorito/delete', 'id_evento' => $model_evento->id], ['class' => 'btn-default', 'data' => ['confirm' => 'Tem a certeza que pretende remover este evento dos seus favoritos?', 'method' => 'post']]);
						else :
							echo Html::a('<ion-icon name="heart-outline"></ion-icon> Adicionar aos Favoritos', ['favorito/create', 'id_evento' => $model_evento->id], ['class' => 'btn-default']);
						endif;
					endif;
					?>
				</div>
			</div>
		</div>
		<div class="card-body">
			<?php if (!empty($model_evento->descricao)) : ?>
				<div class="evento-descricao">
					<h6 class="card-label">Descrição :</h6>
					<?= $model_evento->descricao ?>
				</div>
			<?php endif ?>

			<div class="evento-sessoes">
				<h6 class="card-label">Sessões :</h6>
				<?php
				if (!empty($model_evento->sessoes)) : ?>
					<ul>
						<?php
						foreach ($model_evento->sessoes as $model_sessao) :
							echo $this->render('@frontend/views/sessao/form', [
								'model_sessao' => $model_sessao,
							]);
						endforeach ?>
					</ul>
				<?php
				else : ?>
					<div class="no-data">
						<p>Não existem sessões disponíveis para este evento</p>
					</div>
				<?php endif ?>
			</div>
		</div>
	</div>
</div>