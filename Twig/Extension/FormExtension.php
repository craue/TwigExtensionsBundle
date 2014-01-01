<?php

namespace Craue\TwigExtensionsBundle\Twig\Extension;

use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormTypeInterface;
use Symfony\Component\Form\FormView;

/**
 * Twig extension for form handling.
 *
 * @author Christian Raue <christian.raue@gmail.com>
 * @copyright 2011-2014 Christian Raue
 * @license http://www.opensource.org/licenses/mit-license.php MIT License
 */
class FormExtension extends \Twig_Extension {

	/**
	 * @var FormFactoryInterface
	 */
	protected $formFactory;

	/**
	 * @var string
	 */
	protected $cloneFormAlias = null;

	public function setFormFactory(FormFactoryInterface $formFactory) {
		$this->formFactory = $formFactory;
	}

	/**
	 * @param string $cloneFormAlias Alias for the cloneForm function.
	 */
	public function setAliases($cloneFormAlias = null) {
		if (!empty($cloneFormAlias)) {
			$this->cloneFormAlias = $cloneFormAlias;
		}
	}

	/**
	 * {@inheritDoc}
	 */
	public function getName() {
		return 'craue_form';
	}

	/**
	 * {@inheritDoc}
	 */
	public function getFunctions() {
		$functions = array();

		$getCloneFormMethod = new \Twig_Function_Method($this, 'cloneForm');
		$functions['craue_cloneForm'] = $getCloneFormMethod;
		if (!empty($this->cloneFormAlias)) {
			$functions[$this->cloneFormAlias] = $getCloneFormMethod;
		}

		return $functions;
	}

	/**
	 * @param mixed $value
	 * @param array $formOptions Options to pass to the form type (only valid if $value is a FormTypeInterface, ignored otherwise).
	 * @return FormView
	 * @throws \InvalidArgumentException
	 */
	public function cloneForm($value, array $formOptions = array()) {
		if ($value instanceof FormView) { // don't use FormViewInterface for Symfony 2.0 compatibility
			// doesn't work: return clone $value;
			return unserialize(serialize($value));
		}

		if ($value instanceof FormInterface) {
			return $value->createView();
		}

		if ($value instanceof FormTypeInterface) {
			if ($this->formFactory === null) {
				throw new \RuntimeException('No form factory available.');
			}
			return $this->formFactory->create($value, null, $formOptions)->createView();
		}

		throw new \InvalidArgumentException(sprintf('Expected argument of either type "%s", "%s", or "%s", but "%s" given.',
				'Symfony\Component\Form\FormTypeInterface',
				'Symfony\Component\Form\FormInterface',
				'Symfony\Component\Form\FormView',
				is_object($value) ? get_class($value) : gettype($value)
		));
	}

}
