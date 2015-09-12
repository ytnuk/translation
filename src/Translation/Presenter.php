<?php
namespace Ytnuk\Translation;

use Nette;
use Ytnuk;

final class Presenter
	extends Ytnuk\Web\Presenter
{

	/**
	 * @var Repository
	 */
	private $repository;

	/**
	 * @var Control\Factory
	 */
	private $control;

	/**
	 * @var Entity
	 */
	private $translation;

	public function __construct(
		Repository $repository,
		Control\Factory $control
	) {
		parent::__construct();
		$this->repository = $repository;
		$this->control = $control;
	}

	public function actionEdit(int $id)
	{
		if ( ! $this->translation = $this->repository->getById($id)) {
			$this->error();
		}
	}

	public function renderEdit()
	{
		$this[Ytnuk\Web\Control::class][Ytnuk\Menu\Control::class][] = 'translation.presenter.action.edit';
	}

	protected function createComponentYtnukTranslationControl() : Control
	{
		return $this->control->create($this->translation ? : new Entity);
	}
}
