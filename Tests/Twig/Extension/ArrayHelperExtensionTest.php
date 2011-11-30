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

	public function testTranslateArray() {
		$cases = array(
			array(
				'entries' => array('red', 'green', 'yellow'),
				'parameters' => array(),
				'domain' => null,
				'locale' => null,
				'result' => array('red', 'green', 'yellow'),
			),
		);

		foreach ($cases as $index => $case) {
			$translator = $this->getMock('Symfony\Component\Translation\TranslatorInterface');
			$translator
				->expects($this->exactly(count($case['entries'])))
				->method('trans')
				->will($this->returnArgument(0))
			;
			$this->ext->setTranslator($translator);

			$this->assertSame($case['result'],
					$this->ext->translateArray($case['entries'], $case['parameters'], $case['domain'], $case['locale']),
					'test case with index '.$index);
		}
	}

}
