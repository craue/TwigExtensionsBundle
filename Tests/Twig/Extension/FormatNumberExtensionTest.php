<?php

namespace Craue\TwigExtensionsBundle\Tests\Twig\Extension;

use Craue\TwigExtensionsBundle\Twig\Extension\FormatNumberExtension;

/**
 * @group unit
 *
 * @author Christian Raue <christian.raue@gmail.com>
 * @copyright 2011-2014 Christian Raue
 * @license http://www.opensource.org/licenses/mit-license.php MIT License
 */
class FormatNumberExtensionTest extends \PHPUnit_Framework_TestCase {

	/**
	 * @var FormatNumberExtension
	 */
	protected $ext;

	protected function setUp() {
		$this->ext = new FormatNumberExtension();
	}

	/**
	 * @expectedException \InvalidArgumentException
	 */
	public function testFormatCurrency_noCurrencySet() {
		$this->ext->formatCurrency(0, null, null);
	}

}
