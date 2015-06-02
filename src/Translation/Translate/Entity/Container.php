<?php

namespace Ytnuk\Translation\Translate\Entity;

use Nextras;
use Kdyby;

/**
 * Class Container
 *
 * @package Ytnuk\Translation
 */
final class Container extends Nextras\Orm\Relationships\OneHasMany
{

	/**
	 * @var Kdyby\Translation\Translator
	 */
	private $translator;

	/**
	 * @inheritdoc
	 */
	public function __construct(Nextras\Orm\Entity\IEntity $parent, Nextras\Orm\Entity\Reflection\PropertyMetadata $metadata)
	{
		parent::__construct($parent, $metadata);
		if (method_exists($parent, 'getTranslator')) {
			$this->translator = $parent->getTranslator();
		}
	}

	/**
	 * @inheritdoc
	 */
	protected function createCollection()
	{
		$collection = parent::createCollection();

		return $this->translator ? $this->sortByLocales($collection, [
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
	private function sortByLocales(Nextras\Orm\Mapper\Dbal\DbalCollection $collection, array $locales = [])
	{
		$collection = $collection->findBy(['this->locale->identifier!=' => NULL]);
		$builder = $collection->getQueryBuilder();
		foreach ($locales as $locale) {
			$arguments = [
				'query' => implode('=', [
						'locale.identifier',
						'%s'
					]) . ' DESC',
				'locale' => $locale,
			];
			call_user_func_array([
				$builder,
				'addOrderBy'
			], $arguments);
		}

		return $collection;
	}
}
