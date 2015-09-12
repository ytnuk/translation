<?php
namespace Ytnuk\Translation;

use InvalidArgumentException;
use Kdyby;
use Nextras;

final class Translator
	extends Kdyby\Translation\Translator
{

	protected function assertValidLocale($locale)
	{
		try {
			parent::assertValidLocale($locale);
		} catch (InvalidArgumentException $ex) {
		}
	}

	public function translate(
		$message,
		$count = NULL,
		$parameters = [],
		$domain = NULL,
		$locale = NULL
	) : string
	{
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
