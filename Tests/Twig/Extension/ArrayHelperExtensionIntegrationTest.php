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
class ArrayHelperExtensionIntegrationTest extends TwigBasedTestCase {

	protected function setUp() {
		parent::setUp();

		// to avoid complaining about inactive "request" scope
		self::$kernel->getContainer()->get('translator')->setLocale('de');
	}

	/**
	 * @dataProvider dataTranslateArray
	 */
	public function testTranslateArray($entries, array $parameters, $domain, $locale, $result) {
		$this->assertSame($result,
				$this->getTwig()->render('@IntegrationTest/ArrayHelper/translateArray.html.twig', array(
					'entries' => $entries,
					'parameters' => $parameters,
					'domain' => $domain,
					'locale' => $locale,
				)));
	}

	public function dataTranslateArray() {
		return array(
			array(
				array(),
				array(),
				null,
				null,
				'',
			),
			array(
				array('red', 'green', 'yellow'),
				array(),
				'messages',
				'de',
				'rot, grün, gelb',
			),
			array(
				array('thing.red', 'thing.green', 'thing.yellow'),
				array('%thing%' => 'Haus'),
				'messages',
				'de',
				'ein rotes Haus, ein grünes Haus, ein gelbes Haus',
			),
			// \Traversable support
			array(
				new \ArrayObject(array('red', 'green', 'yellow')),
				array(),
				'messages',
				null,
				'rot, grün, gelb',
			),
		);
	}

	/**
	 * @dataProvider dataWithout
	 */
	public function testWithout($entries, $without, $result) {
		$this->assertSame($result,
				$this->getTwig()->render('@IntegrationTest/ArrayHelper/without.html.twig', array(
					'entries' => $entries,
					'without' => $without,
				)));
	}

	public function dataWithout() {
		return array(
			array(
				array('red', 'green', 'yellow', 'blue'),
				'yellow',
				'red, green, blue',
			),
			array(
				array('red', 'green', 'yellow' => 'bumblebee', 'blue'),
				'bumblebee',
				'red, green, blue',
			),
			array(
				array('red', 'green', 'yellow' => 'bumblebee', 'blue'),
				'yellow',
				'red, green, bumblebee, blue',
			),
			array(
				array('red', 'green', 'yellow', 'blue'),
				array('yellow', 'black', 'red'),
				'green, blue',
			),
			// \Traversable support
			array(
				new \ArrayObject(array('red', 'green', 'yellow', 'blue')),
				'yellow',
				'red, green, blue',
			),
		);
	}

	/**
	 * @dataProvider dataReplaceKey
	 */
	public function testReplaceKey($entries, $key, $value, $result) {
		$this->assertSame($result,
				$this->getTwig()->render('@IntegrationTest/ArrayHelper/replaceKey.html.twig', array(
					'entries' => $entries,
					'key' => $key,
					'value' => $value,
				)));
	}

	public function dataReplaceKey() {
		return array(
			array(
				array('key1' => 'value1', 'key2' => 'value2'),
				'key3',
				'value3',
				'value1, value2, value3',
			),
			array(
				array('key1' => 'value1', 'key2' => 'value2'),
				'key1',
				'value3',
				'value3, value2',
			),
			// \Traversable support
			array(
				new \ArrayObject(array('key1' => 'value1', 'key2' => 'value2')),
				'key1',
				'value3',
				'value3, value2',
			),
		);
	}

	/**
	 * @dataProvider dataRemoveKey
	 */
	public function testRemoveKey($entries, $key, $result) {
		$this->assertSame($result,
				$this->getTwig()->render('@IntegrationTest/ArrayHelper/removeKey.html.twig', array(
					'entries' => $entries,
					'key' => $key,
				)));
	}

	public function dataRemoveKey() {
		return array(
			// string key
			array(
				array('key1' => 'value1', 'key2' => 'value2'),
				'key1',
				'value2',
			),
			// integer key
			array(
				array('value1', 'value2'),
				0,
				'value2',
			),
			// nonexistent key
			array(
				array('value1', 'value2'),
				2,
				'value1, value2',
			),
			// \Traversable support
			array(
				new \ArrayObject(array('key1' => 'value1', 'key2' => 'value2')),
				'key1',
				'value2',
			),
		);
	}

}
