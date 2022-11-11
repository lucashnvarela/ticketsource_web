<?php

use yii\helpers\Html;
use common\models\User;

/** @var $this yii\web\View */
/** @var $db_users common\models\User */

$this->registerCssFile("@web/css/user/index.css");

$this->title = 'Lista de Utilizadores';
?>

<div class="index-page">
	<div class="card">
		<div class="card-header">
			<h5 class="title"><i class="fas fa-users"></i> <?= $this->title ?> </h5>
			<div class="search-bar input-group">
				<input type="search" class="form-control" placeholder="Pesquisar" />
				<a class="btn-search">
					<i class="fas fa-search"></i>
				</a>
			</div>
		</div>

		<div class="card-body">
			<div class="table-border">
				<?php
				if ($db_users != null) { ?>
					<table>
						<thead>
							<tr>
								<th class="th-id">#</th>
								<th class="th-nome">Nome de utilizador <?= Html::a('<i class="' . $sort_config['username']['class'] . '"></i>', ['user/index', 'sort' => $sort_config['username']['sort']]) ?></th>
								<th class="th-created">Data de registo <?= Html::a('<i class="' . $sort_config['created_at']['class'] . '"></i>', ['user/index', 'sort' => $sort_config['created_at']['sort']]) ?></th>
								<th class="th-role">Função </th>
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
											echo $date->format('d/m/Y');
											?>
										</p>
									</td>
									<td class="td-role">
										<p><?= array_key_first(Yii::$app->authManager->getRolesByUser(userId: $user->id)) ?></p>
									</td>
									<td class="td-status">
										<?= Html::tag('p', $user->getStatus(), ['class' => 'badge badge-' . $user->getStatus()]); ?>
									</td>
									<td class="td-actions">
										<?php
										if ($user->isCliente()) {
											if ($user->isActive()) {
												echo Html::a(
													'<i class="fas fa-lock"></i> Bloquear',
													['user/block', 'id' => $user->id],
													['class' => 'table-link']
												);
											} else {
												echo Html::a(
													'<i class="fas fa-lock-open"></i> Desbloquear',
													['user/unblock', 'id' => $user->id],
													['class' => 'table-link']
												);
											}
										} elseif ($user->isGestor() && !$user->isDeleted()) {
											echo Html::a(
												'<i class="fas fa-trash-can"></i> Eliminar',
												['user/delete', 'id' => $user->id],
												['class' => 'table-link']
											);
										} ?>
									</td>
								</tr>
							<?php } ?>
						</tbody>
					</table>
				<?php  } ?>
			</div>
		</div>
		<div class="card-footer">
		</div>
	</div>
</div>