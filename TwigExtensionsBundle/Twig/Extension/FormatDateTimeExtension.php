<?php

namespace Craue\TwigExtensionsBundle\Twig\Extension;

/**
 * Twig Extension providing Twig filters to locale-aware format date, time, and date/time values.
 * @author Christian Raue <christian.raue@gmail.com>
 */
class FormatDateTimeExtension extends \Twig_Extension {

	protected $locale = 'en-US';
	protected $datetype = \IntlDateFormatter::MEDIUM;
	protected $timetype = \IntlDateFormatter::MEDIUM;
	protected $prefix = 'craue_';

	/**
	 * @param string $locale Locale to be used with {@see http://www.php.net/manual/class.intldateformatter.php}.
	 * @param string $datetype Date format. Valid values are "none", "full", "long", "medium", or "short" (case insensitive).
	 * @param string $timetype Time format. Valid values are "none", "full", "long", "medium", or "short" (case insensitive).
	 * @param string $prefix Prefix to use for Twig filters.
	 */
	public function __construct($locale = null, $datetype = null, $timetype = null, $prefix = null) {
		if ($locale !== null) {
			$this->locale = $locale;
		}
		if ($datetype !== null) {
			$this->datetype = $this->getDateFormatterFormat($datetype);
		}
		if ($timetype !== null) {
			$this->timetype = $this->getDateFormatterFormat($timetype);
		}
		if ($prefix !== null) {
			$this->prefix = $prefix;
		}
	}

	/**
	 * {@inheritDoc}
	 */
	public function getName() {
		return 'craue_formatDateTime';
	}

	/**
	 * {@inheritDoc}
	 */
	public function getFilters() {
		return array(
			$this->prefix.'date' => new \Twig_Filter_Method($this, 'formatDate'),
			$this->prefix.'time' => new \Twig_Filter_Method($this, 'formatTime'),
			$this->prefix.'datetime' => new \Twig_Filter_Method($this, 'formatDateTime'),
		);
	}

	/**
	 * Formats a timestamp as date.
	 * @param mixed $value The date to be formatted.
	 * @param string $locale Locale to be used with {@see http://www.php.net/manual/class.intldateformatter.php}.
	 * @return string Formatted date.
	 */
	public function formatDate($value, $locale = null) {
		return $this->getFormattedDateTime($value, $locale, $this->datetype, \IntlDateFormatter::NONE);
	}

	/**
	 * Formats a timestamp as time.
	 * @param mixed $value The time to be formatted.
	 * @param string $locale Locale to be used with {@see http://www.php.net/manual/class.intldateformatter.php}.
	 * @return string Formatted time.
	 */
	public function formatTime($value, $locale = null) {
		return $this->getFormattedDateTime($value, $locale, \IntlDateFormatter::NONE, $this->timetype);
	}

	/**
	 * Formats a timestamp as date and time.
	 * @param mixed $value The date/time to be formatted.
	 * @param string $locale Locale to be used with {@see http://www.php.net/manual/class.intldateformatter.php}.
	 * @return string Formatted date and time.
	 */
	public function formatDateTime($value, $locale = null) {
		return $this->getFormattedDateTime($value, $locale, $this->datetype, $this->timetype);
	}

	/**
	 * Formats a date/time value.
	 * @param mixed $value The date/time to be formatted.
	 * @param string $locale Locale to be used with {@see http://www.php.net/manual/class.intldateformatter.php}.
	 * @param string $datetype Date format. Valid values are "none", "full", "long", "medium", or "short" (case insensitive).
	 * @param string $timetype Time format. Valid values are "none", "full", "long", "medium", or "short" (case insensitive).
	 * @return string Formatted date/time.
	 */
	protected function getFormattedDateTime($value, $locale, $datetype, $timetype) {
		$localeToUse = !empty($locale) ? $locale : $this->locale;
		$formatter = new \IntlDateFormatter($localeToUse, $datetype, $timetype);
		return $formatter->format($value);
	}

	/**
	 * @param string $value Date/time format. Valid values are "none", "full", "long", "medium", or "short" (case insensitive).
	 * @return int Appropriate value of {@see http://www.php.net/manual/en/class.intldateformatter.php#intl.intldateformatter-constants}.
	 * @throws InvalidArgumentException
	 */
	protected function getDateFormatterFormat($value) {
		switch (strtoupper($value)) {
			case 'NONE':
				return \IntlDateFormatter::NONE;
			case 'FULL':
				return \IntlDateFormatter::FULL;
			case 'LONG':
				return \IntlDateFormatter::LONG;
			case 'MEDIUM':
				return \IntlDateFormatter::MEDIUM;
			case 'SHORT':
				return \IntlDateFormatter::SHORT;
			default:
				throw new \InvalidArgumentException(sprintf('A value of "%s" is not supported.', $value));
		}
	}

}
