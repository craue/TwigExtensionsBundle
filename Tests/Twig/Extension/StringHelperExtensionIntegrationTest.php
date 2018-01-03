<?php

namespace Craue\TwigExtensionsBundle\Tests\Twig\Extension;

use Craue\TwigExtensionsBundle\Tests\TwigBasedTestCase;

/**
 * @group integration
 *
 * @author Christian Raue <christian.raue@gmail.com>
 * @copyright 2011-2018 Christian Raue
 * @license http://opensource.org/licenses/mit-license.php MIT License
 */
class StringHelperExtensionIntegrationTest extends TwigBasedTestCase {

	/**
	 * @dataProvider dataAddTrailingDot
	 */
	public function testAddTrailingDot($value, $result) {
		$this->assertSame($result,
				$this->getTwig()->render('@IntegrationTest/StringHelper/trailingDot.html.twig', array(
					'value' => $value,
				)));
	}

	public function dataAddTrailingDot() {
		return array(
			array('This text should end with a dot', 'This text should end with a dot.'),
			array('This text should end with a dot.', 'This text should end with a dot.'),
		);
	}

}
