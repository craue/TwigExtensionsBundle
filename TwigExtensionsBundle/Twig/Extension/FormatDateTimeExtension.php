<?php

namespace Craue\TwigExtensionsBundle\Twig\Extension;

/**
 * Twig Extension to format date, time, and date/time values.
 * @author Christian Raue <christian.raue@gmail.com>
 */
class FormatDateTimeExtension extends \Twig_Extension {

	protected $locale = 'en-US';
	protected $datetype = \IntlDateFormatter::MEDIUM;
	protected $timetype = \IntlDateFormatter::MEDIUM;
	protected $prefix = 'craue_';

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

	public function formatDate($value, $locale = null) {
		return $this->getFormattedDateTime($value, $locale, $this->datetype, \IntlDateFormatter::NONE);
	}

	public function formatTime($value, $locale = null) {
		return $this->getFormattedDateTime($value, $locale, \IntlDateFormatter::NONE, $this->timetype);
	}

	public function formatDateTime($value, $locale = null) {
		return $this->getFormattedDateTime($value, $locale, $this->datetype, $this->timetype);
	}

	protected function getFormattedDateTime($value, $locale, $datetype, $timetype) {
		$localeToUse = !empty($locale) ? $locale : $this->locale;
		$formatter = new \IntlDateFormatter($localeToUse, $datetype, $timetype);
		return $formatter->format($value);
	}

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
