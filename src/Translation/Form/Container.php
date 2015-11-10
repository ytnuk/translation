<?php
namespace Ytnuk\Translation\Form;

use Nette;
use Nextras;
use Ytnuk;

final class Container
	extends Ytnuk\Orm\Form\Container
{

	protected function addPropertyTranslates(Nextras\Orm\Entity\Reflection\PropertyMetadata $metadata)
	{
		$parent = $this->lookupSelf(FALSE);
		$parentProperty = $parent ? $parent->getMetadata()->getProperty($this->name) : NULL;
		$translates = parent::addPropertyOneHasMany(
			$metadata,
			(int) ! $isNullable = $parentProperty && $parentProperty->relationship && $parentProperty->relationship->type === Nextras\Orm\Entity\Reflection\PropertyRelationshipMetadata::ONE_HAS_ONE && $parentProperty->isNullable
		);
		if ($parent) {
			$translates->getCurrentGroup()->setOption(
				'label',
				$caption = $parent->formatPropertyLabel($parent->getMetadata()->getProperty($this->getName()))
			);
			foreach (
				$translates->getContainers() as $container
			) {
				$container['value']->caption = $caption;
			}
		}
		if ($isNullable && $this->getForm()->isSubmitted()) {
			$containers = array_filter(
				$translates->getContainers()->getArrayCopy(),
				function (Nette\ComponentModel\Component $component) {
					$delete = $component['delete'] ?? NULL;

					return $component instanceof parent && ! ($delete instanceof Nette\Forms\Controls\SubmitButton && $delete->isSubmittedBy());
				}
			);
			if ( ! $containers) {
				$this->removeEntity();
			}
		}

		return $translates;
	}
}
