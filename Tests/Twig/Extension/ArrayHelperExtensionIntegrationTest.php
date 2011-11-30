<?php

namespace Craue\TwigExtensionsBundle\Tests\Twig\Extension;

use Craue\TwigExtensionsBundle\Tests\TwigBasedTestCase;

/**
 * @group integration
 *
 * @author Christian Raue <christian.raue@gmail.com>
 * @copyright 2011 Christian Raue
 * @license http://www.opensource.org/licenses/mit-license.php MIT License
 */
class ArrayHelperExtensionIntegrationTest extends TwigBasedTestCase {

	protected function setUp() {
		parent::setUp();

		// to avoid complaining about inactive "request" scope
		self::$kernel->getContainer()->get('translator')->setLocale('de');
	}

	public function testTranslateArray() {
		$cases = array(
			array(
				'entries' => array('red', 'green', 'yellow'),
				'parameters' => array(),
				'domain' => null,
				'locale' => null,
				'result' => 'red, green, yellow',
			),
			array(
				'entries' => array('red', 'green', 'yellow'),
				'parameters' => array(),
				'domain' => 'messages',
				'locale' => 'de',
				'result' => 'rot, grün, gelb',
			),
			array(
				'entries' => array('thing.red', 'thing.green', 'thing.yellow'),
				'parameters' => array('%thing%' => 'Haus'),
				'domain' => 'messages',
				'locale' => 'de',
				'result' => 'ein rotes Haus, ein grünes Haus, ein gelbes Haus',
			),
		);

		foreach ($cases as $index => $case) {
			$this->assertSame($case['result'],
					$this->getTwig()->render('IntegrationTestBundle:ArrayHelper:translateArray.html.twig', array(
						'entries' => $case['entries'],
						'parameters' => $case['parameters'],
						'domain' => $case['domain'],
						'locale' => $case['locale'],
					)),
					'test case with index '.$index);
		}
	}

	public function testWithout() {
		$cases = array(
			array(
				'entries' => array('red', 'green', 'yellow', 'blue'),
				'without' => 'yellow',
				'result' => 'red, green, blue',
			),
			array(
				'entries' => array('red', 'green', 'yellow', 'blue'),
				'without' => array('yellow', 'black', 'red'),
				'result' => 'green, blue',
			),
		);

		foreach ($cases as $index => $case) {
			$this->assertSame($case['result'],
					$this->getTwig()->render('IntegrationTestBundle:ArrayHelper:without.html.twig', array(
						'entries' => $case['entries'],
						'without' => $case['without'],
					)),
					'test case with index '.$index);
		}
	}

}
