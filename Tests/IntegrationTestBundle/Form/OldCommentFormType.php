<?php

namespace Craue\TwigExtensionsBundle\Tests\IntegrationTestBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;

/**
 * Form type compatible with Symfony 2.0.*.
 *
 * @author Christian Raue <christian.raue@gmail.com>
 * @copyright 2011-2014 Christian Raue
 * @license http://www.opensource.org/licenses/mit-license.php MIT License
 */
class OldCommentFormType extends AbstractType {

	/**
	 * {@inheritDoc}
	 */
	public function buildForm(FormBuilder $builder, array $options) {
		$builder->add('note', 'text');
	}

	/**
	 * {@inheritDoc}
	 */
	public function getName() {
		return 'comment';
	}

}
