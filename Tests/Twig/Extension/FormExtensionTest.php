<?php

namespace Craue\TwigExtensionsBundle\Tests\Twig\Extension;

use Craue\TwigExtensionsBundle\Twig\Extension\FormExtension;
use PHPUnit\Framework\TestCase;

/**
 * @group unit
 *
 * @author Christian Raue <christian.raue@gmail.com>
 * @copyright 2011-2018 Christian Raue
 * @license http://opensource.org/licenses/mit-license.php MIT License
 */
class FormExtensionTest extends TestCase {

	/**
	 * @var FormatNumberExtension
	 */
	protected $ext;

	protected function setUp() {
		$this->ext = new FormExtension();
	}

	/**
	 * @expectedException \InvalidArgumentException
	 */
	public function testCloneForm_nullValue() {
		$this->ext->cloneForm(null);
	}

}
