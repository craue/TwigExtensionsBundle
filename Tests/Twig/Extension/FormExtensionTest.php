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
 * @copyright 2011-2019 Christian Raue
 * @license http://opensource.org/licenses/mit-license.php MIT License
 */
class FormExtensionTest extends TestCase {

	/**
	 * @var FormExtension
	 */
	protected $ext;

	protected function setUp() {
		$this->ext = new FormExtension();
	}

	/**
	 * @expectedException \LogicException
	 * @expectedExceptionMessage The Symfony Form component is not available. Try running "composer require symfony/form".
	 */
	public function testCloneForm_noFormFactory() {
		$this->ext->cloneForm($this->getMockForAbstractClass(FormInterface::class));
	}

	/**
	 * @expectedException \InvalidArgumentException
	 * @expectedExceptionMessage Expected argument of either type "Symfony\Component\Form\FormTypeInterface" or "Symfony\Component\Form\FormInterface", but "NULL" given.
	 */
	public function testCloneForm_nullValue() {
		$this->ext->setFormFactory($this->getMockForAbstractClass(FormFactoryInterface::class));
		$this->ext->cloneForm(null);
	}

}
