<?php

namespace Craue\TwigExtensionsBundle\Tests\Twig\Extension;

use Craue\TwigExtensionsBundle\Twig\Extension\FormatDateTimeExtension;

/**
 * @group unit
 *
 * @author Christian Raue <christian.raue@gmail.com>
 * @copyright 2011-2012 Christian Raue
 * @license http://www.opensource.org/licenses/mit-license.php MIT License
 */
class FormatDateTimeExtensionTest extends \PHPUnit_Framework_TestCase {

	/**
	 * @var FormatNumberExtension
	 */
	protected $ext;

	protected function setUp() {
		$this->ext = new FormatDateTimeExtension();
	}

	/**
	 * @expectedException \InvalidArgumentException
	 */
	public function testFormatDate_dateTypeNone() {
		$this->ext->formatDate(0, null, 'none');
	}

	/**
	 * @expectedException \InvalidArgumentException
	 */
	public function testFormatDate_dateTypeInvalid() {
		$this->ext->formatDate(0, null, 'blah');
	}

	/**
	 * @expectedException \InvalidArgumentException
	 */
	public function testFormatDate_valueInvalid() {
		$this->ext->formatDate('blah');
	}

	/**
	 * @expectedException \InvalidArgumentException
	 */
	public function testFormatTime_timeTypeNone() {
		$this->ext->formatTime(0, null, 'none');
	}

	/**
	 * @expectedException \InvalidArgumentException
	 */
	public function testFormatTime_timeTypeInvalid() {
		$this->ext->formatTime(0, null, 'blah');
	}

	/**
	 * @expectedException \InvalidArgumentException
	 */
	public function testFormatDateTime_dateTypeAndTimeTypeNone() {
		$this->ext->formatDateTime(0, null, 'none', 'none');
	}

	/**
	 * @expectedException \InvalidArgumentException
	 */
	public function testFormatDateTime_dateTypeInvalid() {
		$this->ext->formatDateTime(0, null, 'blah', null);
	}

	/**
	 * @expectedException \InvalidArgumentException
	 */
	public function testFormatDateTime_timeTypeInvalid() {
		$this->ext->formatDateTime(0, null, null, 'blah');
	}

	/**
	 * @expectedException \InvalidArgumentException
	 */
	public function testFormatDateTime_dateTypeAndTimeTypeInvalid() {
		$this->ext->formatDateTime(0, null, 'blah', 'blah');
	}

	/**
	 * @expectedException \InvalidArgumentException
	 */
	public function testFormatDateTime_timeZoneInvalid() {
		$this->ext->formatDateTime(0, null, null, null, 'blah');
	}

}
