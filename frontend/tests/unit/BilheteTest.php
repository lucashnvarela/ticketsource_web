<?php

namespace frontend\tests;

use common\models\Evento;
use common\models\Sessao;
use common\models\Bilhete;

class BilheteTest extends \Codeception\Test\Unit {
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
		$bilhete = new Bilhete();

		//* uid
		$bilhete->generateUUID();
		$this->assertTrue($bilhete->validate(['uid']));

		$bilhete->uid = self::MAX_CHARACTERS;
		$this->assertFalse($bilhete->validate(['uid']));

		$bilhete->uid = self::INT_VALUE;
		$this->assertFalse($bilhete->validate(['uid']));

		$bilhete->uid = null;
		$this->assertFalse($bilhete->validate(['uid']));

		//* numero_lugar
		$bilhete->numero_lugar = self::INT_VALUE;
		$this->assertTrue($bilhete->validate(['numero_lugar']));

		$bilhete->numero_lugar = self::MAX_CHARACTERS;
		$this->assertFalse($bilhete->validate(['numero_lugar']));

		$bilhete->numero_lugar = self::FLOAT_VALUE;
		$this->assertFalse($bilhete->validate(['numero_lugar']));

		$bilhete->numero_lugar = null;
		$this->assertFalse($bilhete->validate(['numero_lugar']));

		//* disponivel
		$bilhete->disponivel = Bilhete::STATUS_DISPONIVEL;
		$this->assertTrue($bilhete->validate(['disponivel']));

		$bilhete->disponivel = self::MAX_CHARACTERS;
		$this->assertFalse($bilhete->validate(['disponivel']));

		$bilhete->disponivel = self::INT_VALUE;
		$this->assertFalse($bilhete->validate(['disponivel']));

		$bilhete->disponivel = null;
		$this->assertFalse($bilhete->validate(['disponivel']));

		//* status
		$bilhete->status = Bilhete::STATUS_ATIVO;
		$this->assertTrue($bilhete->validate(['status']));

		$bilhete->status = self::MAX_CHARACTERS;
		$this->assertFalse($bilhete->validate(['status']));

		$bilhete->status = self::INT_VALUE;
		$this->assertFalse($bilhete->validate(['status']));

		$bilhete->status = null;
		$this->assertFalse($bilhete->validate(['status']));
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
		$sessao->preco = 10;
		$this->assertTrue($sessao->save());

		$bilhete = new Bilhete();
		$bilhete->id_sessao = $sessao->id;
		$bilhete->generateUUID();
		$bilhete->numero_lugar = 1;
		$bilhete->disponivel = Bilhete::STATUS_DISPONIVEL;
		$bilhete->status = Bilhete::STATUS_ATIVO;
		$this->assertTrue($bilhete->save());

		//* verificar se o registo se encontra na BD
		$test_bilhete = $this->tester->grabRecord(Bilhete::class, ['id' => $bilhete->id]);

		$this->assertNotNull($test_bilhete);
		$this->assertIsObject($test_bilhete);

		//* update registo
		$test_bilhete->disponivel = Bilhete::STATUS_CANCELADO;
		$this->assertTrue($test_bilhete->save());

		//* verificar se o registo foi atualizado
		$update_bilhete = $this->tester->grabRecord(Bilhete::class, ['disponivel' => Bilhete::STATUS_CANCELADO]);

		$this->assertNotNull($update_bilhete);
		$this->assertIsObject($update_bilhete);

		//* delete registo
		$update_bilhete->delete();

		//* verificar se o registo foi eliminado
		$delete_bilhete = $this->tester->grabRecord(Bilhete::class, ['disponivel' => Bilhete::STATUS_CANCELADO]);

		$this->assertNull($delete_bilhete);
	}
}
