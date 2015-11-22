<?php
namespace Ytnuk\Translation\Translate;

use Nextras;
use Ytnuk;

/**
 * @property int $id {primary}
 * @property string $value
 * @property Nextras\Orm\Relationships\ManyHasOne|Ytnuk\Translation\Entity $translation {m:1 Ytnuk\Translation\Entity::$translates}
 * @property Nextras\Orm\Relationships\ManyHasOne|Ytnuk\Translation\Locale\Entity $locale {m:1 Ytnuk\Translation\Locale\Entity::$translates}
 */
final class Entity
	extends Ytnuk\Orm\Entity
{

	const PROPERTY_NAME = 'value';
}
