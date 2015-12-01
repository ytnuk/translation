<?php
namespace Ytnuk\Translation;

use Kdyby;
use Nextras;
use Ytnuk;

/**
 * @property int $id {primary}
 * @property Nextras\Orm\Relationships\OneHasMany|Ytnuk\Translation\Translate\Entity[] $translates {1:m Ytnuk\Translation\Translate\Entity::$translation, cascade=[persist, remove]}
 * @property-read Ytnuk\Translation\Translate\Entity|NULL $translate {virtual}
 */
final class Entity
	extends Ytnuk\Orm\Entity
{

	const PROPERTY_NAME = 'translate';

	public function getterTranslate()
	{
		return $this->translates->get()->fetch();
	}
}
