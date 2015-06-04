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
	protected function addPropertyTranslates(Nextras\Orm\Entity\Reflection\PropertyMetadata $property)
	{
		$translates = parent::addPropertyOneHasMany($property, 1);
		if ($parent = $this->lookup(Ytnuk\Orm\Form\Container::class, FALSE)) {
			$translates->getCurrentGroup()->setOption('label', $caption = $parent->formatPropertyLabel($parent->getMetadata()->getProperty($this->getName())));
			foreach ($translates->containers as $container) {
				$container['value']->caption = $caption;
			}
		}

		return $translates;
	}
}
