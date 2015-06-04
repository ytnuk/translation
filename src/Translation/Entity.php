<?php

namespace Ytnuk\Translation;

use Nextras;
use Ytnuk;
use Kdyby;

/**
 * @property Nextras\Orm\Relationships\OneHasMany|Ytnuk\Translation\Translate\Entity[] $translates {1:m Ytnuk\Translation\Translate\Repository $translation} {container Translate\Entity\Container}
 * @property-read Ytnuk\Translation\Translate\Entity|NULL $translate {virtual}
 */
class Entity extends Ytnuk\Orm\Entity
{

	const PROPERTY_NAME = 'translate';

	/**
	 * @var Kdyby\Translation\Translator
	 */
	private $translator;

	/**
	 * @return Kdyby\Translation\Translator
	 */
	public function getTranslator()
	{
		return $this->translator;
	}

	/**
	 * @param Kdyby\Translation\Translator $translator
	 */
	public function injectTranslator(Kdyby\Translation\Translator $translator)
	{
		$this->translator = $translator;
	}

	/**
	 * @return Ytnuk\Translation\Translate\Entity|NULL
	 */
	public function getterTranslate()
	{
		return $this->translates->get()->fetch();
	}
}
