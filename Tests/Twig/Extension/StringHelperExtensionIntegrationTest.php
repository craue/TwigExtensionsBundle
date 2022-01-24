<?php

namespace Craue\TwigExtensionsBundle\Tests\Twig\Extension;

use Craue\TwigExtensionsBundle\Tests\TwigBasedTestCase;

/**
 * @group integration
 *
 * @author Christian Raue <christian.raue@gmail.com>
 * @copyright 2011-2022 Christian Raue
 * @license http://opensource.org/licenses/mit-license.php MIT License
 */
class StringHelperExtensionIntegrationTest extends TwigBasedTestCase {

	/**
	 * @dataProvider dataAddTrailingDot
	 */
	public function testAddTrailingDot($value, $result) {
		$this->assertSame($result,
				$this->getTwig()->render('@IntegrationTest/StringHelper/trailingDot.html.twig', [
					'value' => $value,
				]));
	}

	public function dataAddTrailingDot() {
		return [
			['This text should end with a dot', 'This text should end with a dot.'],
			['This text should end with a dot.', 'This text should end with a dot.'],
		];
	}

}
