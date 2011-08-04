<?php

namespace Craue\TwigExtensionsBundle\Twig\Extension;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormView;

/**
 * Twig extension for form handling.
 *
 * @author Christian Raue <christian.raue@gmail.com>
 * @copyright 2011 Christian Raue
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
	public function setAlias($cloneFormAlias = null) {
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
	 * @param array $formOptions Options to pass to the form type (only valid if $value is a AbstractType, ignored otherwise).
	 * @return FormView
	 * @throws \RuntimeException
	 */
	public function cloneForm($value, array $formOptions = array()) {
		if ($value instanceof FormView) {
			// doesn't work: return clone $value;
			return unserialize(serialize($value));
		} elseif ($value instanceof FormInterface) {
			return $value->createView();
		} elseif ($value instanceof AbstractType) {
			if ($this->formFactory === null) {
				throw new \RuntimeException('No form factory available.');
			}
			return $this->formFactory->create($value, null, $formOptions)->createView();
		}

		throw new \RuntimeException(sprintf('Expected argument of either type "%s", "%s", or "%s", but "%s" given.',
				'Symfony\Component\Form\AbstractType',
				'Symfony\Component\Form\FormInterface',
				'Symfony\Component\Form\FormView',
				is_object($value) ? get_class($value) : gettype($value)
		));
	}

}
