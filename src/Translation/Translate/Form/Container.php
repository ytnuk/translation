<?php

namespace Ytnuk\Translation\Translate\Form;

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
	protected function addProperty(Nextras\Orm\Entity\Reflection\PropertyMetadata $property)
	{
		$component = parent::addProperty($property);
		switch ($property->name) {
			case 'translation':
			case 'locale':
				$component->setOption('unique', TRUE);
		}

		return $component;
	}
}
