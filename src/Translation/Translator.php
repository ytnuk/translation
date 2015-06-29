<?php

namespace Ytnuk\Translation;

use Kdyby;
use Nextras;

/**
 * Class Translator
 *
 * @package Ytnuk\Translation
 */
final class Translator extends Kdyby\Translation\Translator
{

	/**
	 * @inheritdoc
	 */
	public function translate($message, $count = NULL, $parameters = [], $domain = NULL, $locale = NULL)
	{
		if ($message instanceof Nextras\Orm\Entity\IEntity) {
			return $message;
		}

		return parent::translate($message, $count, $parameters, $domain, $locale);
	}

	/**
	 * @inheritdoc
	 */
	protected function assertValidLocale($locale)
	{
	}
}
