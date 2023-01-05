<?php

namespace frontend\tests\functional;

use frontend\tests\FunctionalTester;
use common\fixtures\UserFixture;
use yii\helpers\Url;

class LoginCest {
	/**
	 * Load fixtures before db transaction begin
	 * Called in _before()
	 * @see \Codeception\Module\Yii2::_before()
	 * @see \Codeception\Module\Yii2::loadFixtures()
	 * @return array
	 */
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
		$I->see('Iniciar sessão', '.card-header #title');
	}

	/* //!
	public function loginEmpty(FunctionalTester $I) {
		$I->fillField('LoginForm[username]', '');
		$I->seeInField('LoginForm[username]', '');
		$I->fillField('LoginForm[password]', '');
		$I->seeInField('LoginForm[password]', '');
		$I->click('#login-form button[type=submit]');

		$I->see('O campo nome de utilizador é obrigatório', '.invalid-feedback');
		$I->see('O campo palavra-passe é obrigatório', '.invalid-feedback');
	}
	*/

	public function loginWrongPassword(FunctionalTester $I) {
		$I->fillField('LoginForm[username]', 'cliente');
		$I->seeInField('LoginForm[username]', 'cliente');
		$I->fillField('LoginForm[password]', 'wrong');
		$I->seeInField('LoginForm[password]', 'wrong');
		$I->click('#login-form button[type=submit]');

		$I->see('Username ou password incorretos', '.message');
	}

	public function loginInactiveAccount(FunctionalTester $I) {
		$I->fillField('LoginForm[username]', 'cliente.inactive');
		$I->seeInField('LoginForm[username]', 'cliente.inactive');
		$I->fillField('LoginForm[password]', 'cliente123');
		$I->seeInField('LoginForm[password]', 'cliente123');
		$I->click('#login-form button[type=submit]');

		$I->see('Login indisponível', '.message');
	}

	public function loginSuccessfully(FunctionalTester $I) {
		$I->fillField('LoginForm[username]', 'cliente');
		$I->seeInField('LoginForm[username]', 'cliente');
		$I->fillField('LoginForm[password]', 'cliente123');
		$I->seeInField('LoginForm[password]', 'cliente123');
		$I->click('#login-form button[type=submit]');

		$I->see('Minha Conta', '.nav .nav-link');
		$I->dontSeeLink('Iniciar Sessão', '.nav .nav-link');
		$I->see('Logout', '.nav .nav-link');
	}
}
