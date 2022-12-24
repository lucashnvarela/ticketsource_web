<?php

$params = array_merge(
	require(__DIR__ . '/../../common/config/params.php'),
	require(__DIR__ . '/../../common/config/params-local.php'),
	require(__DIR__ . '/params.php'),
	require(__DIR__ . '/params-local.php')
);

return [
	'id' => 'app-api',
	'basePath' => dirname(__DIR__),
	'bootstrap' => ['log'],
	'modules' => [
		'v1' => [
			'basePath' => '@app/modules/v1',
			'class' => 'api\modules\v1\Module'
		]
	],
	'components' => [
		'user' => [
			'identityClass' => 'common\models\User',
			'enableAutoLogin' => false,
		],
		'log' => [
			'traceLevel' => YII_DEBUG ? 3 : 0,
			'targets' => [
				[
					'class' => 'yii\log\FileTarget',
					'levels' => ['error', 'warning'],
				],
			],
		],
		'request' => [
			'enableCookieValidation' => false,
			'parsers' => [
				'application/json' => 'yii\web\JsonParser',
			]
		],
		'urlManager' => [
			'enablePrettyUrl' => true,
			'showScriptName' => false,
			'rules' => [
				[ //* User
					'class' => 'yii\rest\UrlRule',
					'controller' => 'v1/user',
					'pluralize' => false,
					'extraPatterns' => [
						'POST registo' => 'registo',
						'POST login' => 'login',
						'GET check/{token}' => 'check',
					],
					'tokens' =>
					[
						'{id}' => '<id:\\d+>',
						'{username}' => '<username:.*?>',
						'{token}' => '<token:.*?>',
					],
				],
				[ //* Evento
					'class' => 'yii\rest\UrlRule',
					'controller' => 'v1/evento',
					'pluralize' => false,
					'extraPatterns' => [
						'GET lista' => 'lista',
					],
					'tokens' =>
					[
						'{id}' => '<id:.*?>',
						'{token}' => '<token:.*?>',
						'{pesquisa}' => '<pesquisa:.*?>',
					],
				],
				[ //* Bilhete
					'class' => 'yii\rest\UrlRule',
					'controller' => 'v1/bilhete',
					'pluralize' => false,
					'extraPatterns' => [
						'GET lista/{token}' => 'lista',
						'GET cancelar/{id}/{token}' => 'cancelar',
						'GET checkin/{id}' => 'checkin',
					],
					'tokens' =>
					[
						'{pesquisa}' => '<pesquisa:.*?>',
						'{token}' => '<token:.*?>',
					],
				],
				[ //* Favorito
					'class' => 'yii\rest\UrlRule',
					'controller' => 'v1/favorito',
					'pluralize' => false,
					'extraPatterns' => [
						'GET lista/{token}' => 'lista',
						'POST adicionar/{id}/{token}' => 'adicionar',
						'DELETE remover/{id}/{token}' => 'remover',
						'GET check/{id}/{token}' => 'check',
					],
					'tokens' =>
					[
						'{id}' => '<id:.*?>',
						'{token}' => '<token:.*?>',
					],
				],
			],
		],
		'urlManagerBackend' => [
			'class' => 'yii\web\urlManager',
			'baseUrl' => '../../backend/web/imagens',
			'enablePrettyUrl' => true,
			'showScriptName' => false,
		],
	],
	'params' => $params,
];
