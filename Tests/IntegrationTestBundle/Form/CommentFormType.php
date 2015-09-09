<?php

namespace Craue\TwigExtensionsBundle\Tests\IntegrationTestBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

/**
 * @author Christian Raue <christian.raue@gmail.com>
 * @copyright 2011-2015 Christian Raue
 * @license http://opensource.org/licenses/mit-license.php MIT License
 */
class CommentFormType extends AbstractType {

	/**
	 * {@inheritDoc}
	 */
	public function buildForm(FormBuilderInterface $builder, array $options) {
		$useFqcn = method_exists('Symfony\Component\Form\AbstractType', 'getBlockPrefix');

		$builder->add('note', $useFqcn ? 'Symfony\Component\Form\Extension\Core\Type\TextType' : 'text');
	}

	/**
	 * {@inheritDoc}
	 */
	public function getName() {
		return $this->getBlockPrefix();
	}
	/**
	 * {@inheritDoc}
	 */
	public function getBlockPrefix() {
		return 'comment';
	}

}
