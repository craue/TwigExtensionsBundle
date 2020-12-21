<?php

namespace Craue\TwigExtensionsBundle\Tests\Twig\Extension;

use Craue\TwigExtensionsBundle\Twig\Extension\FormatDateTimeExtension;
use PHPUnit\Framework\TestCase;

/**
 * @group unit
 *
 * @author Christian Raue <christian.raue@gmail.com>
 * @copyright 2011-2020 Christian Raue
 * @license http://opensource.org/licenses/mit-license.php MIT License
 */
class FormatDateTimeExtensionTest extends TestCase {

	/**
	 * @var FormatDateTimeExtension
	 */
	protected $ext;

	protected function setUp() : void {
		$this->ext = new FormatDateTimeExtension();
	}

	public function testFormatDate_dateTypeNone() {
		$this->expectException(\InvalidArgumentException::class);

		$this->ext->formatDate(0, null, 'none');
	}

	public function testFormatDate_dateTypeInvalid() {
		$this->expectException(\InvalidArgumentException::class);

		$this->ext->formatDate(0, null, 'blah');
	}

	public function testFormatDate_valueInvalid() {
		$this->expectException(\InvalidArgumentException::class);

		$this->ext->formatDate('blah');
	}

	public function testFormatTime_timeTypeNone() {
		$this->expectException(\InvalidArgumentException::class);

		$this->ext->formatTime(0, null, 'none');
	}

	public function testFormatTime_timeTypeInvalid() {
		$this->expectException(\InvalidArgumentException::class);

		$this->ext->formatTime(0, null, 'blah');
	}

	public function testFormatDateTime_dateTypeAndTimeTypeNone() {
		$this->expectException(\InvalidArgumentException::class);

		$this->ext->formatDateTime(0, null, 'none', 'none');
	}

	public function testFormatDateTime_dateTypeInvalid() {
		$this->expectException(\InvalidArgumentException::class);

		$this->ext->formatDateTime(0, null, 'blah', null);
	}

	public function testFormatDateTime_timeTypeInvalid() {
		$this->expectException(\InvalidArgumentException::class);

		$this->ext->formatDateTime(0, null, null, 'blah');
	}

	public function testFormatDateTime_dateTypeAndTimeTypeInvalid() {
		$this->expectException(\InvalidArgumentException::class);

		$this->ext->formatDateTime(0, null, 'blah', 'blah');
	}

	public function testFormatDateTime_timeZoneInvalid() {
		$this->expectException(\InvalidArgumentException::class);

		$this->ext->formatDateTime(0, null, null, null, 'blah');
	}

}
