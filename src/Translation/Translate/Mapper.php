<?php
namespace Ytnuk\Translation\Translate;

use Nette;
use Nextras;
use Ytnuk;

final class Mapper
	extends Ytnuk\Orm\Mapper
{

	/**
	 * @var Ytnuk\Translation\Locale\Mapper
	 */
	private $localeMapper;

	public function __construct(
		Nextras\Dbal\Connection $connection,
		Nette\Caching\IStorage $cacheStorage,
		Ytnuk\Translation\Locale\Mapper $localeMapper
	) {
		parent::__construct($connection, $cacheStorage);
		$this->localeMapper = $localeMapper;
	}

	public function findAll() : Nextras\Orm\Mapper\Dbal\DbalCollection
	{
		return $this->localeMapper->sortCollectionByLocales(parent::findAll(), 'locale_id');
	}
}
