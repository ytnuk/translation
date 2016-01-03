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
		parent::__construct($this->entity = $entity, $repository);
		$this->model = $repository->getModel();
	}

	public function setValues(
		$values,
		$erase = FALSE
	) : parent
	{
		$translates = iterator_to_array($this['translates']->getComponents());
		array_walk($translates, function (
			Ytnuk\Translation\Translate\Form\Container $container,
			string $locale
		) use
		(
			& $values
		) {
			if ( ! $container->values->value) {
				$this['translates']->removeComponent($container);
				$container->removeEntity();
				unset($values['translates'][$locale]);
			}
		});
		$container = parent::setValues($values, $erase);
		$parent = $this->lookup(Ytnuk\Orm\Form\Container::class, FALSE);
		if ( ! (array) $values['translates']) {
			$this->removeEntity();
			if ($parent instanceof Ytnuk\Orm\Form\Container && $parent->getMetadata()->getProperty($this->getName())->isNullable) {
				$parent->removeEntity();
			}
		} elseif ($parent instanceof Ytnuk\Orm\Form\Container) {
			$parent->getEntity()->setValue($this->getName(), $this->getEntity());
		}

		return $container;
	}

	protected function createComponentTranslates(Nextras\Orm\Entity\Reflection\PropertyMetadata $metadata) : Nette\Forms\Container
	{
		$translates = $this->addContainer($metadata->name);
		$localeRepository = $this->model->getRepositoryForEntity(Ytnuk\Translation\Locale\Entity::class);
		self::$locales ? : self::$locales = $localeRepository->findAll()->fetchPairs(current($localeRepository->getEntityMetadata()->getPrimaryKey()));
		$collection = array_combine(array_map(function (Ytnuk\Translation\Translate\Entity $entity) {
			return $entity->getRawValue('locale');
		}, $collection = iterator_to_array($this->entity->getValue($metadata->name))), $collection);
		array_walk(self::$locales, function (Ytnuk\Translation\Locale\Entity $locale) use
		(
			$translates,
			$collection
		) {
			$translate = $collection[$locale->id] ?? new Ytnuk\Translation\Translate\Entity;
			$translates->addComponent($component = $this->form->createComponent($translate), $locale->id);
			if ($component instanceof Nette\Forms\Container) {
				$component->setCurrentGroup($translates->getCurrentGroup());
				$value = $component['value'];
				if ($value instanceof Nette\Forms\Controls\BaseControl) {
					$value->setRequired(FALSE);
				}
				unset($component['locale']);
				$component->addHidden('locale', $locale->id)->setOption('entity', $locale);
			}
		});
		$parent = $this->lookup(Ytnuk\Orm\Form\Container::class, FALSE);
		if ($parent instanceof Ytnuk\Orm\Form\Container) {
			$translates->getCurrentGroup()->setOption('label', $parent->formatPropertyLabel($parent->getMetadata()->getProperty($this->getName())));
			if ( ! $parent->getMetadata()->getProperty($this->name)->isNullable && $containers = iterator_to_array($translates->getComponents(FALSE, Nette\Forms\Container::class))) {
				foreach ($containers as $key => $container) {
					$value = $container['value'] ?? NULL;
					if ($value instanceof Nette\Forms\Controls\BaseControl) {
						foreach (array_diff_key($containers, array_flip([$key])) as $sibling) {
							$value = $value->addConditionOn($sibling['value'], ~Nette\Forms\Form::FILLED);
						}
						$value->setRequired();
					}
				}
			}
		}

		return $translates;
	}

	public function render(
		Nette\Forms\Form $form,
		string $file = NULL
	) {
		return parent::render($form, $file ? : implode(DIRECTORY_SEPARATOR, [
			__DIR__,
			basename(__FILE__, '.php'),
			'view.latte',
		]));
	}
}
