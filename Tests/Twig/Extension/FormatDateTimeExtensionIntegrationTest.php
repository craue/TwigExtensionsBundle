<?php

namespace Craue\TwigExtensionsBundle\Tests\Twig\Extension;

use Craue\TwigExtensionsBundle\Tests\TwigBasedTestCase;

/**
 * @group integration
 *
 * @author Christian Raue <christian.raue@gmail.com>
 * @copyright 2011-2019 Christian Raue
 * @license http://opensource.org/licenses/mit-license.php MIT License
 */
class FormatDateTimeExtensionIntegrationTest extends TwigBasedTestCase {

	const DEFAULT_TIME_ZONE = 'Europe/Berlin';

	private static $currentTimezone;

	public static function setUpBeforeClass() {
		parent::setUpBeforeClass();

		self::$currentTimezone = date_default_timezone_get();
		date_default_timezone_set(self::DEFAULT_TIME_ZONE);
	}

	public static function tearDownAfterClass() {
		date_default_timezone_set(self::$currentTimezone);

		parent::tearDownAfterClass();
	}

	/**
	 * @dataProvider dataFormatDate
	 */
	public function testFormatDate($value, $locale, $dateType, $timeZone, $result) {
		$this->assertSame($result,
				$this->getTwig()->render('@IntegrationTest/FormatDateTime/date.html.twig', [
					'value' => $value,
					'locale' => $locale,
					'dateType' => $dateType,
					'timeZone' => $timeZone,
				]));
	}

	public function dataFormatDate() {
		$currentTimezone = date_default_timezone_get();

		date_default_timezone_set(self::DEFAULT_TIME_ZONE);

		$testdata = [
			[null, null, null, null, ''],
			[0, null, null, null, 'Jan 1, 1970'],
			['0', null, null, null, 'Jan 1, 1970'],
			// descriptive format
			['1970-01-01', null, null, null, 'Jan 1, 1970'],
			['January 1, 1970', null, null, null, 'Jan 1, 1970'],
			['1970-01-01 - 50years', null, null, null, 'Jan 1, 1920'],
			['last day of February 2012', null, null, null, 'Feb 29, 2012'],
			// far future date in descriptive format
			['3377-01-01 +1year', null, null, null, 'Jan 1, 3378'],
			['1970-01-01 + 1000years', null, null, null, 'Jan 1, 2970'],
			['last day of February 4500', null, null, null, 'Feb 28, 4500'],
			// German format in all variations
			[new \DateTime('2000-01-01'), 'de-DE', 'short', null, '01.01.00'],
			[new \DateTime('2000-01-01'), 'de-DE', 'medium', null, '01.01.2000'],
			[new \DateTime('2000-01-01'), 'de-DE', 'long', null, '1. Januar 2000'],
			[new \DateTime('2000-01-01'), 'de-DE', 'full', null, 'Samstag, 1. Januar 2000'],
			// US format in all variations
			[new \DateTime('2000-01-01'), 'en-US', 'short', null, '1/1/00'],
			[new \DateTime('2000-01-01'), 'en-US', 'medium', null, 'Jan 1, 2000'],
			[new \DateTime('2000-01-01'), 'en-US', 'long', null, 'January 1, 2000'],
			[new \DateTime('2000-01-01'), 'en-US', 'full', null, 'Saturday, January 1, 2000'],
			// far future date
			[44417974000, null, null, null, 'Jul 20, 3377'],
			// far future date as string value
			['44417974000', null, null, null, 'Jul 20, 3377'],
			// far past date
			[-16417974000, null, null, null, 'Sep 17, 1449'],
			// time zone
			[44417974000, null, null, 'US/Hawaii', 'Jul 19, 3377'],
			// others
			[new \DateTimeImmutable('2000-01-01'), 'de-DE', 'medium', null, '01.01.2000'],
		];

		date_default_timezone_set($currentTimezone);

		return $testdata;
	}

	/**
	 * @dataProvider dataFormatTime
	 */
	public function testFormatTime($value, $locale, $timeType, $result) {
		$this->assertRegExp($result,
				$this->getTwig()->render('@IntegrationTest/FormatDateTime/time.html.twig', [
					'value' => $value,
					'locale' => $locale,
					'timeType' => $timeType,
				]));
	}

	public function dataFormatTime() {
		$currentTimezone = date_default_timezone_get();

		date_default_timezone_set(self::DEFAULT_TIME_ZONE);

		$testdata = [
			[null, null, null, '//'],
			[0, null, null, '/1:00:00 AM/'],
			['0', null, null, '/1:00:00 AM/'],
			// descriptive format
			['01:00 AM', null, null, '/1:00:00 AM/'],
			['01:00 AM + 1hour', null, null, '/2:00:00 AM/'],
			// German format in all variations
			[new \DateTime('2000-01-01 12:34:56'), 'de-DE', 'short', '/12:34/'],
			[new \DateTime('2000-01-01 12:34:56'), 'de-DE', 'medium', '/12:34:56/'],
			[new \DateTime('2000-01-01 12:34:56'), 'de-DE', 'long', '/12:34:56 MEZ/'],
			[new \DateTime('2000-01-01 12:34:56'), 'de-DE', 'full', '/12:34:56 Mitteleuropäische (Zeit|Normalzeit)/'],
			// US format in all variations
			[new \DateTime('2000-01-01 12:34:56'), 'en-US', 'short', '/12:34 PM/'],
			[new \DateTime('2000-01-01 12:34:56'), 'en-US', 'medium', '/12:34:56 PM/'],
			[new \DateTime('2000-01-01 12:34:56'), 'en-US', 'long', '/12:34:56 PM GMT\+(1|01:00)/'],
			[new \DateTime('2000-01-01 12:34:56'), 'en-US', 'full', '/12:34:56 PM Central European( Standard)? Time/'],
			// others
			[new \DateTimeImmutable('2000-01-01 12:34:56'), 'de-DE', 'medium', '/12:34:56/'],
		];

		date_default_timezone_set($currentTimezone);

		return $testdata;
	}

	/**
	 * @dataProvider dataFormatTime_timeZone
	 */
	public function testFormatTime_timeZone($value, $locale, $timeType, $systemTimeZone, $timeZone, $result) {
		$currentTimezone = date_default_timezone_get();

		if ($systemTimeZone !== null) {
			date_default_timezone_set($systemTimeZone);
		}

		$this->assertSame($result,
				$this->getTwig()->render('@IntegrationTest/FormatDateTime/time.html.twig', [
					'value' => $value,
					'locale' => $locale,
					'timeType' => $timeType,
					'timeZone' => $timeZone,
				]));

		date_default_timezone_set($currentTimezone);
	}

	public function dataFormatTime_timeZone() {
		$currentTimezone = date_default_timezone_get();

		date_default_timezone_set(self::DEFAULT_TIME_ZONE);

		/*
		 * don't use a time type of 'long' or 'full' here as its output seems to be system-dependend,
		 * see http://travis-ci.org/#!/craue/TwigExtensionsBundle/jobs/2410874
		 * and http://travis-ci.org/#!/craue/TwigExtensionsBundle/jobs/2411373
		 */
		$testdata = [
			[new \DateTime('2124-11-22 12:34:56'), 'de-DE', 'medium', null, 'Europe/Berlin', '12:34:56'],
			[new \DateTime('2124-11-22 12:34:56'), 'de-DE', 'medium', null, 'US/Hawaii', '01:34:56'],
			[new \DateTime('2124-11-22 12:34:56'), 'de-DE', 'medium', 'US/Hawaii', null, '01:34:56'],
			[new \DateTime('2124-11-22 12:34:56'), 'de-DE', 'medium', 'Europe/Berlin', 'UTC', '11:34:56'],
		];

		date_default_timezone_set($currentTimezone);

		return $testdata;
	}

	/**
	 * @dataProvider dataFormatDateTime
	 */
	public function testFormatDateTime($value, $locale, $dateType, $timeType, $timeZone, $result) {
		$this->assertRegExp($result,
				$this->getTwig()->render('@IntegrationTest/FormatDateTime/dateTime.html.twig', [
					'value' => $value,
					'locale' => $locale,
					'dateType' => $dateType,
					'timeType' => $timeType,
					'timeZone' => $timeZone,
				]));
	}

	public function dataFormatDateTime() {
		$currentTimezone = date_default_timezone_get();

		date_default_timezone_set(self::DEFAULT_TIME_ZONE);

		$testdata = [
			[null, null, null, null, null, '//'],
			[0, null, null, null, null, '/Jan 1, 1970,? 1:00:00 AM/'],
			['0', null, null, null, null, '/Jan 1, 1970,? 1:00:00 AM/'],
			// descriptive format
			['1970-01-01 01:00 AM', null, null, null, null, '/Jan 1, 1970,? 1:00:00 AM/'],
			['January 1, 1970 01:00 AM', null, null, null, null, '/Jan 1, 1970,? 1:00:00 AM/'],
			['January 1, 1970 01:00 AM - 50years', null, null, null, null, '/Jan 1, 1920,? 1:00:00 AM/'],
			// far future date in descriptive format
			['January 1, 1970 01:00 AM + 1000years', null, null, null, null, '/Jan 1, 2970,? 1:00:00 AM/'],
			// short+short/full+full variations
			[new \DateTime('2124-11-22 12:34:56'), 'de-DE', 'short', 'short', null, '/22.11.24,? 12:34/'],
			[new \DateTime('2124-11-22 12:34:56'), 'de-DE', 'full', 'full', null, '/Mittwoch, 22. November 2124( um)? 12:34:56 Mitteleuropäische (Zeit|Normalzeit)/'],
			// variations with "none"
			[new \DateTime('2124-11-22 12:34:56'), 'de-DE', 'none', 'medium', null, '/12:34:56/'],
			[new \DateTime('2124-11-22 12:34:56'), 'de-DE', 'medium', 'none', null, '/22.11.2124/'],
			// time zone
			[44417974000, null, 'full', 'full', 'US/Hawaii', '/Saturday, July 19, 3377( at)? 12:06:40 PM Hawaii-Aleutian Standard Time/'],
			// others
			[new \DateTimeImmutable('2000-01-01 12:34:56'), 'de-DE', 'medium', 'medium', null, '/01.01.2000,? 12:34:56/'],
		];

		date_default_timezone_set($currentTimezone);

		return $testdata;
	}

}
