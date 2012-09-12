<?php

namespace Craue\TwigExtensionsBundle\Tests\Twig\Extension;

use Craue\TwigExtensionsBundle\Tests\TwigBasedTestCase;

/**
 * @group integration
 *
 * @author Christian Raue <christian.raue@gmail.com>
 * @copyright 2011-2012 Christian Raue
 * @license http://www.opensource.org/licenses/mit-license.php MIT License
 */
class FormatDateTimeExtensionIntegrationTest extends TwigBasedTestCase {

	private $currentTimezone;

	protected function setUp() {
		parent::setUp();

		$this->currentTimezone = date_default_timezone_get();
		date_default_timezone_set('Europe/Berlin');
	}

	protected function tearDown() {
		date_default_timezone_set($this->currentTimezone);

		parent::tearDown();
	}

	public function testFormatDate() {
		$cases = array(
			array(
				'value' => null,
				'locale' => null,
				'dateType' => null,
				'timeZone' => null,
				'result' => '',
			),
			array(
				'value' => 0,
				'locale' => null,
				'dateType' => null,
				'timeZone' => null,
				'result' => 'Jan 1, 1970',
			),
			array(
				'value' => '0',
				'locale' => null,
				'dateType' => null,
				'timeZone' => null,
				'result' => 'Jan 1, 1970',
			),
			
			// datetime expressions
			array(
				'value' => '1970-01-01',
				'locale' => null,
				'dateType' => null,
				'timeZone' => null,
				'result' => 'Jan 1, 1970',
			),
			array(
				'value' => '3377-01-01 +1year',
				'locale' => null,
				'dateType' => null,
				'timeZone' => null,
				'result' => 'Jan 1, 3378',
			),
			array(
				'value' => 'January 1, 1970',
				'locale' => null,
				'dateType' => null,
				'timeZone' => null,
				'result' => 'Jan 1, 1970',
			),
			array(
				'value' => '1970-01-01 + 1000years',
				'locale' => null,
				'dateType' => null,
				'timeZone' => null,
				'result' => 'Jan 1, 2970',
			),
			array(
				'value' => '1970-01-01 - 50years',
				'locale' => null,
				'dateType' => null,
				'timeZone' => null,
				'result' => 'Jan 1, 1920',
			),
			array(
				'value' => 'today +1day',
				'locale' => null,
				'dateType' => null,
				'timeZone' => null,
				'result' => defined('PHP_WINDOWS_VERSION_BUILD')
						? strftime('%b %#d, %Y', strtotime('today +1day'))
						: strftime('%b %e, %Y', strtotime('today +1day'))
			),

			// German format in all variations
			array(
				'value' => new \DateTime('2000-01-01'),
				'locale' => 'de-DE',
				'dateType' => 'short',
				'timeZone' => null,
				'result' => '01.01.00',
			),
			array(
				'value' => new \DateTime('2000-01-01'),
				'locale' => 'de-DE',
				'dateType' => 'medium',
				'timeZone' => null,
				'result' => '01.01.2000',
			),
			array(
				'value' => new \DateTime('2000-01-01'),
				'locale' => 'de-DE',
				'dateType' => 'long',
				'timeZone' => null,
				'result' => '1. Januar 2000',
			),
			array(
				'value' => new \DateTime('2000-01-01'),
				'locale' => 'de-DE',
				'dateType' => 'full',
				'timeZone' => null,
				'result' => 'Samstag, 1. Januar 2000',
			),

			// US format in all variations
			array(
				'value' => new \DateTime('2000-01-01'),
				'locale' => 'en-US',
				'dateType' => 'short',
				'timeZone' => null,
				'result' => '1/1/00',
			),
			array(
				'value' => new \DateTime('2000-01-01'),
				'locale' => 'en-US',
				'dateType' => 'medium',
				'timeZone' => null,
				'result' => 'Jan 1, 2000',
			),
			array(
				'value' => new \DateTime('2000-01-01'),
				'locale' => 'en-US',
				'dateType' => 'long',
				'timeZone' => null,
				'result' => 'January 1, 2000',
			),
			array(
				'value' => new \DateTime('2000-01-01'),
				'locale' => 'en-US',
				'dateType' => 'full',
				'timeZone' => null,
				'result' => 'Saturday, January 1, 2000',
			),

			// far future date
			array(
				'value' => 44417974000,
				'locale' => null,
				'dateType' => null,
				'timeZone' => null,
				'result' => 'Jul 20, 3377',
			),
			// far future date as string value
			array(
				'value' => '44417974000',
				'locale' => null,
				'dateType' => null,
				'timeZone' => null,
				'result' => 'Jul 20, 3377',
			),

			// far past date
			array(
				'value' => -16417974000,
				'locale' => null,
				'dateType' => null,
				'timeZone' => null,
				'result' => 'Sep 17, 1449',
			),

			// time zone
			array(
				'value' => 44417974000,
				'locale' => null,
				'dateType' => null,
				'timeZone' => 'US/Hawaii',
				'result' => 'Jul 19, 3377',
			),
		);

		foreach ($cases as $index => $case) {
			$this->assertSame($case['result'],
					$this->getTwig()->render('IntegrationTestBundle:FormatDateTime:date.html.twig', array(
						'value' => $case['value'],
						'locale' => $case['locale'],
						'dateType' => $case['dateType'],
						'timeZone' => $case['timeZone'],
					)),
					'test case with index '.$index);
		}
	}

	public function testFormatTime() {
		$cases = array(
			array(
				'value' => null,
				'locale' => null,
				'timeType' => null,
				'result' => '',
			),
			array(
				'value' => 0,
				'locale' => null,
				'timeType' => null,
				'result' => '1:00:00 AM',
			),
			array(
				'value' => '0',
				'locale' => null,
				'timeType' => null,
				'result' => '1:00:00 AM',
			),
			
			// datetime expressions
			array(
				'value' => '01:00 AM',
				'locale' => null,
				'timeType' => null,
				'result' => '1:00:00 AM',
			),
			array(
				'value' => '01:00 AM + 1hour',
				'locale' => null,
				'timeType' => null,
				'result' => '2:00:00 AM',
			),
			array(
				'value' => 'today +1day',
				'locale' => null,
				'timeType' => null,
				'result' => strftime('%I:%M:%S %p', strtotime('today +1day'))
			),

			// German format in all variations
			array(
				'value' => new \DateTime('2000-01-01 12:34:56'),
				'locale' => 'de-DE',
				'timeType' => 'short',
				'result' => '12:34',
			),
			array(
				'value' => new \DateTime('2000-01-01 12:34:56'),
				'locale' => 'de-DE',
				'timeType' => 'medium',
				'result' => '12:34:56',
			),
			array(
				'value' => new \DateTime('2000-01-01 12:34:56'),
				'locale' => 'de-DE',
				'timeType' => 'long',
				'result' => '12:34:56 MEZ',
			),
			array(
				'value' => new \DateTime('2000-01-01 12:34:56'),
				'locale' => 'de-DE',
				'timeType' => 'full',
				'result' => '12:34:56 Mitteleuropäische Zeit',
			),

			// US format in all variations
			array(
				'value' => new \DateTime('2000-01-01 12:34:56'),
				'locale' => 'en-US',
				'timeType' => 'short',
				'result' => '12:34 PM',
			),
			array(
				'value' => new \DateTime('2000-01-01 12:34:56'),
				'locale' => 'en-US',
				'timeType' => 'medium',
				'result' => '12:34:56 PM',
			),
			array(
				'value' => new \DateTime('2000-01-01 12:34:56'),
				'locale' => 'en-US',
				'timeType' => 'long',
				'result' => '12:34:56 PM GMT+01:00',
			),
			array(
				'value' => new \DateTime('2000-01-01 12:34:56'),
				'locale' => 'en-US',
				'timeType' => 'full',
				'result' => '12:34:56 PM Central European Time',
			),
		);

		foreach ($cases as $index => $case) {
			$this->assertSame($case['result'],
					$this->getTwig()->render('IntegrationTestBundle:FormatDateTime:time.html.twig', array(
						'value' => $case['value'],
						'locale' => $case['locale'],
						'timeType' => $case['timeType'],
					)),
					'test case with index '.$index);
		}
	}

	public function testFormatTime_timeZone() {
		$cases = array(
			array(
				'value' => new \DateTime('2124-11-22 12:34:56'),
				'locale' => 'de-DE',
				'timeType' => 'full',
				'systemTimeZone' => null,
				'timeZone' => 'Europe/Berlin',
				'result' => '12:34:56 Mitteleuropäische Zeit',
			),
			array(
				'value' => new \DateTime('2124-11-22 12:34:56'),
				'locale' => 'de-DE',
				'timeType' => 'full',
				'systemTimeZone' => null,
				'timeZone' => 'US/Hawaii',
				'result' => '01:34:56 GMT-10:00',
			),
			array(
				'value' => new \DateTime('2124-11-22 12:34:56'),
				'locale' => 'de-DE',
				'timeType' => 'full',
				'systemTimeZone' => 'US/Hawaii',
				'timeZone' => null,
				'result' => '01:34:56 GMT-10:00',
			),
			array(
				'value' => new \DateTime('2124-11-22 12:34:56'),
				'locale' => 'de-DE',
				'timeType' => 'full',
				'systemTimeZone' => 'Europe/Berlin',
				'timeZone' => 'UTC',
				'result' => '11:34:56 GMT+00:00',
			),
		);

		foreach ($cases as $index => $case) {
			$currentTimezone = date_default_timezone_get();

			if ($case['systemTimeZone'] !== null) {
				date_default_timezone_set($case['systemTimeZone']);
			}

			$this->assertSame($case['result'],
					$this->getTwig()->render('IntegrationTestBundle:FormatDateTime:time.html.twig', array(
						'value' => $case['value'],
						'locale' => $case['locale'],
						'timeType' => $case['timeType'],
						'timeZone' => $case['timeZone'],
					)),
					'test case with index '.$index);

			date_default_timezone_set($currentTimezone);
		}
	}

	public function testFormatDateTime() {
		$cases = array(
			array(
				'value' => null,
				'locale' => null,
				'dateType' => null,
				'timeType' => null,
				'timeZone' => null,
				'result' => '',
			),
			array(
				'value' => 0,
				'locale' => null,
				'dateType' => null,
				'timeType' => null,
				'timeZone' => null,
				'result' => 'Jan 1, 1970 1:00:00 AM',
			),
			array(
				'value' => '0',
				'locale' => null,
				'dateType' => null,
				'timeType' => null,
				'timeZone' => null,
				'result' => 'Jan 1, 1970 1:00:00 AM',
			),
			
			// datetime expressions
			array(
				'value' => '1970-01-01 01:00 AM',
				'locale' => null,
				'dateType' => null,
				'timeType' => null,
				'timeZone' => null,
				'result' => 'Jan 1, 1970 1:00:00 AM',
			),
			array(
				'value' => 'January 1, 1970 01:00 AM',
				'locale' => null,
				'dateType' => null,
				'timeType' => null,
				'timeZone' => null,
				'result' => 'Jan 1, 1970 1:00:00 AM',
			),
			array(
				'value' => 'January 1, 1970 01:00 AM - 50years',
				'locale' => null,
				'dateType' => null,
				'timeType' => null,
				'timeZone' => null,
				'result' => 'Jan 1, 1920 1:00:00 AM',
			),
			array(
				'value' => 'January 1, 1970 01:00 AM + 1000years',
				'locale' => null,
				'dateType' => null,
				'timeType' => null,
				'timeZone' => null,
				'result' => 'Jan 1, 2970 1:00:00 AM',
			),
			array(
				'value' => 'today +1day',
				'locale' => null,
				'dateType' => null,
				'timeType' => null,
				'timeZone' => null,
				'result' => defined('PHP_WINDOWS_VERSION_BUILD')
						? strftime('%b %#d, %Y %I:%M:%S %p', strtotime('today +1day'))
						: strftime('%b %e, %Y %l:%M:%S %p', strtotime('today +1day'))
			),

			// short+short/full+full variations
			array(
				'value' => new \DateTime('2124-11-22 12:34:56'),
				'locale' => 'de-DE',
				'dateType' => 'short',
				'timeType' => 'short',
				'timeZone' => null,
				'result' => '22.11.24 12:34',
			),
			array(
				'value' => new \DateTime('2124-11-22 12:34:56'),
				'locale' => 'de-DE',
				'dateType' => 'full',
				'timeType' => 'full',
				'timeZone' => null,
				'result' => 'Mittwoch, 22. November 2124 12:34:56 Mitteleuropäische Zeit',
			),

			// variations with "none"
			array(
				'value' => new \DateTime('2124-11-22 12:34:56'),
				'locale' => 'de-DE',
				'dateType' => 'none',
				'timeType' => 'medium',
				'timeZone' => null,
				'result' => '12:34:56',
			),
			array(
				'value' => new \DateTime('2124-11-22 12:34:56'),
				'locale' => 'de-DE',
				'dateType' => 'medium',
				'timeType' => 'none',
				'timeZone' => null,
				'result' => '22.11.2124',
			),

			// time zone
			array(
				'value' => 44417974000,
				'locale' => null,
				'dateType' => 'full',
				'timeType' => 'full',
				'timeZone' => 'US/Hawaii',
				'result' => 'Saturday, July 19, 3377 12:06:40 PM Hawaii-Aleutian Standard Time',
			),
		);

		foreach ($cases as $index => $case) {
			$this->assertSame($case['result'],
					$this->getTwig()->render('IntegrationTestBundle:FormatDateTime:dateTime.html.twig', array(
						'value' => $case['value'],
						'locale' => $case['locale'],
						'dateType' => $case['dateType'],
						'timeType' => $case['timeType'],
						'timeZone' => $case['timeZone'],
					)),
					'test case with index '.$index);
		}
	}

}
