<?php
namespace Ytnuk\Translation\Locale;

use Kdyby;
use Nette;
use Nextras;
use Ytnuk;

final class Mapper
	extends Ytnuk\Orm\Mapper
{

	/**
	 * @var Kdyby\Translation\Translator
	 */
	private $translator;

	public function __construct(
		Nextras\Dbal\Connection $connection,
		Nette\Caching\IStorage $cacheStorage,
		Kdyby\Translation\Translator $translator
	) {
		parent::__construct($connection, $cacheStorage);
		$this->translator = $translator;
	}

	public function findAll() : Nextras\Orm\Mapper\Dbal\DbalCollection
	{
		return self::sortCollectionByLocales(parent::findAll(), 'id');
	}

	public function sortCollectionByLocales(
		Nextras\Orm\Mapper\Dbal\DbalCollection $collection,
		string $column
	) : Nextras\Orm\Mapper\Dbal\DbalCollection
	{
		$builder = $collection->getQueryBuilder();
		foreach (
			[
				$this->translator->getLocale(),
				$this->translator->getDefaultLocale(),
			] as $locale
		) {
			$separator = strpos($locale, '_');
			$subLocales = $separator === FALSE ? [$locale] : [
				$locale,
				substr($locale, 0, $separator),
			];
			foreach (
				$subLocales as $subLocale
			) {
				$builder->addOrderBy(implode('=', [
						$column,
						'%s',
					]) . ' DESC', $subLocale);
			}
		}

		return $collection;
	}
}
