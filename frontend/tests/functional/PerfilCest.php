<?php

namespace frontend\tests\functional;

use common\fixtures\PerfilFixture;
use common\fixtures\UserFixture;
use frontend\tests\FunctionalTester;
use yii\helpers\Url;

class PerfilCest {
	public function _fixtures() {
		return [
			'user' => [
				'class' => UserFixture::class,
				'dataFile' => codecept_data_dir() . 'login_data.php',
			],
		];
	}
	public function _before(FunctionalTester $I) {
		$I->amOnPage(Url::toRoute('/site/login'));

		$I->fillField('LoginForm[username]', 'cliente');
		$I->fillField('LoginForm[password]', 'cliente123');
		$I->click('#login-form button[type=submit]');

		$I->click('Minha Conta', '.nav .nav-link');
		$I->see('Informações pessoais', '.card-header #title');
	}

	public function editarPerfilEmpty(FunctionalTester $I) {
		$I->fillField('Perfil[nome]', '');
		$I->seeInField('Perfil[nome]', '');
		$I->fillField('Perfil[telefone]', '');
		$I->seeInField('Perfil[telefone]', '');
		$I->fillField('Perfil[nif]', '');
		$I->seeInField('Perfil[nif]', '');
		$I->fillField('Perfil[pais]', '');
		$I->seeInField('Perfil[pais]', '');
		$I->fillField('Perfil[distrito]', '');
		$I->seeInField('Perfil[distrito]', '');
		$I->fillField('Perfil[morada]', '');
		$I->seeInField('Perfil[morada]', '');
		$I->click('#update-form button[type=submit]');

		$I->see('O campo nome completo é obrigatório');
		$I->see('O campo número de telefone é obrigatório');
		$I->see('O campo NIF é obrigatório');
		$I->see('O campo país é obrigatório');
		$I->see('O campo distrito é obrigatório');
		$I->see('O campo morada é obrigatório');
	}

	public function editarPerfilWrongTelemovel(FunctionalTester $I) {
		$I->fillField('Perfil[nome]', 'cliente nome');
		$I->seeInField('Perfil[nome]', 'cliente nome');
		$I->fillField('Perfil[telefone]', '123');
		$I->seeInField('Perfil[telefone]', '123');
		$I->fillField('Perfil[nif]', '123456789');
		$I->seeInField('Perfil[nif]', '123456789');
		$I->fillField('Perfil[pais]', 'pais');
		$I->seeInField('Perfil[pais]', 'pais');
		$I->fillField('Perfil[distrito]', 'distrito');
		$I->seeInField('Perfil[distrito]', 'distrito');
		$I->fillField('Perfil[morada]', 'morada');
		$I->seeInField('Perfil[morada]', 'morada');
		$I->click('#update-form button[type=submit]');

		$I->dontSee('O campo nome completo é obrigatório');
		$I->see('O campo número de telefone é inválido');
		$I->dontSee('O campo NIF é obrigatório');
		$I->dontSee('O campo país é obrigatório');
		$I->dontSee('O campo distrito é obrigatório');
		$I->dontSee('O campo morada é obrigatório');
	}

	public function editarPerfilSuccessfully(FunctionalTester $I) {
		$I->fillField('Perfil[nome]', 'cliente nome');
		$I->seeInField('Perfil[nome]', 'cliente nome');
		$I->fillField('Perfil[telefone]', '987654321');
		$I->seeInField('Perfil[telefone]', '987654321');
		$I->fillField('Perfil[nif]', '123456789');
		$I->seeInField('Perfil[nif]', '123456789');
		$I->fillField('Perfil[pais]', 'pais');
		$I->seeInField('Perfil[pais]', 'pais');
		$I->fillField('Perfil[distrito]', 'distrito');
		$I->seeInField('Perfil[distrito]', 'distrito');
		$I->fillField('Perfil[morada]', 'morada');
		$I->seeInField('Perfil[morada]', 'morada');
		$I->click('#update-form button[type=submit]');

		$I->see('Dados atualizados com sucesso', '.message');
	}
}
