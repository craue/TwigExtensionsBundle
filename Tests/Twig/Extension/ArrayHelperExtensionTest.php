<?php

namespace Craue\TwigExtensionsBundle\Tests\Twig\Extension;

use Craue\TwigExtensionsBundle\Twig\Extension\ArrayHelperExtension;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Translation\TranslatorInterface;

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

	public function testTranslateArray_passedArgument() {
		$case = array(
			'entries' => array('red', 'green', 'yellow'),
			'parameters' => array('%thing%' => 'Haus'),
			'domain' => 'messages',
			'locale' => 'de',
		);

		$this->ext->setTranslator($this->getMockedTranslator($case));
		$this->ext->translateArray($case['entries'], $case['parameters'], $case['domain'], $case['locale']);
	}

	public function testTranslateArray_defaultArguments() {
		$case = array(
			'entries' => array('red', 'green', 'yellow'),
			'parameters' => array(),
			'domain' => 'messages',
			'locale' => null,
		);

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
		return array(
			array(null, array(), null, null, ''),
			array(new \stdClass(), array(), null, null, ''),
		);
	}

	public function testWithout_withoutArray() {
		$case = array(
			'entries' => array('red', 'green', 'yellow', 'blue'),
			'without' => array('yellow', 'black', 'red'),
		);

		$this->assertSame(array_diff($case['entries'], $case['without']),
				$this->ext->without($case['entries'], $case['without']));
	}

	public function testWithout_withoutScalar() {
		$case = array(
			'entries' => array('red', 'green', 'yellow', 'blue'),
			'without' => 'yellow',
		);

		$this->assertSame(array_diff($case['entries'], array($case['without'])),
				$this->ext->without($case['entries'], $case['without']));
	}

	public function testWithout_keepIndexes() {
		$case = array(
			'entries' => array('red', 'green', 'yellow', 'blue'),
			'without' => 'yellow',
			'wrongResult' => array('red', 'green', 'blue'),
		);

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
		return array(
			array(null, null),
			array('', null),
			array(null, ''),
			array('', ''),
			array(null, array()),
			array('', array()),
		);
	}

	protected function getMockedTranslator(array $case = array()) {
		$translator = $this->createMock(TranslatorInterface::class);

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
