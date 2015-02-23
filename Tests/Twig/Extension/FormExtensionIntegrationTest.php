<?php

namespace Craue\TwigExtensionsBundle\Tests\Twig\Extension;

use Craue\TwigExtensionsBundle\Tests\IntegrationTestBundle\Form\CommentFormType;
use Craue\TwigExtensionsBundle\Tests\IntegrationTestBundle\Form\OldCommentFormType;
use Craue\TwigExtensionsBundle\Tests\TwigBasedTestCase;
use Craue\TwigExtensionsBundle\Twig\Extension\FormExtension;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpKernel\Kernel;

/**
 * @group integration
 *
 * @author Christian Raue <christian.raue@gmail.com>
 * @copyright 2011-2015 Christian Raue
 * @license http://opensource.org/licenses/mit-license.php MIT License
 */
class FormExtensionIntegrationTest extends TwigBasedTestCase {

	/**
	 * @var FormExtension
	 */
	protected $ext;

	/**
	 * @var FormFactoryInterface
	 */
	protected $formFactory;

	protected function setUp() {
		parent::setUp();
		$container = self::$kernel->getContainer();
		$this->ext = $container->get('twig.extension.craue_form');
		$this->formFactory = $container->get('form.factory');
	}

	public function testCloneForm_form() {
		$form = $this->formFactory->createBuilder('form')
			->add('note', 'text')
			->getForm()
		;

		$clonedFormView = $this->ext->cloneForm($form);

		$this->assertEquals($form->createView(), $clonedFormView);
	}

	public function testCloneForm_formType() {
		if (version_compare(Kernel::VERSION, '2.1.0-DEV', '<')) {
			$formType = new OldCommentFormType();
		} else {
			$formType = new CommentFormType();
		}

		$clonedFormView = $this->ext->cloneForm($formType);

		$this->assertEquals($this->formFactory->create($formType)->createView(), $clonedFormView);
	}

	/**
	 * @expectedException \InvalidArgumentException
	 * @expectedExceptionMessage Expected argument of either type "Symfony\Component\Form\FormTypeInterface" or "Symfony\Component\Form\FormInterface", but "Symfony\Component\Form\FormView" given.
	 */
	public function testCloneForm_formView() {
		$formView = $this->formFactory->createBuilder('form')
			->getForm()
			->createView()
		;

		$this->ext->cloneForm($formView);
	}

}
