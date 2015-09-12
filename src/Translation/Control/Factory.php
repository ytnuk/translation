<?php
namespace Ytnuk\Translation\Control;

use Ytnuk;

interface Factory
{

	public function create(Ytnuk\Translation\Entity $translation) : Ytnuk\Translation\Control;
}
