<?php

namespace frontend\tests;

use common\models\User;
use frontend\models\Fatura;
use frontend\models\Pagamento;

class PagamentoTest extends \Codeception\Test\Unit {
	/**
	 * @var \frontend\tests\UnitTester
	 */
	protected $tester;

	const MAX_CHARACTERS = 'kkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkk';
	const INT_VALUE = 100;
	const FLOAT_VALUE = 100.50;

	protected function _before() {
	}

	protected function _after() {
	}

	public function testValidations() {
		$pagamento = new Pagamento();

		//* numero_cartao
		$pagamento->numero_cartao = 1234567890123456;
		$this->assertTrue($pagamento->validate(['numero_cartao']));

		$pagamento->numero_cartao = self::MAX_CHARACTERS;
		$this->assertFalse($pagamento->validate(['numero_cartao']));

		$pagamento->numero_cartao = self::INT_VALUE;
		$this->assertFalse($pagamento->validate(['numero_cartao']));

		$pagamento->numero_cartao = null;
		$this->assertFalse($pagamento->validate(['numero_cartao']));

		//* data_validade
		$pagamento->data_validade = '12-2023';
		$this->assertTrue($pagamento->validate(['data_validade']));

		$pagamento->data_validade = self::MAX_CHARACTERS;
		$this->assertFalse($pagamento->validate(['data_validade']));

		$pagamento->data_validade = self::INT_VALUE;
		$this->assertFalse($pagamento->validate(['data_validade']));

		$pagamento->data_validade = null;
		$this->assertFalse($pagamento->validate(['data_validade']));

		//* codigo_seguranca
		$pagamento->codigo_seguranca = 123;
		$this->assertTrue($pagamento->validate(['codigo_seguranca']));

		$pagamento->codigo_seguranca = self::MAX_CHARACTERS;
		$this->assertFalse($pagamento->validate(['codigo_seguranca']));

		$pagamento->codigo_seguranca = self::FLOAT_VALUE;
		$this->assertFalse($pagamento->validate(['codigo_seguranca']));

		$pagamento->codigo_seguranca = null;
		$this->assertFalse($pagamento->validate(['codigo_seguranca']));
	}

	public function testModel() {
		//* insert registo
		$user = new User();
		$user->username = 'pagamento';
		$user->auth_key = 'pYrzNmor25ls9a8NH0HBbdU7mYpwP39v';
		$user->password_hash = '$2y$13$2ClCKgl3bfr2iDnm8sJMT.1IQII0/weFbmsbZE8.E7BQOwa5U5tCy';
		$user->password_reset_token = null;
		$user->email = 'pagamento@mail.com';
		$user->verification_token = null;
		$this->assertTrue($user->save());

		$fatura = new Fatura();
		$fatura->id_user = $user->id;
		$fatura->data = '2018-12-12';
		$fatura->total = 10;
		$this->assertTrue($fatura->save());

		$pagamento = new Pagamento();
		$pagamento->id_fatura = $fatura->id;
		$pagamento->numero_cartao = 1234567890123456;
		$pagamento->data_validade = '2023-12-01';
		$pagamento->codigo_seguranca = 123;
		$this->assertTrue($pagamento->save(false));

		//* verificar se o registo se encontra na BD
		$test_pagamento = $this->tester->grabRecord(Pagamento::class, ['id' => $pagamento->id]);

		$this->assertNotNull($test_pagamento);
		$this->assertIsObject($test_pagamento);

		//* update registo
		$test_pagamento->data_validade = '2023-10-01';
		$this->assertTrue($test_pagamento->save(false));

		//* verificar se o registo foi atualizado
		$update_pagamento = $this->tester->grabRecord(Pagamento::class, ['data_validade' => '2023-10-01']);

		$this->assertNotNull($update_pagamento);
		$this->assertIsObject($update_pagamento);

		//* delete registo
		$update_pagamento->delete();

		//* verificar se o registo foi eliminado
		$delete_pagamento = $this->tester->grabRecord(Pagamento::class, ['data_validade' => '2023-10-01']);

		$this->assertNull($delete_pagamento);
	}
}
