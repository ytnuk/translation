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
		$parent = $this->lookup(Ytnuk\Orm\Form\Container::class, FALSE);
		$parentProperty = $parent ? $parent->getMetadata()->getProperty($this->name) : NULL;
		$translates = parent::addPropertyOneHasMany($property, (int) ! $isNullable = $parentProperty && $parentProperty->relationshipType === Nextras\Orm\Entity\Reflection\PropertyMetadata::RELATIONSHIP_ONE_HAS_ONE_DIRECTED && $parentProperty->isNullable);
		if ($parent = $this->lookup(Ytnuk\Orm\Form\Container::class, FALSE)) {
			$translates->getCurrentGroup()->setOption('label', $caption = $parent->formatPropertyLabel($parent->getMetadata()->getProperty($this->getName())));
			foreach ($translates->getContainers() as $container) {
				$container['value']->caption = $caption;
			}
		}
		if ($isNullable && $this->getForm()->isSubmitted()) {
			$containers = array_filter($translates->getContainers()->getArrayCopy(), function ($container) {
				return $container instanceof parent && ! $container['delete']->isSubmittedBy();
			});
			if ( ! $containers) {
				$this->removeEntity();
			}
		}

		return $translates;
	}
}
