<?php

namespace Craue\TwigExtensionsBundle\Tests\Twig\Extension;

use Craue\TwigExtensionsBundle\Tests\TwigBasedTestCase;

/**
 * @group integration
 *
 * @author Christian Raue <christian.raue@gmail.com>
 * @copyright 2011-2017 Christian Raue
 * @license http://opensource.org/licenses/mit-license.php MIT License
 */
class FormatNumberExtensionIntegrationTest extends TwigBasedTestCase {

	/**
	 * @dataProvider dataFormatNumber
	 */
	public function testFormatNumber($value, $locale, $result) {
		$this->assertSame($result,
				$this->getTwig()->render('IntegrationTestBundle:FormatNumber:number.html.twig', array(
					'value' => $value,
					'locale' => $locale,
				)));
	}

	public function dataFormatNumber() {
		return array(
			array(null, null, ''),
			array(0, null, '0'),
			array(12345.67, 'de', '12.345,67'),
			array(12345.67, 'en_US', '12,345.67'),
			array(12345.678, 'en_US', '12,345.678'),
		);
	}

	/**
	 * @dataProvider dataFormatCurrency
	 */
	public function testFormatCurrency($value, $currency, $locale, $result) {
		$this->assertSame($result,
				$this->getTwig()->render('IntegrationTestBundle:FormatNumber:currency.html.twig', array(
					'value' => $value,
					'currency' => $currency,
					'locale' => $locale,
				)));
	}

	public function dataFormatCurrency() {
		return array(
			array(null, null, null, ''),
			array(0, 'USD', 'en_US', '$0.00'),
			array(12345.67, 'EUR', 'en_US', '€12,345.67'),
			array(12345.678, 'EUR', 'en_US', '€12,345.68'),
		);
	}

	public function testFormatCurrency_nbsp() {
		$cases = array(
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

	/**
	 * @dataProvider dataFormatSpelledOutNumber
	 */
	public function testFormatSpelledOutNumber($value, $locale, $result) {
		$this->assertSame($result,
				$this->getTwig()->render('IntegrationTestBundle:FormatNumber:spellout.html.twig', array(
					'value' => $value,
					'locale' => $locale,
				)));
	}

	public function dataFormatSpelledOutNumber() {
		return array(
			array(null, null, ''),
			array(0, 'de', 'null'),
			array(12345.67, 'de', 'zwölf­tausend­drei­hundert­fünf­und­vierzig Komma sechs sieben'), // contains hyphens
			array(12345.67, 'en_US', 'twelve thousand three hundred forty-five point six seven'),
		);
	}

}
