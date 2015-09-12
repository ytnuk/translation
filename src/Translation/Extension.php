<?php
namespace Ytnuk\Translation;

use Kdyby;
use Nette;
use Ytnuk;

final class Extension
	extends Nette\DI\CompilerExtension
	implements Ytnuk\Config\Provider
{

	public function getConfigResources() : array
	{
		return [
			Ytnuk\Orm\Extension::class => [
				'repositories' => [
					$this->prefix('repository') => Repository::class,
					$this->prefix('translateRepository') => Translate\Repository::class,
					$this->prefix('localeRepository') => Locale\Repository::class,
				],
			],
			Kdyby\Translation\DI\TranslationExtension::class => [
				'dirs' => [
					__DIR__ . '/../../locale',
				],
			],
			'services' => [
				Control\Factory::class,
				Form\Control\Factory::class,
			],
		];
	}

	public function beforeCompile()
	{
		parent::beforeCompile();
		$builder = $this->getContainerBuilder();
		$translator = $builder->getDefinition($builder->getByType(Nette\Localization\ITranslator::class));
		$translator->setClass(
			Translator::class,
			$translator->getFactory()->arguments
		);
	}
}
