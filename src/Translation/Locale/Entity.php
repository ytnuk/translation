<?php
namespace Ytnuk\Translation\Locale;

use Nextras;
use Ytnuk;

/**
 * @property string $id {primary}
 * @property string $name
 */
final class Entity
	extends Ytnuk\Orm\Entity
{

	const PROPERTY_NAME = 'name';
}
