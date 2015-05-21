<?php

namespace Ytnuk\Translation\Locale;

use Nextras;
use Ytnuk;

/**
 * @property string $identifier
 * @property string $name
 * @property Nextras\Orm\Relationships\OneHasMany|Ytnuk\Translation\Translate\Entity[] $translations {1:m Ytnuk\Translation\Translate\Repository $locale primary}
 */
class Entity extends Ytnuk\Orm\Entity
{

	const PROPERTY_NAME = 'name';
}
