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
