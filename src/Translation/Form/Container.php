<?php
namespace Ytnuk\Translation\Form;

use Nette;
use Nextras;
use Ytnuk;

final class Container
	extends Ytnuk\Orm\Form\Container
	implements Nette\Forms\IFormRenderer
{

	/**
	 * @var array
	 */
	private static $locales = [];

	/**
	 * @var Nextras\Orm\Entity\IEntity
	 */
	private $entity;

	/**
	 * @var Nextras\Orm\Model\IModel
	 */
	private $model;

	public function __construct(
		Nextras\Orm\Entity\IEntity $entity,
		Nextras\Orm\Repository\IRepository $repository
	) {
		parent::__construct(
			$this->entity = $entity,
			$repository
		);
		$this->model = $repository->getModel();
	}

	protected function addPropertyTranslates(Nextras\Orm\Entity\Reflection\PropertyMetadata $metadata)
	{
		$translates = $this->addContainer($metadata->name);
		$localeRepository = $this->model->getRepositoryForEntity(Ytnuk\Translation\Locale\Entity::class);
		self::$locales ? : self::$locales = $localeRepository->findAll()->fetchPairs(
			current($localeRepository->getEntityMetadata()->getPrimaryKey())
		);
		$collection = array_combine(
			array_map(
				function (Ytnuk\Translation\Translate\Entity $entity) {
					return $entity->getRawValue('locale');
				},
				$collection = iterator_to_array($this->entity->getValue($metadata->name))
			),
			$collection
		);
		array_walk(
			self::$locales,
			function (Ytnuk\Translation\Locale\Entity $locale) use
			(
				$translates,
				$collection
			) {
				$translate = $translates->addContainer($locale->id);
				$value = $translate->addTextArea('value');
				$value->setOption(
					'locale',
					$locale
				);
				$translate = $collection[$locale->id] ?? NULL;
				if ($translate instanceof Ytnuk\Translation\Translate\Entity) {
					$value->setDefaultValue($translate->value);
				}
			}
		);
		$parent = $this->lookup(
			Ytnuk\Orm\Form\Container::class,
			FALSE
		);
		if ($parent instanceof Ytnuk\Orm\Form\Container) {
			$translates->getCurrentGroup()->setOption(
				'label',
				$parent->formatPropertyLabel($parent->getMetadata()->getProperty($this->getName()))
			);
			$parentProperty = $parent->getMetadata()->getProperty($this->name);
			$isNullable = $parentProperty->relationship && $parentProperty->relationship->type === Nextras\Orm\Entity\Reflection\PropertyRelationshipMetadata::ONE_HAS_ONE && $parentProperty->isNullable;
			if ( ! $isNullable) {
				//TODO: at least one translate needs to be filled
			}
		}

		return $translates;
	}

	public function render(
		Nette\Forms\Form $form,
		string $file = NULL
	) {
		return parent::render(
			$form,
			$file ? : implode(
				DIRECTORY_SEPARATOR,
				[
					__DIR__,
					basename(
						__FILE__,
						'.php'
					),
					'view.latte',
				]
			)
		);
	}
}
