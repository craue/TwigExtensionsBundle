<?php

namespace Craue\TwigExtensionsBundle\Tests\Twig\Extension;

use Craue\TwigExtensionsBundle\Tests\IntegrationTestBundle\Form\CommentFormType;
use Craue\TwigExtensionsBundle\Tests\TwigBasedTestCase;
use Craue\TwigExtensionsBundle\Twig\Extension\FormExtension;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormFactoryInterface;

/**
 * @group integration
 *
 * @author Christian Raue <christian.raue@gmail.com>
 * @copyright 2011-2019 Christian Raue
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
		$form = $this->formFactory->createBuilder(FormType::class)
			->add('note', TextType::class)
			->getForm()
		;

		$clonedFormView = $this->ext->cloneForm($form);

		$this->assertEquals($form->createView(), $clonedFormView);
	}

	public function testCloneForm_formType() {
		$formType = new CommentFormType();

		$clonedFormView = $this->ext->cloneForm($formType);

		$this->assertEquals($this->formFactory->create(get_class($formType))->createView(), $clonedFormView);
	}

	/**
	 * @expectedException \InvalidArgumentException
	 * @expectedExceptionMessage Expected argument of either type "Symfony\Component\Form\FormTypeInterface" or "Symfony\Component\Form\FormInterface", but "Symfony\Component\Form\FormView" given.
	 */
	public function testCloneForm_formView() {
		$formView = $this->formFactory->createBuilder(FormType::class)
			->getForm()
			->createView()
		;

		$this->ext->cloneForm($formView);
	}

}
