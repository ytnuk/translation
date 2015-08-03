<?php
namespace Ytnuk\Translation;

use InvalidArgumentException;
use Kdyby;
use Nextras;

/**
 * Class Translator
 *
 * @package Ytnuk\Translation
 */
final class Translator
	extends Kdyby\Translation\Translator
{

	/**
	 * @inheritdoc
	 */
	protected function assertValidLocale($locale)
	{
		try {
			parent::assertValidLocale($locale);
		} catch (InvalidArgumentException $ex) {
		}
	}

	/**
	 * @inheritdoc
	 */
	public function translate(
		$message,
		$count = NULL,
		$parameters = [],
		$domain = NULL,
		$locale = NULL
	) {
		if ($message instanceof Nextras\Orm\Entity\IEntity) {
			return $message;
		}

		return parent::translate(
			$message,
			$count,
			$parameters,
			$domain,
			$locale
		);
	}
}
