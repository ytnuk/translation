<?php

namespace Ytnuk\Translation;

use Nette;
use Nextras;
use Ytnuk;

/**
 * @property string $key
 * @property Nextras\Orm\Relationships\OneHasMany|Ytnuk\Translation\Translate\Entity[] $translations {1:m Ytnuk\Translation\Translate\Repository $translation}
 */
class Entity extends Ytnuk\Orm\Entity
{

	const PROPERTY_NAME = 'key';

	/**
	 * @var Nette\Localization\ITranslator
	 */
	private $translator;

	/**
	 * @param Nette\Localization\ITranslator $translator
	 */
	public function injectTranslator(Nette\Localization\ITranslator $translator)
	{
		$this->translator = $translator;
	}

	/**
	 * @inheritdoc
	 */
	public function __toString()
	{
		$translations = $this->translations->get();
		$translate = NULL;
		if (count($translations) && ! $translate = $translations->findBy(['this->locale->identifier' => $locale = $this->translator->getLocale()])->fetch()) {
			if ($length = strpos($locale, '_')) {
				$translate = $translations->findBy(['this->locale->identifier' => substr($locale, 0, $length)])->fetch();
			}
		}

		return $translate === NULL ? $this->translator->translate(parent::__toString()) : (string) $translate;
	}
}
