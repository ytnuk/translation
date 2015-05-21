<?php

namespace Ytnuk\Translation;

use Nextras;
use Ytnuk;

/**
 * @property string $key
 * @property Nextras\Orm\Relationships\OneHasMany|Ytnuk\Translation\Translate\Entity[] $translations {1:m Ytnuk\Translation\Translate\Repository $translation primary}
 */
class Entity extends Ytnuk\Orm\Entity
{

	const PROPERTY_NAME = 'key';
}
