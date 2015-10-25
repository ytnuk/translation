<?php
namespace Ytnuk\Translation;

use Kdyby;
use Nextras;
use Ytnuk;

/**
 * @property int $id {primary}
 * @property Nextras\Orm\Relationships\OneHasMany|Ytnuk\Translation\Translate\Entity[] $translates {1:m Ytnuk\Translation\Translate\Entity::$translation}
 * @property-read Ytnuk\Translation\Translate\Entity|NULL $translate {virtual}
 */
class Entity
	extends Ytnuk\Orm\Entity
{

	const PROPERTY_NAME = 'translate';

	public function getterTranslate()
	{
		return $this->translates->get()->fetch();
	}
}
