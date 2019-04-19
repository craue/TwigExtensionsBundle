<?php

namespace Craue\TwigExtensionsBundle\Twig\Extension;

use Craue\TwigExtensionsBundle\Util\TwigFeatureDefinition;
use Craue\TwigExtensionsBundle\Util\TwigFeatureUtil;

/**
 * Twig extension providing filters for locale-aware formatting of numbers and currencies.
 *
 * @author Christian Raue <christian.raue@gmail.com>
 * @copyright 2011-2019 Christian Raue
 * @license http://opensource.org/licenses/mit-license.php MIT License
 */
class FormatNumberExtension extends AbstractLocaleAwareExtension {

	/**
	 * @var string
	 */
	protected $currency;

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
	 * @param string $currency Currency. See {@link http://php.net/manual/numberformatter.formatcurrency.php} for valid values.
	 */
	public function setCurrency($currency = null) {
		if (!empty($currency)) {
			$this->currency = $currency;
		}
	}

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
	 * {@inheritDoc}
	 */
	public function getName() {
		return 'craue_formatNumber';
	}

	/**
	 * {@inheritDoc}
	 */
	public function getFilters() {
		return TwigFeatureUtil::getTwigFilters($this, [
			new TwigFeatureDefinition('craue_number', 'formatNumber', $this->numberFilterAlias),
			new TwigFeatureDefinition('craue_currency', 'formatCurrency', $this->currencyFilterAlias),
			new TwigFeatureDefinition('craue_spellout', 'formatSpelledOutNumber', $this->spelloutFilterAlias),
		]);
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
	public function formatCurrency($value, $currency = null, $locale = null) {
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
	 * @param int $style Formatting style. See {@link http://php.net/manual/numberformatter.create.php}.
	 * @return string|null Formatted number.
	 * @throws \InvalidArgumentException If {@code $value} cannot be formatted.
	 */
	protected function getFormattedNumber($value, $locale, $style) {
		if ($value === null) {
			return null;
		}

		$localeToUse = !empty($locale) ? $locale : $this->getLocale();
		$formatter = new \NumberFormatter($localeToUse, $style);

		$result = $formatter->format($value);
		if ($result === false) {
			throw new \InvalidArgumentException(sprintf('The value "%s" of type %s cannot be formatted.', $value, gettype($value)));
		}

		return $result;
	}

	/**
	 * Formats a currency.
	 * If the value is null also null will be returned.
	 * @param mixed $value Currency to be formatted using {@link http://php.net/manual/numberformatter.formatcurrency.php}.
	 * @param string $locale Locale to be used with {@link http://php.net/manual/class.numberformatter.php}.
	 * @param string $currency Currency. See {@link http://php.net/manual/numberformatter.formatcurrency.php}.
	 * @return string|null Formatted currency.
	 * @throws \InvalidArgumentException If {@code $value} cannot be formatted.
	 */
	protected function getFormattedCurrency($value, $locale = null, $currency = null) {
		if ($value === null) {
			return null;
		}

		$localeToUse = !empty($locale) ? $locale : $this->getLocale();
		$formatter = new \NumberFormatter($localeToUse, \NumberFormatter::CURRENCY);

		$currencyToUse = !empty($currency) ? $currency : $this->currency;
		if (empty($currencyToUse)) {
			throw new \InvalidArgumentException('No currency has been set.');
		}

		$result = $formatter->formatCurrency($value, $currencyToUse);
		if ($result === false) {
			throw new \InvalidArgumentException(sprintf('The value "%s" of type %s cannot be formatted.', $value, gettype($value)));
		}

		return $result;
	}

}
