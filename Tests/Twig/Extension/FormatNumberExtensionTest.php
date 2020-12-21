<?php

namespace Craue\TwigExtensionsBundle\Tests\Twig\Extension;

use Craue\TwigExtensionsBundle\Twig\Extension\FormatNumberExtension;
use PHPUnit\Framework\TestCase;

/**
 * @group unit
 *
 * @author Christian Raue <christian.raue@gmail.com>
 * @copyright 2011-2020 Christian Raue
 * @license http://opensource.org/licenses/mit-license.php MIT License
 */
class FormatNumberExtensionTest extends TestCase {

	/**
	 * @var FormatNumberExtension
	 */
	protected $ext;

	protected function setUp() : void {
		$this->ext = new FormatNumberExtension();
	}

	public function testFormatCurrency_noCurrencySet() {
		$this->expectException(\InvalidArgumentException::class);

		$this->ext->formatCurrency(0, null, null);
	}

}
