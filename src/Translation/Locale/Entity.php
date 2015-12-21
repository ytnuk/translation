<?php
namespace Ytnuk\Translation\Locale;

use Nextras;
use Ytnuk;

/**
 * @property string $id {primary}
 * @property string $name
 * @property Nextras\Orm\Relationships\OneHasMany|Ytnuk\Translation\Translate\Entity[] $translates {1:m Ytnuk\Translation\Translate\Entity::$locale, orderBy=translation}
 */
final class Entity
	extends Ytnuk\Orm\Entity
{

	const PROPERTY_NAME = 'name';
}
