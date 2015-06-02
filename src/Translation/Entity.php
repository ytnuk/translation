<?php

namespace Ytnuk\Translation;

use Nextras;
use Ytnuk;
use Kdyby;

/**
 * @property string $key
 * @property Nextras\Orm\Relationships\OneHasMany|Ytnuk\Translation\Translate\Entity[] $translations {1:m Ytnuk\Translation\Translate\Repository $translation} {container Translate\Entity\Container}
 */
class Entity extends Ytnuk\Orm\Entity
{

	const PROPERTY_NAME = 'key';

	/**
	 * @var Kdyby\Translation\Translator
	 */
	private $translator;

	/**
	 * @param Kdyby\Translation\Translator $translator
	 */
	public function injectTranslator(Kdyby\Translation\Translator $translator)
	{
		$this->translator = $translator;
	}

	/**
	 * @return Kdyby\Translation\Translator
	 */
	public function getTranslator()
	{
		return $this->translator;
	}

	/**
	 * @inheritdoc
	 */
	public function __toString()
	{
		return (string) ($this->translations->get()->fetch() ? : $this->translator->translate(parent::__toString()));
	}
}
