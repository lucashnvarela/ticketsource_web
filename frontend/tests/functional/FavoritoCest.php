<?php

namespace frontend\tests\functional;

use common\fixtures\FavoritoFixture;
use common\fixtures\EventoFixture;
use common\fixtures\UserFixture;
use frontend\tests\FunctionalTester;
use yii\helpers\Url;

class FavoritoCest {
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
			'produto' => [
				'class' => EventoFixture::class,
				'dataFile' => codecept_data_dir() . 'evento_data.php',
			],
			'favorito' => [
				'class' => FavoritoFixture::class,
				'dataFile' => codecept_data_dir() . 'favorito_data.php',
			],
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

	public function adicionarFav(FunctionalTester $I) {
		$I->click('.card-body a[name="teste1"]');

		$I->see('teste1', '#title h5');

		$I->click('Adicionar aos Favoritos');
		$I->seeLink('Remover dos Favoritos');
	}

	public function removerFav(FunctionalTester $I) {
		$I->click('.card-body a[name="teste2"]');

		$I->see('teste2', '#title h5');

		$I->click('Remover dos Favoritos');
		$I->seeLink('Adicionar aos Favoritos');
	}
}
