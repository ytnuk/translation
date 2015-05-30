<?php

namespace Ytnuk\Translation\Form;

use Nette;
use Ytnuk;
use Nextras;

/**
 * Class Container
 *
 * @package Ytnuk\Translation
 */
final class Container extends Ytnuk\Orm\Form\Container
{

	/**
	 * @inheritdoc
	 */
	public function setValues($values, $erase = FALSE)
	{
		if ($container = $this->lookup(Ytnuk\Orm\Form\Container::class, FALSE)) {
			$this->entity->setValue('key', $container->prefix($this->getName()));
		}

		return parent::setValues($values, $erase);
	}

	/**
	 * @inheritdoc
	 */
	protected function addPropertyTranslations(Nextras\Orm\Entity\Reflection\PropertyMetadata $property)
	{
		$translations = parent::addPropertyOneHasMany($property, 1);
		if ($container = $this->lookup(Ytnuk\Orm\Form\Container::class, FALSE)) {
			$translations->getCurrentGroup()->setOption('label', $container->formatPropertyLabel($container->getMetadata()->getProperty($this->getName())));
		}

		return $translations;
	}

	/**
	 * @inheritdoc
	 */
	protected function attached($form)
	{
		parent::attached($form);
		if ($container = $this->lookup(Ytnuk\Orm\Form\Container::class, FALSE)) {
			unset($this['key']);
		}
	}
}
