<?php

namespace Ytnuk\Translation;

use Nette;
use Ytnuk;
use Kdyby;

/**
 * Class Extension
 *
 * @package Ytnuk\Translation
 */
final class Extension extends Nette\DI\CompilerExtension implements Ytnuk\Config\Provider
{

	/**
	 * @inheritdoc
	 */
	public function getConfigResources()
	{
		return [
			Ytnuk\Orm\Extension::class => [
				'repositories' => [
					$this->prefix('repository') => Repository::class,
					$this->prefix('translateRepository') => Translate\Repository::class,
					$this->prefix('localeRepository') => Locale\Repository::class,
				]
			],
			Kdyby\Translation\DI\TranslationExtension::class => [
				'dirs' => [
					__DIR__ . '/../../locale'
				]
			],
			'services' => [
				Control\Factory::class,
				Form\Control\Factory::class,
			]
		];
	}
}
