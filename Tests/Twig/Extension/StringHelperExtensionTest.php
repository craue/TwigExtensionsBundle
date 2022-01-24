<?php

namespace Craue\TwigExtensionsBundle\Tests\Twig\Extension;

use Craue\TwigExtensionsBundle\Twig\Extension\StringHelperExtension;
use PHPUnit\Framework\TestCase;

/**
 * @group unit
 *
 * @author Christian Raue <christian.raue@gmail.com>
 * @copyright 2011-2022 Christian Raue
 * @license http://opensource.org/licenses/mit-license.php MIT License
 */
class StringHelperExtensionTest extends TestCase {

	/**
	 * @var StringHelperExtension
	 */
	protected $ext;

	protected function setUp() : void {
		$this->ext = new StringHelperExtension();
	}

	/**
	 * @dataProvider dataAddTrailingDot_invalidArguments
	 */
	public function testAddTrailingDot_invalidArguments($value) {
		$this->expectException(\InvalidArgumentException::class);

		$this->ext->addTrailingDot($value);
	}

	public function dataAddTrailingDot_invalidArguments() {
		return [
			[null],
			[0],
			[[]],
		];
	}

}
