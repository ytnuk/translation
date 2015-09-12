<?php
namespace Ytnuk\Translation\Form;

use Ytnuk;

final class Control
	extends Ytnuk\Orm\Form\Control
{

	public function __construct(
		Ytnuk\Translation\Entity $translation,
		Ytnuk\Orm\Form\Factory $form
	) {
		parent::__construct(
			$translation,
			$form
		);
	}
}
