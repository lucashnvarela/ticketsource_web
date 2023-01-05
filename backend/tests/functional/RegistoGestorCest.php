<?php

namespace backend\tests\functional;

use backend\tests\FunctionalTester;
use common\fixtures\UserFixture;
use yii\helpers\Url;


class RegistoGestorCest {
	public function _fixtures() {
		return [
			'user' => [
				'class' => UserFixture::class,
				'dataFile' => codecept_data_dir() . 'login_data.php'
			]
		];
	}

	public function _before(FunctionalTester $I) {
		$I->amOnPage(Url::toRoute('/site/login'));

		$I->fillField('LoginForm[username]', 'admin');
		$I->seeInField('LoginForm[username]', 'admin');
		$I->fillField('LoginForm[password]', 'admin123');
		$I->seeInField('LoginForm[password]', 'admin123');
		$I->click('#login-form button[type=submit]');

		$I->click('Lista de Utilizadores', '.nav-link');
		$I->click('Registar Gestor', '.btn-default');
		$I->see('Registo', '#title');
	}

	// tests
	public function checkEmpty(FunctionalTester $I) {
		$I->fillField('SignupForm[username]', '');
		$I->seeInField('SignupForm[username]', '');
		$I->fillField('SignupForm[email]', '');
		$I->seeInField('SignupForm[email]', '');
		$I->fillField('SignupForm[password]', '');
		$I->seeInField('SignupForm[password]', '');
		$I->click('#form-signup button[type=submit]');

		$I->see('O campo nome de utilizador é obrigatório', '.invalid-feedback');
		$I->see('O campo email é obrigatório', '.invalid-feedback');
		$I->see('O campo palavra-passe é obrigatório', '.invalid-feedback');
	}

	public function checkWrongEmail(FunctionalTester $I) {
		$I->fillField('SignupForm[username]', 'teste');
		$I->seeInField('SignupForm[username]', 'teste');
		$I->fillField('SignupForm[email]', 'teste');
		$I->seeInField('SignupForm[email]', 'teste');
		$I->fillField('SignupForm[password]', '12345678');
		$I->seeInField('SignupForm[password]', '12345678');
		$I->click('#form-signup button[type=submit]');


		$I->dontSee('O campo nome de utilizador é obrigatório', '.invalid-feedback');
		$I->see('O campo email é inválido', '.invalid-feedback');
		$I->dontSee('O campo palavra-passe é obrigatório', '.invalid-feedback');
	}

	public function checkWrongPassword(FunctionalTester $I) {
		$I->fillField('SignupForm[username]', 'teste');
		$I->seeInField('SignupForm[username]', 'teste');
		$I->fillField('SignupForm[email]', 'teste');
		$I->seeInField('SignupForm[email]', 'teste');
		$I->fillField('SignupForm[password]', '1234567');
		$I->seeInField('SignupForm[password]', '1234567');
		$I->click('#form-signup button[type=submit]');


		$I->dontSee('O campo nome de utilizador é obrigatório', '.invalid-feedback');
		$I->dontSee('O campo email é obrigatório', '.invalid-feedback');
		$I->see('O campo palavra-passe deve conter pelo menos 8 caracteres', '.invalid-feedback');
	}

	public function registoSuccessfully(FunctionalTester $I) {
		$I->fillField('SignupForm[username]', 'teste');
		$I->seeInField('SignupForm[username]', 'teste');
		$I->fillField('SignupForm[email]', 'teste@mail.com');
		$I->seeInField('SignupForm[email]', 'teste@mail.com');
		$I->fillField('SignupForm[password]', '12345678');
		$I->seeInField('SignupForm[password]', '12345678');
		$I->click('#form-signup button[type=submit]');

		$I->see('Lista de Utilizadores', '#title');
		$I->see('Registo efetuado com sucesso', '.message');
	}
}
