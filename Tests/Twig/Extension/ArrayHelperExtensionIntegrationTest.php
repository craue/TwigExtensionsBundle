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
class ArrayHelperExtensionIntegrationTest extends TwigBasedTestCase {

	protected function setUp() : void {
		parent::setUp();

		// to avoid complaining about inactive "request" scope
		self::$kernel->getContainer()->get('translator')->setLocale('de');
	}

	/**
	 * @dataProvider dataTranslateArray
	 */
	public function testTranslateArray($entries, array $parameters, $domain, $locale, $result) {
		$this->assertSame($result,
				$this->getTwig()->render('@IntegrationTest/ArrayHelper/translateArray.html.twig', [
					'entries' => $entries,
					'parameters' => $parameters,
					'domain' => $domain,
					'locale' => $locale,
				]));
	}

	public function dataTranslateArray() {
		return [
			[
				[],
				[],
				null,
				null,
				'',
			],
			[
				['red', 'green', 'yellow'],
				[],
				'messages',
				'de',
				'rot, grün, gelb',
			],
			[
				['thing.red', 'thing.green', 'thing.yellow'],
				['%thing%' => 'Haus'],
				'messages',
				'de',
				'ein rotes Haus, ein grünes Haus, ein gelbes Haus',
			],
			// \Traversable support
			[
				new \ArrayObject(['red', 'green', 'yellow']),
				[],
				'messages',
				null,
				'rot, grün, gelb',
			],
		];
	}

	/**
	 * @dataProvider dataWithout
	 */
	public function testWithout($entries, $without, $result) {
		$this->assertSame($result,
				$this->getTwig()->render('@IntegrationTest/ArrayHelper/without.html.twig', [
					'entries' => $entries,
					'without' => $without,
				]));
	}

	public function dataWithout() {
		return [
			[
				['red', 'green', 'yellow', 'blue'],
				'yellow',
				'red, green, blue',
			],
			[
				['red', 'green', 'yellow' => 'bumblebee', 'blue'],
				'bumblebee',
				'red, green, blue',
			],
			[
				['red', 'green', 'yellow' => 'bumblebee', 'blue'],
				'yellow',
				'red, green, bumblebee, blue',
			],
			[
				['red', 'green', 'yellow', 'blue'],
				['yellow', 'black', 'red'],
				'green, blue',
			],
			// \Traversable support
			[
				new \ArrayObject(['red', 'green', 'yellow', 'blue']),
				'yellow',
				'red, green, blue',
			],
		];
	}

	/**
	 * @dataProvider dataReplaceKey
	 */
	public function testReplaceKey($entries, $key, $value, $result) {
		$this->assertSame($result,
				$this->getTwig()->render('@IntegrationTest/ArrayHelper/replaceKey.html.twig', [
					'entries' => $entries,
					'key' => $key,
					'value' => $value,
				]));
	}

	public function dataReplaceKey() {
		return [
			[
				['key1' => 'value1', 'key2' => 'value2'],
				'key3',
				'value3',
				'value1, value2, value3',
			],
			[
				['key1' => 'value1', 'key2' => 'value2'],
				'key1',
				'value3',
				'value3, value2',
			],
			// \Traversable support
			[
				new \ArrayObject(['key1' => 'value1', 'key2' => 'value2']),
				'key1',
				'value3',
				'value3, value2',
			],
		];
	}

	/**
	 * @dataProvider dataRemoveKey
	 */
	public function testRemoveKey($entries, $key, $result) {
		$this->assertSame($result,
				$this->getTwig()->render('@IntegrationTest/ArrayHelper/removeKey.html.twig', [
					'entries' => $entries,
					'key' => $key,
				]));
	}

	public function dataRemoveKey() {
		return [
			// string key
			[
				['key1' => 'value1', 'key2' => 'value2'],
				'key1',
				'value2',
			],
			// integer key
			[
				['value1', 'value2'],
				0,
				'value2',
			],
			// nonexistent key
			[
				['value1', 'value2'],
				2,
				'value1, value2',
			],
			// \Traversable support
			[
				new \ArrayObject(['key1' => 'value1', 'key2' => 'value2']),
				'key1',
				'value2',
			],
		];
	}

}
