<?php

namespace frontend\tests\functional;

use frontend\tests\FunctionalTester;
use yii\helpers\Url;

class SignupCest {
	public function _before(FunctionalTester $I) {
		$I->amOnPage(Url::toRoute('/site/signup'));
		$I->see('Registo', '.card-header #title');
	}

	public function signupEmpty(FunctionalTester $I) {
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

	public function signupWrongEmail(FunctionalTester $I) {
		$I->fillField('SignupForm[username]', 'teste');
		$I->seeInField('SignupForm[username]', 'teste');
		$I->fillField('SignupForm[email]', 'teste');
		$I->seeInField('SignupForm[email]', 'teste');
		$I->fillField('SignupForm[password]', '123456789');
		$I->seeInField('SignupForm[password]', '123456789');
		$I->click('#form-signup button[type=submit]');

		$I->dontSee('O campo nome de utilizador é obrigatório', '.invalid-feedback');
		$I->see('O campo email é inválido', '.invalid-feedback');
		$I->dontSee('O campo palavra-passe é obrigatório', '.invalid-feedback');
	}

	public function signupWrongPassword(FunctionalTester $I) {
		$I->fillField('SignupForm[username]', 'teste');
		$I->seeInField('SignupForm[username]', 'teste');
		$I->fillField('SignupForm[email]', 'teste@mail.com');
		$I->seeInField('SignupForm[email]', 'teste@mail.com');
		$I->fillField('SignupForm[password]', '1234');
		$I->seeInField('SignupForm[password]', '1234');
		$I->click('#form-signup button[type=submit]');

		$I->dontSee('O campo nome de utilizador é obrigatório', '.invalid-feedback');
		$I->dontSee('O campo email é obrigatório', '.invalid-feedback');
		$I->see('O campo palavra-passe deve conter pelo menos 8 caracteres', '.invalid-feedback');
	}

	public function signupSuccessfully(FunctionalTester $I) {
		$I->fillField('SignupForm[username]', 'teste');
		$I->fillField('SignupForm[email]', 'teste@mail.com');
		$I->fillField('SignupForm[password]', '12345678');
		$I->click('#form-signup button[type=submit]');

		$I->seeRecord('common\models\User', [
			'username' => 'teste',
			'email' => 'teste@mail.com',
			'status' => \common\models\User::STATUS_ACTIVE
		]);

		$I->see('Registo efetuado com sucesso', '.message');
	}
}
