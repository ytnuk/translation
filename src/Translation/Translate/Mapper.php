<?php
namespace Ytnuk\Translation\Translate;

use Nextras;
use Ytnuk;

final class Mapper
	extends Ytnuk\Orm\Mapper
{

	public function findAll() : Nextras\Orm\Mapper\Dbal\DbalCollection
	{
		return Ytnuk\Translation\Locale\Mapper::sortCollectionByLocales(parent::findAll(), 'locale_id');
	}
}
