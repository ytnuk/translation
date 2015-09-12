<?php
namespace Ytnuk\Translation\Translate;

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
		parent::__construct(
			$connection,
			$cacheStorage
		);
		$this->translator = $translator;
	}

	public function createCollection() : Nextras\Orm\Mapper\Dbal\DbalCollection
	{
		return $this->sortCollectionByLocales(
			parent::createCollection(),
			[
				$this->translator->getLocale(),
				$this->translator->getDefaultLocale(),
			]
		);
	}

	private function sortCollectionByLocales(
		Nextras\Orm\Mapper\Dbal\DbalCollection $collection,
		array $locales = []
	) : Nextras\Orm\Mapper\Dbal\DbalCollection
	{
		$builder = $collection->getQueryBuilder();
		foreach (
			$locales as $locale
		) {
			$separator = strpos(
				$locale,
				'_'
			);
			$subLocales = $separator === FALSE ? [$locale] : [
				$locale,
				substr(
					$locale,
					0,
					$separator
				),
			];
			foreach (
				$subLocales as $subLocale
			) {
				$builder->addOrderBy(
					implode(
						'=',
						[
							'locale_id',
							'%s',
						]
					) . ' DESC',
					$subLocale
				);
			}
		}

		return $collection;
	}
}
