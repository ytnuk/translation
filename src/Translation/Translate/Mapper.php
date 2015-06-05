<?php

namespace Ytnuk\Translation\Translate;

use Nette;
use Nextras;
use Ytnuk;
use Kdyby;

/**
 * Class Mapper
 *
 * @package Ytnuk\Translation
 */
final class Mapper extends Ytnuk\Orm\Mapper
{

	/**
	 * @var Kdyby\Translation\Translator
	 */
	private $translator;

	/**
	 * @inheritdoc
	 */
	public function __construct(Nextras\Dbal\Connection $connection, Nette\Caching\IStorage $cacheStorage, Kdyby\Translation\Translator $translator = NULL)
	{
		parent::__construct($connection, $cacheStorage);
		$this->translator = $translator;
	}

	/**
	 * @inheritdoc
	 */
	public function createCollectionOneHasMany(Nextras\Orm\Entity\Reflection\PropertyMetadata $metadata, Nextras\Orm\Entity\IEntity $parent)
	{
		$collection = parent::createCollectionOneHasMany($metadata, $parent);

		return $this->translator ? $this->sortCollectionByLocales($collection, [
			$this->translator->getLocale(),
			$this->translator->getDefaultLocale()
		]) : $collection;
	}

	/**
	 * @param Nextras\Orm\Mapper\Dbal\DbalCollection $collection
	 * @param array $locales
	 *
	 * @return Nextras\Orm\Mapper\Dbal\DbalCollection
	 */
	private function sortCollectionByLocales(Nextras\Orm\Mapper\Dbal\DbalCollection $collection, array $locales = [])
	{
		$builder = $collection->getQueryBuilder();
		foreach ($locales as $locale) {
			$separator = strpos($locale, '_');
			$subLocales = $separator === FALSE ? [$locale] : [
				$locale,
				substr($locale, 0, $separator)
			];
			foreach ($subLocales as $subLocale) {
				$arguments = [
					'query' => implode('=', [
							'locale_id',
							'%s'
						]) . ' DESC',
					'locale' => $subLocale,
				];
				call_user_func_array([
					$builder,
					'addOrderBy'
				], $arguments);
			}
		}

		return $collection;
	}
}
