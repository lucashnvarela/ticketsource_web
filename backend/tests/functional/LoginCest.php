<?php

namespace backend\tests\functional;

use backend\tests\FunctionalTester;
use common\fixtures\UserFixture;
use yii\helpers\Url;

/**
 * Class LoginCest
 */
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
				'dataFile' => codecept_data_dir() . 'login_data.php'
			]
		];
	}

	public function _before(FunctionalTester $I) {
		$I->amOnPage(Url::toRoute('/site/login'));
	}

	/* //!
	public function checkEmpty(FunctionalTester $I) {
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
		$I->fillField('LoginForm[username]', 'admin');
		$I->seeInField('LoginForm[username]', 'admin');
		$I->fillField('LoginForm[password]', 'wrong');
		$I->seeInField('LoginForm[password]', 'wrong');
		$I->click('#login-form button[type=submit]');

		$I->see('Username ou password incorretos', '.message');
	}

	public function loginUserAdmin(FunctionalTester $I) {
		$I->fillField('LoginForm[username]', 'admin');
		$I->seeInField('LoginForm[username]', 'admin');
		$I->fillField('LoginForm[password]', 'admin123');
		$I->seeInField('LoginForm[password]', 'admin123');
		$I->click('#login-form button[type=submit]');

		$I->see('Lista de Utilizadores', '.nav-link');
		$I->dontSeeLink('#login-form button[type=submit]');
		$I->see('Logout', '.nav-link');
	}

	public function loginUserGestor(FunctionalTester $I) {
		$I->fillField('LoginForm[username]', 'gestor');
		$I->seeInField('LoginForm[username]', 'gestor');
		$I->fillField('LoginForm[password]', 'gestor123');
		$I->seeInField('LoginForm[password]', 'gestor123');
		$I->click('#login-form button[type=submit]');

		$I->see('Lista de Eventos', '.nav-link');
		$I->dontSeeLink('#login-form button[type=submit]');
		$I->see('Logout', '.nav-link');
	}

	public function loginUserCliente(FunctionalTester $I) {
		$I->fillField('LoginForm[username]', 'cliente');
		$I->seeInField('LoginForm[username]', 'cliente');
		$I->fillField('LoginForm[password]', 'cliente123');
		$I->seeInField('LoginForm[password]', 'cliente123');
		$I->click('#login-form button[type=submit]');

		$I->see('Sem permissão de acesso', '.message');
	}
}
