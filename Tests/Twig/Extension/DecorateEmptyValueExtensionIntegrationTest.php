<?php

namespace Craue\TwigExtensionsBundle\Tests\Twig\Extension;

use Craue\TwigExtensionsBundle\Tests\TwigBasedTestCase;

/**
 * @group integration
 *
 * @author Christian Raue <christian.raue@gmail.com>
 * @copyright 2011-2019 Christian Raue
 * @license http://opensource.org/licenses/mit-license.php MIT License
 */
class DecorateEmptyValueExtensionIntegrationTest extends TwigBasedTestCase {

	/**
	 * @dataProvider dataDecorateEmptyValue
	 */
	public function testDecorateEmptyValue($value, $placeholder, $result) {
		$this->assertSame($result,
				$this->getTwig()->render('@IntegrationTest/DecorateEmptyValue/default.html.twig', [
					'value' => $value,
					'placeholder' => $placeholder,
				]));
	}

	public function dataDecorateEmptyValue() {
		return [
			[null, null, '&mdash;'],
			[null, '&ndash;', '&ndash;'],
			[null, '-', '-'],
			[null, 0, '0'],
			[false, '-', '-'],
			[0, '-', '0'],
			['a value', null, 'a value'],
		];
	}

}
