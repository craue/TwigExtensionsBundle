<?php

namespace Craue\TwigExtensionsBundle\Tests\Twig\Extension;

use Craue\TwigExtensionsBundle\Twig\Extension\ArrayHelperExtension;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Translation\TranslatorInterface as LegacyTranslatorInterface;
use Symfony\Contracts\Translation\TranslatorInterface;

/**
 * @group unit
 *
 * @author Christian Raue <christian.raue@gmail.com>
 * @copyright 2011-2019 Christian Raue
 * @license http://opensource.org/licenses/mit-license.php MIT License
 */
class ArrayHelperExtensionTest extends TestCase {

	/**
	 * @var ArrayHelperExtension
	 */
	protected $ext;

	protected function setUp() {
		$this->ext = new ArrayHelperExtension();
	}

	/**
	 * @expectedException \LogicException
	 * @expectedExceptionMessage The Symfony Translation component is not available. Try running "composer require symfony/translation".
	 */
	public function testTranslateArray_noTranslator() {
		$this->ext->translateArray([]);
	}

	public function testTranslateArray_passedArgument() {
		$case = [
			'entries' => ['red', 'green', 'yellow'],
			'parameters' => ['%thing%' => 'Haus'],
			'domain' => 'messages',
			'locale' => 'de',
		];

		$this->ext->setTranslator($this->getMockedTranslator($case));
		$this->ext->translateArray($case['entries'], $case['parameters'], $case['domain'], $case['locale']);
	}

	public function testTranslateArray_defaultArguments() {
		$case = [
			'entries' => ['red', 'green', 'yellow'],
			'parameters' => [],
			'domain' => 'messages',
			'locale' => null,
		];

		$this->ext->setTranslator($this->getMockedTranslator($case));
		$this->ext->translateArray($case['entries']);
	}

	/**
	 * @dataProvider dataTranslateArray_invalidArguments
	 * @expectedException \InvalidArgumentException
	 */
	public function testTranslateArray_invalidArguments($entries, array $parameters, $domain, $locale) {
		$this->ext->setTranslator($this->getMockedTranslator());
		$this->ext->translateArray($entries, $parameters, $domain, $locale);
	}

	public function dataTranslateArray_invalidArguments() {
		return [
			[null, [], null, null, ''],
			[new \stdClass(), [], null, null, ''],
		];
	}

	public function testWithout_withoutArray() {
		$case = [
			'entries' => ['red', 'green', 'yellow', 'blue'],
			'without' => ['yellow', 'black', 'red'],
		];

		$this->assertSame(array_diff($case['entries'], $case['without']),
				$this->ext->without($case['entries'], $case['without']));
	}

	public function testWithout_withoutScalar() {
		$case = [
			'entries' => ['red', 'green', 'yellow', 'blue'],
			'without' => 'yellow',
		];

		$this->assertSame(array_diff($case['entries'], [$case['without']]),
				$this->ext->without($case['entries'], $case['without']));
	}

	public function testWithout_keepIndexes() {
		$case = [
			'entries' => ['red', 'green', 'yellow', 'blue'],
			'without' => 'yellow',
			'wrongResult' => ['red', 'green', 'blue'],
		];

		$this->assertNotSame($case['wrongResult'], $this->ext->without($case['entries'], $case['without']));
	}

	/**
	 * @dataProvider dataWithout_invalidArguments
	 * @expectedException \InvalidArgumentException
	 */
	public function testWithout_invalidArguments($entries, $without) {
		$this->ext->without($entries, $without);
	}

	public function dataWithout_invalidArguments() {
		return [
			[null, null],
			['', null],
			[null, ''],
			['', ''],
			[null, []],
			['', []],
		];
	}

	protected function getMockedTranslator(array $case = []) {
		// TODO remove LegacyTranslatorInterface as soon as Symfony >= 4.2 is required
		$translator = $this->createMock(interface_exists(LegacyTranslatorInterface::class) ? LegacyTranslatorInterface::class : TranslatorInterface::class);

		if (!empty($case)) {
			$translator
				->expects($this->exactly(count($case['entries'])))
				->method('trans')
				->with($this->anything(), $case['parameters'], $case['domain'], $case['locale'])
			;
		}

		return $translator;
	}

}
