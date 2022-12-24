<?php

use yii\db\Migration;

/**
 * Class m220926_193509_init_rbac
 */
class m220926_193509_init_rbac extends Migration {
	// Use up()/down() to run migration code without a transaction.
	public function up() {
		$auth = Yii::$app->authManager;

		$adicionarGestor = $auth->createPermission('adicionarGestor');
		$adicionarGestor->description = 'Adicionar Gestor';
		$auth->add($adicionarGestor);

		$editarGestor = $auth->createPermission('editarGestor');
		$editarGestor->description = 'Editar Gestor';
		$auth->add($editarGestor);

		$bloquearCliente = $auth->createPermission('bloquearCliente');
		$bloquearCliente->description = 'Bloquear Cliente';
		$auth->add($bloquearCliente);

		$desbloquearCliente = $auth->createPermission('desbloquearCliente');
		$desbloquearCliente->description = 'Desbloquear Cliente';
		$auth->add($desbloquearCliente);

		$eliminarGestor = $auth->createPermission('eliminarGestor');
		$eliminarGestor->description = 'Eliminar Gestor';
		$auth->add($eliminarGestor);

		$adicionarEvento = $auth->createPermission('adicionarEvento');
		$adicionarEvento->description = 'Adicionar Evento';
		$auth->add($adicionarEvento);

		$apagarEvento = $auth->createPermission('apagarEvento');
		$apagarEvento->description = 'Apagar Evento';
		$auth->add($apagarEvento);

		$editarEvento = $auth->createPermission('editarEvento');
		$editarEvento->description = 'Editar Evento';
		$auth->add($editarEvento);

		$visualizarSessoes = $auth->createPermission('visualizarSessoes');
		$visualizarSessoes->description = 'Visualizar Sessoes';
		$auth->add($visualizarSessoes);

		$adicionarSessao = $auth->createPermission('adicionarSessao');
		$adicionarSessao->description = 'Adicionar Sessao';
		$auth->add($adicionarSessao);

		$apagarSessao = $auth->createPermission('apagarSessao');
		$apagarSessao->description = 'Apagar Sessao';
		$auth->add($apagarSessao);

		$editarSessao = $auth->createPermission('editarSessao');
		$editarSessao->description = 'Editar Sessao';
		$auth->add($editarSessao);

		$visualizarFavoritos = $auth->createPermission('visualizarFavoritos');
		$visualizarFavoritos->description = 'Visualizar Favoritos';
		$auth->add($visualizarFavoritos);

		$adicionarFavoritos = $auth->createPermission('adicionarFavoritos');
		$adicionarFavoritos->description = 'Adicionar aos Favoritos';
		$auth->add($adicionarFavoritos);

		$apagarFavoritos = $auth->createPermission('apagarFavoritos');
		$apagarFavoritos->description = 'Apagar dos Favoritos ';
		$auth->add($apagarFavoritos);

		$comprarBilhetes = $auth->createPermission('comprarBilhetes');
		$comprarBilhetes->description = 'Comprar Bilhetes';
		$auth->add($comprarBilhetes);

		$visualizarCarrinho = $auth->createPermission('visualizarCarrinho');
		$visualizarCarrinho->description = 'Visualizar Carrinho';
		$auth->add($visualizarCarrinho);

		$adicinarBilhetesAoCarrinho = $auth->createPermission('adicinarBilhetesAoCarrinho');
		$adicinarBilhetesAoCarrinho->description = 'Adicionar Bilhetes ao Carinnho';
		$auth->add($adicinarBilhetesAoCarrinho);

		$apagarBilhetesdoCarrinho = $auth->createPermission('apagarBilhetesdoCarrinho');
		$apagarBilhetesdoCarrinho->description = 'Apagar Bilhetes do Carinnho';
		$auth->add($apagarBilhetesdoCarrinho);

		$visualizarEventos = $auth->createPermission('visualizarEventos');
		$visualizarEventos->description = 'Visualizar Eventos';
		$auth->add($visualizarEventos);

		$visualizarBilhetes = $auth->createPermission('visualizarBilhetes');
		$visualizarBilhetes->description = 'Visualizar Bilhetes Adquiridos';
		$auth->add($visualizarBilhetes);

		$visualizarUtilizadores = $auth->createPermission('visualizarUtilizadores');
		$visualizarUtilizadores->description = 'Visualizar Utilizadores';
		$auth->add($visualizarUtilizadores);

		$visualizarPerfil = $auth->createPermission('visualizarPerfil');
		$visualizarPerfil->description = 'Visualizar Perfil';
		$auth->add($visualizarPerfil);

		$editarPerfil = $auth->createPermission('editarPerfil');
		$editarPerfil->description = 'Editar Perfil';
		$auth->add($editarPerfil);


		$cliente = $auth->createRole('cliente');
		$auth->add($cliente);
		$auth->addChild($cliente, $visualizarCarrinho);
		$auth->addChild($cliente, $adicinarBilhetesAoCarrinho);
		$auth->addChild($cliente, $apagarBilhetesdoCarrinho);
		$auth->addChild($cliente, $visualizarBilhetes);
		$auth->addChild($cliente, $visualizarFavoritos);
		$auth->addChild($cliente, $comprarBilhetes);
		$auth->addChild($cliente, $adicionarFavoritos);
		$auth->addChild($cliente, $apagarFavoritos);
		$auth->addChild($cliente, $visualizarPerfil);
		$auth->addChild($cliente, $editarPerfil);


		$gestorBilheteira = $auth->createRole('gestorBilheteira');
		$auth->add($gestorBilheteira);
		$auth->addChild($gestorBilheteira, $visualizarSessoes);
		$auth->addChild($gestorBilheteira, $adicionarSessao);
		$auth->addChild($gestorBilheteira, $apagarSessao);
		$auth->addChild($gestorBilheteira, $editarSessao);
		$auth->addChild($gestorBilheteira, $visualizarEventos);
		$auth->addChild($gestorBilheteira, $adicionarEvento);
		$auth->addChild($gestorBilheteira, $apagarEvento);
		$auth->addChild($gestorBilheteira, $editarEvento);


		$admin = $auth->createRole('admin');
		$auth->add($admin);
		$auth->addChild($admin, $visualizarUtilizadores);
		$auth->addChild($admin, $adicionarGestor);
		$auth->addChild($admin, $editarGestor);
		$auth->addChild($admin, $bloquearCliente);
		$auth->addChild($admin, $desbloquearCliente);
		$auth->addChild($admin, $eliminarGestor);

		$auth->assign($admin, 1);
	}

	public function down() {
		$auth = Yii::$app->authManager;

		$auth->removeAll();
	}
}
