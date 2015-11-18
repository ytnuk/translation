<?php
namespace Ytnuk\Translation;

use Kdyby;
use Nette;
use Ytnuk;

final class Extension
	extends Nette\DI\CompilerExtension
	implements Ytnuk\Orm\Provider, Kdyby\Translation\DI\ITranslationProvider
{

	public function getTranslationResources() : array
	{
		return [
			__DIR__ . '/../../locale',
		];
	}

	public function getOrmResources() : array
	{
		return [
			'repositories' => [
				$this->prefix('repository') => Repository::class,
				$this->prefix('translateRepository') => Translate\Repository::class,
				$this->prefix('localeRepository') => Locale\Repository::class,
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

	public function loadConfiguration()
	{
		parent::loadConfiguration();
		$builder = $this->getContainerBuilder();
		$builder->addDefinition($this->prefix('control'))->setImplement(Control\Factory::class);
		$builder->addDefinition($this->prefix('form.control'))->setImplement(Form\Control\Factory::class);
	}

	public function setCompiler(
		Nette\DI\Compiler $compiler,
		$name
	) : self
	{
		$compiler->addExtension(
			'kdyby.translation',
			new Kdyby\Translation\DI\TranslationExtension
		);

		return parent::setCompiler(
			$compiler,
			$name
		);
	}
}
