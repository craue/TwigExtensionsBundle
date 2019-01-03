<?php

namespace Craue\TwigExtensionsBundle\Tests\Twig\Extension;

use Craue\TwigExtensionsBundle\Twig\Extension\StringHelperExtension;
use PHPUnit\Framework\TestCase;

/**
 * @group unit
 *
 * @author Christian Raue <christian.raue@gmail.com>
 * @copyright 2011-2019 Christian Raue
 * @license http://opensource.org/licenses/mit-license.php MIT License
 */
class StringHelperExtensionTest extends TestCase {

	/**
	 * @var ArrayHelperExtension
	 */
	protected $ext;

	protected function setUp() {
		$this->ext = new StringHelperExtension();
	}

	/**
	 * @dataProvider dataAddTrailingDot_invalidArguments
	 * @expectedException \InvalidArgumentException
	 */
	public function testAddTrailingDot_invalidArguments($value) {
		$this->ext->addTrailingDot($value);
	}

	public function dataAddTrailingDot_invalidArguments() {
		return array(
			array(null),
			array(0),
			array(array()),
		);
	}

}
