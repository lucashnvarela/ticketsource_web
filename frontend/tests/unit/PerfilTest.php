<?php

namespace frontend\tests;

use common\models\User;
use common\models\Perfil;

class PerfilTest extends \Codeception\Test\Unit {
	/**
	 * @var \frontend\tests\UnitTester
	 */
	protected $tester;

	const MAX_CHARACTERS = 'kkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkk';
	const INT_VALUE = 100;

	protected function _before() {
	}

	protected function _after() {
	}

	public function testValidations() {
		$perfil = new Perfil();

		//* nome
		$perfil->nome = 'perfil nome exemplo';
		$this->assertTrue($perfil->validate(['nome']));

		$perfil->nome = self::MAX_CHARACTERS;
		$this->assertFalse($perfil->validate(['nome']));

		$perfil->nome = self::INT_VALUE;
		$this->assertTrue($perfil->validate(['nome']));

		$perfil->nome = null;
		$this->assertFalse($perfil->validate(['nome']));

		//* nif
		$perfil->nif = '123456789';
		$this->assertTrue($perfil->validate(['nif']));

		$perfil->nif = self::MAX_CHARACTERS;
		$this->assertFalse($perfil->validate(['nif']));

		$perfil->nif = self::INT_VALUE;
		$this->assertFalse($perfil->validate(['nif']));

		$perfil->nif = null;
		$this->assertFalse($perfil->validate(['nif']));

		//* pais
		$perfil->pais = 'perfil pais exemplo';
		$this->assertTrue($perfil->validate(['pais']));

		$perfil->pais = self::MAX_CHARACTERS;
		$this->assertFalse($perfil->validate(['pais']));

		$perfil->pais = self::INT_VALUE;
		$this->assertTrue($perfil->validate(['pais']));

		$perfil->pais = null;
		$this->assertFalse($perfil->validate(['pais']));

		//* distrito
		$perfil->distrito = 'perfil distrito exemplo';
		$this->assertTrue($perfil->validate(['distrito']));

		$perfil->distrito = self::MAX_CHARACTERS;
		$this->assertFalse($perfil->validate(['distrito']));

		$perfil->distrito = self::INT_VALUE;
		$this->assertTrue($perfil->validate(['distrito']));

		$perfil->distrito = null;
		$this->assertFalse($perfil->validate(['distrito']));

		//* morada
		$perfil->morada = 'perfil morada exemplo';
		$this->assertTrue($perfil->validate(['morada']));

		$perfil->morada = self::MAX_CHARACTERS;
		$this->assertFalse($perfil->validate(['morada']));

		$perfil->morada = self::INT_VALUE;
		$this->assertTrue($perfil->validate(['morada']));

		$perfil->morada = null;
		$this->assertFalse($perfil->validate(['morada']));

		//* telefone
		$perfil->telefone = '123456789';
		$this->assertTrue($perfil->validate(['telefone']));

		$perfil->telefone = self::MAX_CHARACTERS;
		$this->assertFalse($perfil->validate(['telefone']));

		$perfil->telefone = self::INT_VALUE;
		$this->assertFalse($perfil->validate(['telefone']));

		$perfil->telefone = null;
		$this->assertFalse($perfil->validate(['telefone']));
	}

	public function testModel() {
		//* insert registo
		$user = new User();
		$user->username = 'perfil';
		$user->auth_key = 'pYrzNmor25ls9a8NH0HBbdU7mYpwP39v';
		$user->password_hash = '$2y$13$2ClCKgl3bfr2iDnm8sJMT.1IQII0/weFbmsbZE8.E7BQOwa5U5tCy';
		$user->password_reset_token = null;
		$user->email = 'perfil@mail.com';
		$user->verification_token = null;
		$this->assertTrue($user->save());

		$perfil = new Perfil();
		$perfil->id_user = $user->id;
		$perfil->nome = 'perfil nome exemplo';
		$perfil->nif = '123456789';
		$perfil->pais = 'perfil pais exemplo';
		$perfil->distrito = 'perfil distrito exemplo';
		$perfil->morada = 'perfil morada exemplo';
		$perfil->telefone = '123456789';
		$this->assertTrue($perfil->save());

		//* verificar se o registo se encontra na BD
		$test_perfil = $this->tester->grabRecord(Perfil::class, ['id_user' => $user->id]);

		$this->assertNotNull($test_perfil);
		$this->assertIsObject($test_perfil);

		//* update registo
		$test_perfil->nome = 'perfil nome exemplo 2';
		$this->assertTrue($test_perfil->save());

		//* verificar se o registo foi atualizado
		$update_perfil = $this->tester->grabRecord(Perfil::class, ['nome' => 'perfil nome exemplo 2']);

		$this->assertNotNull($update_perfil);
		$this->assertIsObject($update_perfil);

		//* delete registo
		$update_perfil->delete();

		//* verificar se o registo foi eliminado
		$delete_perfil = $this->tester->grabRecord(Perfil::class, ['nome' => 'perfil nome exemplo 2']);

		$this->assertNull($delete_perfil);
	}
}
