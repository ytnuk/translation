<?php
namespace Ytnuk\Translation\Locale;

use Nextras;
use Ytnuk;

/**
 * @property string $id
 * @property string $name
 * @property Nextras\Orm\Relationships\OneHasMany|Ytnuk\Translation\Translate\Entity[] $translates {1:m Ytnuk\Translation\Translate\Entity::$locale order:translation primary}
 */
class Entity
	extends Ytnuk\Orm\Entity
{

	const PROPERTY_NAME = 'name';
}
