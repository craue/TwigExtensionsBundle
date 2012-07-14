<?php

namespace Craue\TwigExtensionsBundle\Twig\Extension;

/**
 * Twig extension providing filters for locale-aware formatting of date, time, and date/time values.
 *
 * @author Christian Raue <christian.raue@gmail.com>
 * @copyright 2011-2012 Christian Raue
 * @license http://www.opensource.org/licenses/mit-license.php MIT License
 */
class FormatDateTimeExtension extends AbstractLocaleAwareExtension {

	/**
	 * @var integer
	 */
	protected $dateType = \IntlDateFormatter::MEDIUM;

	/**
	 * @var integer
	 */
	protected $timeType = \IntlDateFormatter::MEDIUM;

	/**
	 * @var string|null
	 */
	protected $timeZone = null;

	/**
	 * @var string
	 */
	protected $dateFilterAlias = null;

	/**
	 * @var string
	 */
	protected $timeFilterAlias = null;

	/**
	 * @var string
	 */
	protected $dateTimeFilterAlias = null;

	/**
	 * @param string $dateType Date format. Valid values are "none", "full", "long", "medium", or "short" (case insensitive).
	 * @param string $timeType Time format. Valid values are "none", "full", "long", "medium", or "short" (case insensitive).
	 */
	public function setDateTimeTypes($dateType = null, $timeType = null) {
		if ($dateType !== null) {
			$this->dateType = $this->getDateFormatterFormat($dateType);
		}
		if ($timeType !== null) {
			$this->timeType = $this->getDateFormatterFormat($timeType);
		}
	}

	/**
	 * @param string $timeZone Time zone from {@link http://php.net/manual/timezones.php}.
	 */
	public function setTimeZone($timeZone = null) {
		if (!empty($timeZone)) {
			$this->timeZone = $timeZone;
		}
	}

	/**
	 * @param string $dateFilterAlias Alias for the date filter.
	 * @param string $timeFilterAlias Alias for the time filter.
	 * @param string $dateTimeFilterAlias Alias for the date/time filter.
	 */
	public function setAliases($dateFilterAlias = null, $timeFilterAlias = null, $dateTimeFilterAlias = null) {
		if (!empty($dateFilterAlias)) {
			$this->dateFilterAlias = $dateFilterAlias;
		}
		if (!empty($timeFilterAlias)) {
			$this->timeFilterAlias = $timeFilterAlias;
		}
		if (!empty($dateTimeFilterAlias)) {
			$this->dateTimeFilterAlias = $dateTimeFilterAlias;
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
		$filters = array();

		$formatDateMethod = new \Twig_Filter_Method($this, 'formatDate');
		$filters['craue_date'] = $formatDateMethod;
		if (!empty($this->dateFilterAlias)) {
			$filters[$this->dateFilterAlias] = $formatDateMethod;
		}

		$formatTimeMethod = new \Twig_Filter_Method($this, 'formatTime');
		$filters['craue_time'] = $formatTimeMethod;
		if (!empty($this->timeFilterAlias)) {
			$filters[$this->timeFilterAlias] = $formatTimeMethod;
		}

		$formatDateTimeMethod = new \Twig_Filter_Method($this, 'formatDateTime');
		$filters['craue_datetime'] = $formatDateTimeMethod;
		if (!empty($this->dateTimeFilterAlias)) {
			$filters[$this->dateTimeFilterAlias] = $formatDateTimeMethod;
		}

		return $filters;
	}

	/**
	 * Formats a timestamp as date.
	 * @param mixed $value Date value to be formatted.
	 * @param string $locale Locale to be used with {@link http://php.net/manual/class.intldateformatter.php}.
	 * @param string $dateType Date format. Valid values are "full", "long", "medium", or "short" (case insensitive).
	 * @param string $timeZone Time zone from {@link http://php.net/manual/timezones.php}.
	 * @return string Formatted date.
	 * @throws \InvalidArgumentException
	 */
	public function formatDate($value, $locale = null, $dateType = null, $timeZone = null) {
		if ($dateType === 'none') {
			throw new \InvalidArgumentException('Cannot apply a date formatting of "none". What did you expect?');
		}

		return $this->getFormattedDateTime($value, $locale, $dateType, 'none', $timeZone);
	}

	/**
	 * Formats a timestamp as time.
	 * @param mixed $value Time value to be formatted.
	 * @param string $locale Locale to be used with {@link http://php.net/manual/class.intldateformatter.php}.
	 * @param string $timeType Time format. Valid values are "full", "long", "medium", or "short" (case insensitive).
	 * @param string $timeZone Time zone from {@link http://php.net/manual/timezones.php}.
	 * @return string Formatted time.
	 * @throws \InvalidArgumentException
	 */
	public function formatTime($value, $locale = null, $timeType = null, $timeZone = null) {
		if ($timeType === 'none') {
			throw new \InvalidArgumentException('Cannot apply a time formatting of "none". What did you expect?');
		}

		return $this->getFormattedDateTime($value, $locale, 'none', $timeType, $timeZone);
	}

	/**
	 * Formats a timestamp as date and time.
	 * @param mixed $value Date/time value to be formatted.
	 * @param string $locale Locale to be used with {@link http://php.net/manual/class.intldateformatter.php}.
	 * @param string $dateType Date format. Valid values are "none", "full", "long", "medium", or "short" (case insensitive).
	 * @param string $timeType Time format. Valid values are "none", "full", "long", "medium", or "short" (case insensitive).
	 * @param string $timeZone Time zone from {@link http://php.net/manual/timezones.php}.
	 * @return string Formatted date and time.
	 * @throws \InvalidArgumentException
	 */
	public function formatDateTime($value, $locale = null, $dateType = null, $timeType = null, $timeZone = null) {
		if ($dateType === 'none' && $timeType === 'none') {
			throw new \InvalidArgumentException('Cannot apply a date/time formatting of "none". What did you expect?');
		}

		return $this->getFormattedDateTime($value, $locale, $dateType, $timeType, $timeZone);
	}

	/**
	 * Formats a date/time value.
	 * If the value is null also null will be returned.
	 * @param mixed $value Date/time value to be formatted using {@link http://php.net/manual/intldateformatter.format.php}.
	 * @param string $locale Locale to be used with {@link http://php.net/manual/class.intldateformatter.php}.
	 * @param string $dateType Date format. Valid values are "none", "full", "long", "medium", or "short" (case insensitive).
	 * @param string $timeType Time format. Valid values are "none", "full", "long", "medium", or "short" (case insensitive).
	 * @param string $timeZone Time zone from {@link http://php.net/manual/timezones.php}.
	 * @return string Formatted date/time.
	 * @throws \InvalidArgumentException
	 */
	protected function getFormattedDateTime($value, $locale, $dateType, $timeType, $timeZone = null) {
		if ($value === null) {
			return null;
		}

		$valueToUse = $value;

		// IntlDateFormatter#format() doesn't support \DateTime objects prior to PHP 5.3.4 (http://php.net/manual/intldateformatter.format.php)
		if ($valueToUse instanceof \DateTime) {
			// \DateTime::getTimestamp() would return false for year > 2038 on 32-bit systems (https://bugs.php.net/bug.php?id=50590)
			$valueToUse = floatval($valueToUse->format('U'));
		} elseif (is_string($valueToUse)) {
			$valueToUse = floatval($valueToUse);
		}

		$localeToUse = !empty($locale) ? $locale : $this->getLocale();
		$dateTypeToUse = $dateType === null ? $this->dateType : $this->getDateFormatterFormat($dateType);
		$timeTypeToUse = $timeType === null ? $this->timeType : $this->getDateFormatterFormat($timeType);
		$timeZoneToUse = $this->getEffectiveTimeZone($timeZone);

		$formatter = new \IntlDateFormatter($localeToUse, $dateTypeToUse, $timeTypeToUse, $timeZoneToUse);

		$result = $formatter->format($valueToUse);
		if ($result === false) {
			throw new \InvalidArgumentException(sprintf('The value "%s" of type %s cannot be formatted. Error: "%s".', $value, gettype($value), $formatter->getErrorMessage()));
		}

		return $result;
	}

	/**
	 * @param string $format Date/time format. Valid values are "none", "full", "long", "medium", or "short" (case insensitive).
	 * @return integer Appropriate value of {@link http://php.net/manual/class.intldateformatter.php#intl.intldateformatter-constants}.
	 * @throws \InvalidArgumentException
	 */
	protected function getDateFormatterFormat($format) {
		switch (strtoupper($format)) {
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
				throw new \InvalidArgumentException(sprintf('A value of "%s" is not supported.', $format));
		}
	}

	/**
	 * @param string $timeZone Time zone from {@link http://php.net/manual/timezones.php}.
	 * @return string
	 * @throws \InvalidArgumentException
	 */
	protected function getEffectiveTimeZone($timeZone = null) {
		if ($timeZone !== null) {
			return $this->validateTimeZone($timeZone);
		}

		if ($this->timeZone !== null) {
			return $this->validateTimeZone($this->timeZone);
		}

		return date_default_timezone_get();
	}

	/**
	 * @param string $timeZone Name of a time zone to be validated.
	 * @return string Valid name of that time zone.
	 * @throws \InvalidArgumentException
	 */
	protected function validateTimeZone($timeZone) {
		try {
			$instance = new \DateTimeZone($timeZone);
			return $instance->getName();
		} catch (\Exception $e) {
			throw new \InvalidArgumentException(sprintf('A value of "%s" is not a supported time zone.', $timeZone));
		}
	}

}
