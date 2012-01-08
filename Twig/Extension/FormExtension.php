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
 * @copyright 2011-2012 Christian Raue
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

	/**
	 * @var string
	 */
	protected $hasFormDeepErrorsAlias = null;

	public function setFormFactory(FormFactoryInterface $formFactory) {
		$this->formFactory = $formFactory;
	}

	/**
	 * @param string $cloneFormAlias Alias for the cloneForm function.
	 * @param string $hasFormDeepErrorsAlias Alias for the hasFormDeepErrors function.
	 */
	public function setAliases($cloneFormAlias = null, $hasFormDeepErrorsAlias = null) {
		if (!empty($cloneFormAlias)) {
			$this->cloneFormAlias = $cloneFormAlias;
		}
		if (!empty($hasFormDeepErrorsAlias)) {
			$this->hasFormDeepErrorsAlias = $hasFormDeepErrorsAlias;
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

		$hasFormDeepErrorsMethod = new \Twig_Function_Method($this, 'hasFormDeepErrors');
		$functions['craue_hasFormDeepErrors'] = $hasFormDeepErrorsMethod;
		if (!empty($this->hasFormDeepErrorsAlias)) {
			$functions[$this->hasFormDeepErrorsAlias] = $hasFormDeepErrorsMethod;
		}

		return $functions;
	}

	/**
	 * @param mixed $value
	 * @param array $formOptions Options to pass to the form type (only valid if $value is a FormTypeInterface, ignored otherwise).
	 * @return FormView
	 * @throws \RuntimeException
	 */
	public function cloneForm($value, array $formOptions = array()) {
		if ($value instanceof FormView) {
			// doesn't work: return clone $value;
			return unserialize(serialize($value));
		} elseif ($value instanceof FormInterface) {
			return $value->createView();
		} elseif ($value instanceof FormTypeInterface) {
			if ($this->formFactory === null) {
				throw new \RuntimeException('No form factory available.');
			}
			return $this->formFactory->create($value, null, $formOptions)->createView();
		}

		throw new \RuntimeException(sprintf('Expected argument of either type "%s", "%s", or "%s", but "%s" given.',
				'Symfony\Component\Form\FormTypeInterface',
				'Symfony\Component\Form\FormInterface',
				'Symfony\Component\Form\FormView',
				is_object($value) ? get_class($value) : gettype($value)
		));
	}

	/**
	 * @param FormView $form A form.
	 * @return bool If the form (taking into account all of its children) has errors.
	 */
	public function hasFormDeepErrors(FormView $form) {
		if (count($form->get('errors')) > 0) {
			return true;
		}

		foreach ($form->getChildren() as $child) {
			if ($this->hasFormDeepErrors($child)) {
				return true;
			}
		}

		return false;
	}

}
