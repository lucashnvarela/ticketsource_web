<?php

namespace frontend\tests;

use common\models\Evento;
use common\models\Sessao;

class SessaoTest extends \Codeception\Test\Unit {
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
		$sessao = new Sessao();

		//* data
		$sessao->data = '2018-12-12';
		$this->assertTrue($sessao->validate(['data']));

		$sessao->data = self::MAX_CHARACTERS;
		$this->assertFalse($sessao->validate(['data']));

		$sessao->data = self::INT_VALUE;
		$this->assertFalse($sessao->validate(['data']));

		$sessao->data = null;
		$this->assertFalse($sessao->validate(['data']));

		//* localização
		$sessao->localizacao = 'sessao localizacao exemplo';
		$this->assertTrue($sessao->validate(['localizacao']));

		$sessao->localizacao = self::MAX_CHARACTERS;
		$this->assertFalse($sessao->validate(['localizacao']));

		$sessao->localizacao = self::INT_VALUE;
		$this->assertFalse($sessao->validate(['localizacao']));

		$sessao->localizacao = null;
		$this->assertFalse($sessao->validate(['localizacao']));

		//* numero_lugares
		$sessao->numero_lugares = self::INT_VALUE;
		$this->assertTrue($sessao->validate(['numero_lugares']));

		$sessao->numero_lugares = self::MAX_CHARACTERS;
		$this->assertFalse($sessao->validate(['numero_lugares']));

		$sessao->numero_lugares = null;
		$this->assertFalse($sessao->validate(['numero_lugares']));

		//* preço
		$sessao->preco = self::FLOAT_VALUE;
		$this->assertTrue($sessao->validate(['preco']));

		$sessao->preco = self::MAX_CHARACTERS;
		$this->assertFalse($sessao->validate(['preco']));

		$sessao->preco = self::INT_VALUE;
		$this->assertTrue($sessao->validate(['preco']));

		$sessao->preco = null;
		$this->assertFalse($sessao->validate(['preco']));
	}

	public function testModel() {
		//* insert registo
		$evento = new Evento();
		$evento->titulo = 'evento nome exemplo';
		$evento->descricao = 'evento descricao exemplo';
		$evento->categoria = 'Música';
		$evento->nome_pic = 'evento nome_pic.jpg';
		$this->assertTrue($evento->save());

		$sessao = new Sessao();
		$sessao->id_evento = $evento->id;
		$sessao->data = '2018-12-12';
		$sessao->localizacao = 'sessao localizacao exemplo';
		$sessao->numero_lugares = self::INT_VALUE;
		$sessao->preco = self::FLOAT_VALUE;
		$this->assertTrue($sessao->save());

		//* verificar se o registo se encontra na BD
		$test_sessao = $this->tester->grabRecord(Sessao::class, ['id' => $sessao->id]);

		$this->assertNotNull($test_sessao);
		$this->assertIsObject($test_sessao);

		//* update registo
		$test_sessao->data = '2017-12-12';
		$this->assertTrue($test_sessao->save());

		//* verificar se o registo foi atualizado
		$update_sessao = $this->tester->grabRecord(Sessao::class, ['data' => '2017-12-12']);

		$this->assertNotNull($update_sessao);
		$this->assertIsObject($update_sessao);

		//* delete registo
		$update_sessao->delete();

		//* verificar se o registo foi eliminado
		$delete_sessao = $this->tester->grabRecord(Sessao::class, ['data' => '2017-12-12']);

		$this->assertNull($delete_sessao);
	}
}
