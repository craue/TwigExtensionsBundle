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
class FormatNumberExtensionIntegrationTest extends TwigBasedTestCase {

	public function testFormatNumber() {
		$cases = array(
			array(
				'value' => null,
				'locale' => null,
				'result' => '',
			),
			array(
				'value' => 0,
				'locale' => null,
				'result' => '0',
			),
			array(
				'value' => 12345.67,
				'locale' => 'de',
				'result' => '12.345,67',
			),
			array(
				'value' => 12345.67,
				'locale' => 'en_US',
				'result' => '12,345.67',
			),
			array(
				'value' => 12345.678,
				'locale' => 'en_US',
				'result' => '12,345.678',
			),
		);

		foreach ($cases as $index => $case) {
			$this->assertSame($case['result'],
					$this->getTwig()->render('IntegrationTestBundle:FormatNumber:number.html.twig', array(
						'value' => $case['value'],
						'locale' => $case['locale'],
					)),
					'test case with index '.$index);
		}
	}

	public function testFormatCurrency() {
		$cases = array(
			array(
				'value' => null,
				'currency' => null,
				'locale' => null,
				'result' => '',
			),
			array(
				'value' => 0,
				'currency' => 'USD',
				'locale' => 'en_US',
				'result' => '$0.00',
			),
			array(
				'value' => 12345.67,
				'currency' => 'EUR',
				'locale' => 'de',
				'result' => html_entity_decode('12.345,67&nbsp;€', null, $this->getTwig()->getCharset()),
			),
			array(
				'value' => 12345.67,
				'currency' => 'USD',
				'locale' => 'de',
				'result' => html_entity_decode('12.345,67&nbsp;$', null, $this->getTwig()->getCharset()),
			),
			array(
				'value' => 12345.67,
				'currency' => 'EUR',
				'locale' => 'en_US',
				'result' => '€12,345.67',
			),
			array(
				'value' => 12345.678,
				'currency' => 'EUR',
				'locale' => 'en_US',
				'result' => '€12,345.68',
			),
		);

		foreach ($cases as $index => $case) {
			$this->assertSame($case['result'],
					$this->getTwig()->render('IntegrationTestBundle:FormatNumber:currency.html.twig', array(
						'value' => $case['value'],
						'currency' => $case['currency'],
						'locale' => $case['locale'],
					)),
					'test case with index '.$index);
		}
	}

	public function testFormatSpelledOutNumber() {
		$cases = array(
			array(
				'value' => null,
				'locale' => null,
				'result' => '',
			),
			array(
				'value' => 0,
				'locale' => 'de',
				'result' => 'null',
			),
			array(
				'value' => 12345.67,
				'locale' => 'de',
				'result' => 'zwölf­tausend­drei­hundert­fünf­und­vierzig Komma sechs sieben', // contains hyphens
			),
			array(
				'value' => 12345.67,
				'locale' => 'en_US',
				'result' => 'twelve thousand three hundred forty-five point six seven',
			),
		);

		foreach ($cases as $index => $case) {
			$this->assertSame($case['result'],
					$this->getTwig()->render('IntegrationTestBundle:FormatNumber:spellout.html.twig', array(
						'value' => $case['value'],
						'locale' => $case['locale'],
					)),
					'test case with index '.$index);
		}
	}

}
