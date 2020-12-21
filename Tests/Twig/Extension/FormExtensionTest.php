<?php

namespace Craue\TwigExtensionsBundle\Tests\Twig\Extension;

use Craue\TwigExtensionsBundle\Twig\Extension\FormExtension;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\Form\FormInterface;

/**
 * @group unit
 *
 * @author Christian Raue <christian.raue@gmail.com>
 * @copyright 2011-2020 Christian Raue
 * @license http://opensource.org/licenses/mit-license.php MIT License
 */
class FormExtensionTest extends TestCase {

	/**
	 * @var FormExtension
	 */
	protected $ext;

	protected function setUp() : void {
		$this->ext = new FormExtension();
	}

	public function testCloneForm_noFormFactory() {
		$this->expectException(\LogicException::class);
		$this->expectExceptionMessage('The Symfony Form component is not available. Try running "composer require symfony/form".');

		$this->ext->cloneForm($this->getMockForAbstractClass(FormInterface::class));
	}

	public function testCloneForm_nullValue() {
		$this->ext->setFormFactory($this->getMockForAbstractClass(FormFactoryInterface::class));

		$this->expectException(\InvalidArgumentException::class);
		$this->expectExceptionMessage('Expected argument of either type "Symfony\Component\Form\FormTypeInterface" or "Symfony\Component\Form\FormInterface", but "NULL" given.');

		$this->ext->cloneForm(null);
	}

}
