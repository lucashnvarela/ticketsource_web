<?php

namespace frontend\tests;

use common\models\Evento;

class EventoTest extends \Codeception\Test\Unit {
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
		$evento = new Evento();

		//* titulo
		$evento->titulo = 'evento titulo exemplo';
		$this->assertTrue($evento->validate(['titulo']));

		$evento->titulo = self::MAX_CHARACTERS;
		$this->assertFalse($evento->validate(['titulo']));

		$evento->titulo = self::INT_VALUE;
		$this->assertFalse($evento->validate(['titulo']));

		$evento->titulo = null;
		$this->assertFalse($evento->validate(['titulo']));

		//* descrição
		$evento->descricao = 'evento descricao exemplo';
		$this->assertTrue($evento->validate(['descricao']));

		$evento->descricao = self::MAX_CHARACTERS;
		$this->assertFalse($evento->validate(['descricao']));

		$evento->descricao = self::INT_VALUE;
		$this->assertFalse($evento->validate(['descricao']));

		$evento->descricao = null;
		$this->assertTrue($evento->validate(['descricao']));

		//* categoria
		$evento->categoria = 'Música';
		$this->assertTrue($evento->validate(['categoria']));

		$evento->categoria = self::MAX_CHARACTERS;
		$this->assertFalse($evento->validate(['categoria']));

		$evento->categoria = self::INT_VALUE;
		$this->assertFalse($evento->validate(['categoria']));

		$evento->categoria = null;
		$this->assertFalse($evento->validate(['categoria']));

		//* nome_pic
		$evento->nome_pic = 'evento nome_pic.jpg';
		$this->assertTrue($evento->validate(['nome_pic']));

		$evento->nome_pic = self::MAX_CHARACTERS;
		$this->assertFalse($evento->validate(['nome_pic']));

		$evento->nome_pic = self::INT_VALUE;
		$this->assertFalse($evento->validate(['nome_pic']));

		$evento->nome_pic = null;
		$this->assertFalse($evento->validate(['nome_pic']));
	}

	public function testModel() {
		//* insert registo
		$evento = new Evento();
		$evento->titulo = 'evento titulo exemplo';
		$evento->descricao = 'evento descricao exemplo';
		$evento->categoria = 'Música';
		$evento->nome_pic = 'evento nome_pic.jpg';
		$this->assertTrue($evento->save());

		//* verificar se o registo se encontra na BD
		$test_evento = $this->tester->grabRecord(Evento::class, ['id' => $evento->id]);

		$this->assertNotNull($test_evento);
		$this->assertIsObject($test_evento);

		//* update registo
		$test_evento->titulo = 'teste2';
		$this->assertTrue($test_evento->save());

		//* verificar se o registo foi atualizado
		$update_evento = $this->tester->grabRecord(Evento::class, ['titulo' => 'teste2']);

		$this->assertNotNull($update_evento);
		$this->assertIsObject($update_evento);

		//* delete registo
		$update_evento->delete();

		//* verificar se o registo foi eliminado
		$delete_evento = $this->tester->grabRecord(Evento::class, ['titulo' => 'teste2']);

		$this->assertNull($delete_evento);
	}
}
