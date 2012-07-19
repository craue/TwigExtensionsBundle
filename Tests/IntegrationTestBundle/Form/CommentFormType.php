<?php

namespace Craue\TwigExtensionsBundle\Tests\IntegrationTestBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

/**
 * Form type compatible with Symfony >= 2.1-dev.
 *
 * @author Christian Raue <christian.raue@gmail.com>
 * @copyright 2011-2012 Christian Raue
 * @license http://www.opensource.org/licenses/mit-license.php MIT License
 */
class CommentFormType extends AbstractType {

	/**
	 * {@inheritDoc}
	 */
	public function buildForm(FormBuilderInterface $builder, array $options) {
		$builder->add('note', 'text');
	}

	/**
	 * {@inheritDoc}
	 */
	public function getName() {
		return 'comment';
	}

}
