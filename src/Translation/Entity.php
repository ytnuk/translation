<?php

namespace Ytnuk\Translation;

use Nextras;
use Ytnuk;
use Kdyby;

/**
 * @property Nextras\Orm\Relationships\OneHasMany|Ytnuk\Translation\Translate\Entity[] $translates {1:m Ytnuk\Translation\Translate\Repository $translation}
 * @property-read Ytnuk\Translation\Translate\Entity|NULL $translate {virtual}
 */
class Entity extends Ytnuk\Orm\Entity
{

	const PROPERTY_NAME = 'translate';

	/**
	 * @return Ytnuk\Translation\Translate\Entity|NULL
	 */
	public function getterTranslate()
	{
		return $this->translates->get()->fetch();
	}
}
