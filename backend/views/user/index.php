<?php

use yii\helpers\Html;

/** @var $this yii\web\View */
/** @var $user common\models\User */

$this->registerCssFile("@web/css/user/index.css");

$this->title = 'Lista de Utilizadores';
?>

<div class="user-index">
	<div class="card">
		<div class="card-header">
			<h5 id="title">
				<ion-icon name="people-outline"></ion-icon> <?= $this->title ?>
			</h5>
			<div class="header-actions">
				<?php
				echo Html::a(
					'<ion-icon name="person-add-outline"></ion-icon> Registar Gestor',
					['site/signup'],
					['class' => 'btn-default']
				);

				echo $this->render('@backend/views/layouts/search', ['model_search' => $model_search]);
				?>
			</div>
		</div>

		<div class="card-body">
			<?php
			if (!empty($db_users)) { ?>
				<div class="table-border">
					<table>
						<thead>
							<tr>
								<th class="th-id">#</th>
								<th class="th-nome">Nome de utilizador <?= Html::a('<i class="' . $sort_config['username']['class'] . '"></i>', ['user/index', 'sort' => $sort_config['username']['sort']]) ?></th>
								<th class="th-created">Data de registo <?= Html::a('<i class="' . $sort_config['created_at']['class'] . '"></i>', ['user/index', 'sort' => $sort_config['created_at']['sort']]) ?></th>
								<th class="th-role">Função</th>
								<th class="th-status">Estado <?= Html::a('<i class="' . $sort_config['status']['class'] . '"></i>', ['user/index', 'sort' => $sort_config['status']['sort']]) ?></th>
								<th class="th-actions">Ações</th>
							</tr>
						</thead>
						<tbody>
							<?php
							foreach ($db_users as $user) { ?>
								<tr>
									<td class="td-id">
										<p><?= $user->id ?></p>
									</td>
									<td class="td-nome">
										<p><?= $user->username ?></p>
										<p><?= $user->email ?></p>
									</td>
									<td class="td-created">
										<p>
											<?php
											$date = new DateTime("@$user->created_at");
											echo $date->format('d-m-Y');
											?>
										</p>
									</td>
									<td class="td-role">
										<p><?= array_key_first(Yii::$app->authManager->getRolesByUser($user->id)) ?></p>
									</td>
									<td class="td-status">
										<?= Html::tag('p', $user->getStatus(), ['class' => 'badge badge-' . $user->getStatus()]); ?>
									</td>
									<td class="td-actions">
										<?php
										if ($user->isCliente()) {
											if ($user->isActive()) {
												echo Html::a(
													'<ion-icon name="lock-closed-outline"></ion-icon> Bloquear',
													['user/block', 'id' => $user->id],
													['class' => 'table-link']
												);
											} else {
												echo Html::a(
													'<ion-icon name="lock-open-outline"></ion-icon> Desbloquear',
													['user/unblock', 'id' => $user->id],
													['class' => 'table-link']
												);
											}
										} elseif ($user->isGestor() && !$user->isDeleted()) {
											echo Html::a(
												'<ion-icon name="trash-outline"></ion-icon> Eliminar',
												['user/delete', 'id' => $user->id],
												['class' => 'table-link', 'data' => ['confirm' => 'Tem a certeza que pretende eliminar este utilizador?']]
											);
										} ?>
									</td>
								</tr>
							<?php } ?>
						</tbody>
					</table>
				</div>
			<?php  } else { ?>
				<div class="no-data">
					<p>Não existem utilizadores registados</p>
				</div>
			<?php } ?>
		</div>
		<div class="card-footer">
		</div>
	</div>
</div>