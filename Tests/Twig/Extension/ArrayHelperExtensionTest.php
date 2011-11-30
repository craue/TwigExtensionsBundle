<?php

namespace Craue\TwigExtensionsBundle\Tests\Twig\Extension;

use Craue\TwigExtensionsBundle\Twig\Extension\ArrayHelperExtension;

/**
 * @group unit
 *
 * @author Christian Raue <christian.raue@gmail.com>
 * @copyright 2011 Christian Raue
 * @license http://www.opensource.org/licenses/mit-license.php MIT License
 */
class ArrayHelperExtensionTest extends \PHPUnit_Framework_TestCase {

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

	protected function getMockedTranslator(array $case) {
		$translator = $this->getMock('Symfony\Component\Translation\TranslatorInterface');
		$translator
			->expects($this->exactly(count($case['entries'])))
			->method('trans')
			->with($this->anything(), $case['parameters'], $case['domain'], $case['locale'])
		;

		return $translator;
	}

}
