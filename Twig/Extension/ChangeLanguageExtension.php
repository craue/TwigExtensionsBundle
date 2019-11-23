<?php

namespace Craue\TwigExtensionsBundle\Twig\Extension;

use Craue\TwigExtensionsBundle\Util\TwigFeatureDefinition;
use Craue\TwigExtensionsBundle\Util\TwigFeatureUtil;
use Twig\Environment;
use Twig\Extension\GlobalsInterface;

/**
 * @internal
 */
abstract class BaseChangeLanguageExtension extends AbstractLocaleAwareExtension implements GlobalsInterface {

	/**
	 * @var string[]
	 */
	protected $availableLocales = [];

	/**
	 * @var bool
	 */
	protected $showForeignLanguageNames = true;

	/**
	 * @var bool
	 */
	protected $showFirstUppercase = false;

	/**
	 * @var string
	 */
	protected $languageNameAlias = null;

	/**
	 * @var string
	 */
	protected $availableLocalesAlias = null;

	/**
	 * Sets the available locales.
	 * @param string[] $availableLocales
	 */
	public function setAvailableLocales(array $availableLocales = []) {
		$this->availableLocales = $availableLocales;
	}

	/**
	 * Sets whether each language's name will be shown in its foreign language.
	 * @param bool $showForeignLanguageNames
	 */
	public function setShowForeignLanguageNames($showForeignLanguageNames) {
		$this->showForeignLanguageNames = (bool) $showForeignLanguageNames;
	}

	/**
	 * Sets whether all language names will be shown with a leading uppercase character.
	 * This requires the mbstring extension {@link http://php.net/manual/book.mbstring.php} to be loaded.
	 * @param bool $showFirstUppercase
	 */
	public function setShowFirstUppercase($showFirstUppercase) {
		$this->showFirstUppercase = (bool) $showFirstUppercase;
	}

	/**
	 * @param string $languageNameAlias Alias for the languageName function.
	 * @param string $availableLocalesAlias Alias for the availableLocales global variable.
	 */
	public function setAliases($languageNameAlias = null, $availableLocalesAlias = null) {
		if (!empty($languageNameAlias)) {
			$this->languageNameAlias = $languageNameAlias;
		}
		if (!empty($availableLocalesAlias)) {
			$this->availableLocalesAlias = $availableLocalesAlias;
		}
	}

	/**
	 * {@inheritDoc}
	 */
	public function getFunctions() {
		return TwigFeatureUtil::getTwigFunctions($this, [
			new TwigFeatureDefinition('craue_languageName', 'getLanguageName', $this->languageNameAlias),
			new TwigFeatureDefinition('craue_availableLocales', 'getAvailableLocales', $this->availableLocalesAlias),
		]);
	}

	// TODO remove for 3.0
	protected function _getGlobals() {
		$globals = [];

		$globals['craue_availableLocales'] = new AvailableLocales('craue_availableLocales', $this->availableLocales);
		if (!empty($this->availableLocalesAlias)) {
			$globals[$this->availableLocalesAlias] = new AvailableLocales($this->availableLocalesAlias, $this->availableLocales);
		}

		return $globals;
	}

	/**
	 * {@inheritDoc}
	 */
	public function getName() {
		return 'craue_changeLanguage';
	}

	/**
	 * Get the corresponding language name for a locale.
	 * If the given locale contains a region code the name of that region will be appended in parentheses.
	 * @param string $locale Locale to be used with {@link http://php.net/manual/locale.getdisplayname.php}.
	 * @param string|null $forceLocaleForDisplay Locale to be used for displaying. Ignores showForeignLanguageNames.
	 * @return string|null
	 * @throws \RuntimeException If the mbstring extension is needed but not loaded.
	 */
	public function getLanguageName($locale, $forceLocaleForDisplay = null) {
		if (empty($locale)) {
			return null;
		}

		$localeToUse = !empty($forceLocaleForDisplay) ? $forceLocaleForDisplay :
				($this->showForeignLanguageNames ? $locale : $this->getLocale());

		$languageName = \Locale::getDisplayName($locale, $localeToUse);

		if ($this->showFirstUppercase) {
			if (!extension_loaded('mbstring')) {
				throw new \RuntimeException('PHP extension "mbstring" is not loaded. Either load it or disable the "showFirstUppercase" option.');
			}
			$encoding = mb_detect_encoding($languageName);
			$languageName = mb_strtoupper(mb_substr($languageName, 0, 1, $encoding), $encoding)
					.mb_substr($languageName, 1, mb_strlen($languageName, $encoding), $encoding);
		}

		return $languageName;
	}

	/**
	 * @return string[]
	 */
	public function getAvailableLocales() {
		return $this->availableLocales;
	}

}

// TODO revert to one clean class definition for 3.0
if (Environment::VERSION_ID < 30000) {
	/**
	 * Twig extension providing helpers for implementing a language change mechanism.
	 *
	 * @author Christian Raue <christian.raue@gmail.com>
	 * @copyright 2011-2019 Christian Raue
	 * @license http://opensource.org/licenses/mit-license.php MIT License
	 */
	class ChangeLanguageExtension extends BaseChangeLanguageExtension {
		public function getGlobals() {
			return $this->_getGlobals();
		}
	}
} else {
	/**
	 * Twig extension providing helpers for implementing a language change mechanism.
	 *
	 * @author Christian Raue <christian.raue@gmail.com>
	 * @copyright 2011-2019 Christian Raue
	 * @license http://opensource.org/licenses/mit-license.php MIT License
	 */
	class ChangeLanguageExtension extends BaseChangeLanguageExtension {
		public function getGlobals() : array {
			return $this->_getGlobals();
		}
	}
}

// TODO remove for 3.0
/**
 * @internal
 */
final class AvailableLocales implements \IteratorAggregate, \Countable {

	private $name;
	private $availableLocales;

	public function __construct($name, array $availableLocales) {
		$this->name = $name;
		$this->availableLocales = $availableLocales;
	}

	public function getIterator() {
		@trigger_error(sprintf('Twig global "%s" is deprecated. Use the function with the same name instead.', $this->name), E_USER_DEPRECATED);
		return new \ArrayIterator($this->availableLocales);
	}

	public function count() {
		return count($this->availableLocales);
	}

}
