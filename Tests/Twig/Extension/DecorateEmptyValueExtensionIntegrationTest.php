<?php

namespace Craue\TwigExtensionsBundle\Tests\Twig\Extension;

use Craue\TwigExtensionsBundle\Tests\TwigBasedTestCase;

/**
 * @group integration
 *
 * @author Christian Raue <christian.raue@gmail.com>
 * @copyright 2011-2012 Christian Raue
 * @license http://www.opensource.org/licenses/mit-license.php MIT License
 */
class DecorateEmptyValueExtensionIntegrationTest extends TwigBasedTestCase {

	public function testDecorateEmptyValue() {
		$cases = array(
			array(
				'value' => null,
				'placeholder' => null,
				'result' => '&mdash;',
			),
			array(
				'value' => null,
				'placeholder' => '&ndash;',
				'result' => '&ndash;',
			),
			array(
				'value' => null,
				'placeholder' => '-',
				'result' => '-',
			),
			array(
				'value' => null,
				'placeholder' => 0,
				'result' => '0',
			),
			array(
				'value' => false,
				'placeholder' => '-',
				'result' => '-',
			),
			array(
				'value' => 0,
				'placeholder' => '-',
				'result' => '0',
			),
			array(
				'value' => 'a value',
				'placeholder' => null,
				'result' => 'a value',
			),
		);

		foreach ($cases as $index => $case) {
			$this->assertSame($case['result'],
					$this->getTwig()->render('IntegrationTestBundle:DecorateEmptyValue:default.html.twig', array(
						'value' => $case['value'],
						'placeholder' => $case['placeholder'],
					)),
					'test case with index '.$index);
		}
	}

}
