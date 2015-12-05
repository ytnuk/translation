<?php
namespace Ytnuk\Translation;

use Nette;
use Ytnuk;

final class Control
	extends Ytnuk\Orm\Control
{

	/**
	 * @var Entity
	 */
	private $translation;

	/**
	 * @var Repository
	 */
	private $repository;

	/**
	 * @var Form\Control\Factory
	 */
	private $formControl;

	/**
	 * @var Ytnuk\Orm\Grid\Control\Factory
	 */
	private $gridControl;

	public function __construct(
		Entity $translation,
		Repository $repository,
		Form\Control\Factory $formControl,
		Ytnuk\Orm\Grid\Control\Factory $gridControl
	) {
		parent::__construct($translation);
		$this->translation = $translation;
		$this->repository = $repository;
		$this->formControl = $formControl;
		$this->gridControl = $gridControl;
	}

	protected function createComponentForm() : Form\Control
	{
		return $this->formControl->create($this->translation);
	}

	protected function createComponentGrid() : Ytnuk\Orm\Grid\Control
	{
		return $this->gridControl->create($this->repository);
	}
}
