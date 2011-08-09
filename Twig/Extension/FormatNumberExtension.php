<?php

namespace Craue\TwigExtensionsBundle\Twig\Extension;

use Symfony\Component\HttpFoundation\Session;

/**
 * Twig extension providing filters for locale-aware formatting of numbers and currencies.
 *
 * @author Christian Raue <christian.raue@gmail.com>
 * @copyright 2011 Christian Raue
 * @license http://www.opensource.org/licenses/mit-license.php MIT License
 */
class FormatNumberExtension extends \Twig_Extension {

	/**
	 * @var string
	 */
	protected $locale = 'en-US';

	/**
	 * @var string
	 */
	protected $numberFilterAlias = null;

	/**
	 * @var string
	 */
	protected $currencyFilterAlias = null;

	/**
	 * @var string
	 */
	protected $spelloutFilterAlias = null;

	/**
	 * @param string $numberFilterAlias Alias for the number filter.
	 * @param string $currencyFilterAlias Alias for the currency filter.
	 * @param string $spelloutFilterAlias Alias for the spellout filter.
	 */
	public function setAliases($numberFilterAlias = null, $currencyFilterAlias = null, $spelloutFilterAlias = null) {
		if (!empty($numberFilterAlias)) {
			$this->numberFilterAlias = $numberFilterAlias;
		}
		if (!empty($currencyFilterAlias)) {
			$this->currencyFilterAlias = $currencyFilterAlias;
		}
		if (!empty($spelloutFilterAlias)) {
			$this->spelloutFilterAlias = $spelloutFilterAlias;
		}
	}

	/**
	 * Applies the current session's locale.
	 * @param Session $session
	 */
	public function setLocaleFromSession(Session $session = null) {
		if ($session !== null) {
			$this->locale = $session->getLocale();
		}
	}

	/**
	 * {@inheritDoc}
	 */
	public function getName() {
		return 'craue_formatNumber';
	}

	/**
	 * {@inheritDoc}
	 */
	public function getFilters() {
		$filters = array();

		$formatNumberMethod = new \Twig_Filter_Method($this, 'formatNumber');
		$filters['craue_number'] = $formatNumberMethod;
		if (!empty($this->numberFilterAlias)) {
			$filters[$this->numberFilterAlias] = $formatNumberMethod;
		}

		$formatCurrencyMethod = new \Twig_Filter_Method($this, 'formatCurrency');
		$filters['craue_currency'] = $formatCurrencyMethod;
		if (!empty($this->currencyFilterAlias)) {
			$filters[$this->currencyFilterAlias] = $formatCurrencyMethod;
		}

		$formatSpelledOutNumberMethod = new \Twig_Filter_Method($this, 'formatSpelledOutNumber');
		$filters['craue_spellout'] = $formatSpelledOutNumberMethod;
		if (!empty($this->spelloutFilterAlias)) {
			$filters[$this->spelloutFilterAlias] = $formatSpelledOutNumberMethod;
		}

		return $filters;
	}

	/**
	 * Formats a number.
	 * @return string Formatted number.
	 */
	public function formatNumber($value, $locale = null) {
		return $this->getFormattedNumber($value, $locale, \NumberFormatter::DECIMAL);
	}

	/**
	 * Formats a currency.
	 * @return string Formatted currency.
	 */
	public function formatCurrency($value, $currency, $locale = null) {
		return $this->getFormattedCurrency($value, $locale, $currency);
	}

	/**
	 * Spells out a number.
	 * @return string Spelled out number.
	 */
	public function formatSpelledOutNumber($value, $locale = null) {
		return $this->getFormattedNumber($value, $locale, \NumberFormatter::SPELLOUT);
	}

	/**
	 * Formats a number.
	 * If the value is null also null will be returned.
	 * @param mixed $value Number to be formatted using {@link http://php.net/manual/class.numberformatter.php}.
	 * @param string $locale Locale to be used with {@link http://php.net/manual/class.numberformatter.php}.
	 * @param string $style Formatting style. See {@link http://php.net/manual/numberformatter.create.php}.
	 * @return string Formatted number.
	 */
	protected function getFormattedNumber($value, $locale, $style) {
		if ($value === null) {
			return null;
		}

		$localeToUse = !empty($locale) ? $locale : $this->locale;
		$formatter = new \NumberFormatter($localeToUse, $style);

		$result = $formatter->format($value);
		if ($result === false) {
			throw new \InvalidArgumentException(sprintf('The value "%s" of type %s cannot be formatted.', $value, gettype($value)));
		}

		return $result;
	}

	/**
	 * Formats a number.
	 * If the value is null also null will be returned.
	 * @param mixed $value Number to be formatted using {@link http://php.net/manual/numberformatter.formatcurrency.php}.
	 * @param string $locale Locale to be used with {@link http://php.net/manual/class.numberformatter.php}.
	 * @param string $currency Currency. See {@link http://php.net/manual/numberformatter.formatcurrency.php}.
	 * @return string Formatted number.
	 */
	protected function getFormattedCurrency($value, $locale, $currency) {
		if ($value === null) {
			return null;
		}

		$localeToUse = !empty($locale) ? $locale : $this->locale;
		$formatter = new \NumberFormatter($localeToUse, \NumberFormatter::CURRENCY);

		$result = $formatter->formatCurrency($value, $currency);
		if ($result === false) {
			throw new \InvalidArgumentException(sprintf('The value "%s" of type %s cannot be formatted.', $value, gettype($value)));
		}

		return $result;
	}

}
