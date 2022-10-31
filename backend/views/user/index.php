<?php

use yii\helpers\Html;
use common\models\User;
use yii\helpers\VarDumper;

/** @var $this yii\web\View */
/** @var $db_users common\models\User */

$this->registerCssFile("@web/css/user/index.css");

$this->title = 'Lista de Utilizadores';
?>

<div class="user-index container">
    <div class="card">
        <div class="card-header">
            <h5 class="card-title"><i class="fa-solid fa-users"></i> <?= $this->title ?> </h5>
            <div class="search-bar input-group">
                <input type="search" class="form-control" placeholder="Pesquisar" />
                <a class="btn-search">
                    <i class="fa-solid fa-search"></i>
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
                                <th class="th-nome">Name</th>
                                <th class="th-created">Created</th>
                                <th class="th-role">Role</th>
                                <th class="th-status">Status</th>
                                <th class="th-actions">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            foreach ($db_users as $user) {
                                $userRole = array_key_first(Yii::$app->authManager->getRolesByUser($user->id)) ?>
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
                                        <p><?= $userRole ?></p>
                                    </td>
                                    <td class="td-status">
                                        <?= Html::tag('p', $user->getStatus(), ['class' => 'badge badge-' . $user->getStatus()]); ?>
                                    </td>
                                    <td class="td-actions">
                                        <?php
                                        if ($userRole != 'gestorBilheteira') {
                                            if ($user->status == User::STATUS_ACTIVE)
                                                echo Html::a('<i class="fa-solid fa-lock"></i> Bloquear', ['user/block', 'id' => $user->id], ['class' => 'table-link']);
                                            else
                                                echo Html::a('<i class="fa-solid fa-lock-open"></i> Desbloquear', ['user/unblock', 'id' => $user->id], ['class' => 'table-link']);
                                        } elseif ($user->status != User::STATUS_DELETED)
                                            echo Html::a('<i class="fa-solid fa-trash-can"></i> Eliminar', ['user/delete', 'id' => $user->id], ['class' => 'table-link'])
                                        ?>
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