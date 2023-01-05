<?php

namespace frontend\tests\functional;

use common\fixtures\UserFixture;
use common\fixtures\PerfilFixture;
use common\fixtures\EventoFixture;
use common\fixtures\SessaoFixture;
use common\fixtures\BilheteFixture;
use frontend\tests\FunctionalTester;
use yii\helpers\Url;

class CarrinhoCest {
	public function _fixtures() {
		return [
			'user' => [
				'class' => UserFixture::class,
				'dataFile' => codecept_data_dir() . 'login_data.php',
			],
			'perfil' => [
				'class' => PerfilFixture::class,
				'dataFile' => codecept_data_dir() . 'perfil_data.php',
			],
			'evento' => [
				'class' => EventoFixture::class,
				'dataFile' => codecept_data_dir() . 'evento_data.php',
			],
			'sessao' => [
				'class' => SessaoFixture::class,
				'dataFile' => codecept_data_dir() . 'sessao_data.php',
			],
			'bilhete' => [
				'class' => BilheteFixture::class,
				'dataFile' => codecept_data_dir() . 'bilhete_data.php',
			]
		];
	}
	public function _before(FunctionalTester $I) {
		$I->amOnPage(Url::toRoute('/site/login'));

		$I->fillField('LoginForm[username]', 'cliente');
		$I->fillField('LoginForm[password]', 'cliente123');
		$I->click('#login-form button[type=submit]');

		$I->click('Eventos', '.nav .nav-link');
		$I->see('Eventos', '.card-header #title');
	}

	public function finalizarCompra(FunctionalTester $I) {
		$I->click('Eventos', '.nav .nav-link'); 									//* selecionar página de eventos
		$I->click('.card-body a[name="teste1"]'); 									//* selecionar evento

		$I->see('teste1', '.card-header #title h5'); 								//* confirmar nome do evento
		$I->see('localizacao teste', '.evento-sessoes .detalhes p:first-of-type'); 	//* confirmar localizacao da sessao
		$I->click('.evento-sessoes li a[name="1"]'); 								//* selecionar sessao

		$I->see('teste1', '.card-header #title'); 									//* confirmar nome do evento
		$I->see('1 de Janeiro', '.card-header #data'); 								//* confirmar data da sessao
		$I->selectOption('.radio-list input[name="numero_lugar"]', '0'); 			//* selecionar lugar
		$I->seeOptionIsSelected('.radio-list input[name="numero_lugar"]', '0'); 	//* confirmar lugar selecionado
		$I->click('.card-footer button[type="submit"]');							//* adicionar ao carrinho
		$I->see('Bilhete adicionado ao carrinho com sucesso', '.message'); 			//* confirmar mensagem de sucesso

		$I->click('Carrinho', '.nav .nav-link'); 									//* selecionar página de carrinho
		$I->see('Carrinho de compras', '.card-header #title'); 						//* confirmar nome da página
		$I->see('teste1', '.carrinho-item .detalhes p:first-of-type');				//* confirmar bilhete no carrinho
		$I->see('11,25', '.carrinho-detalhes h6:last-of-type'); 					//* confirmar valor total do carrinho
		$I->click('.carrinho-detalhes button[type="submit"]'); 						//* finalizar compra

		$I->see('Checkout', '.card-header #title');									//* confirmar nome da página
		$I->fillField('Pagamento[numero_cartao]', 1234567890123456);				//* preencher dados do cartão
		$I->seeInField('Pagamento[numero_cartao]', 1234567890123456);				//* confirmar dados do cartão
		$I->fillField('Pagamento[data_validade]', '12-2023');						//* preencher data de validade
		$I->seeInField('Pagamento[data_validade]', '12-2023');						//* confirmar data de validade
		$I->fillField('Pagamento[codigo_seguranca]', 123);							//* preencher código de segurança
		$I->seeInField('Pagamento[codigo_seguranca]', 123);							//* confirmar código de segurança
		$I->click('#create-form button[type="submit"]'); 							//* efetuar pagamento

		$I->see('Compra efetuada com sucesso', '.message');							//* confirmar mensagem de sucesso
	}
}
