<?php
namespace Ytnuk\Translation\Form\Control;

use Ytnuk;

interface Factory
{

	public function create(Ytnuk\Translation\Entity $translation) : Ytnuk\Translation\Form\Control;
}
