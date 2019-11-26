<?php

namespace Craue\TwigExtensionsBundle\Twig\Extension;

use Craue\TwigExtensionsBundle\Util\TwigFeatureDefinition;
use Craue\TwigExtensionsBundle\Util\TwigFeatureUtil;
use Symfony\Component\Translation\TranslatorInterface as LegacyTranslatorInterface;
use Symfony\Contracts\Translation\TranslatorInterface;
use Twig\Extension\AbstractExtension;

/**
 * @internal
 */
abstract class BaseArrayHelperExtension extends AbstractExtension {

	/**
	 * @var TranslatorInterface|LegacyTranslatorInterface|null
	 */
	protected $translator;

	/**
	 * @var string
	 */
	protected $withoutAlias = null;

	/**
	 * @var string
	 */
	protected $replaceKeyAlias = null;

	/**
	 * @var string
	 */
	protected $removeKeyAlias = null;

	/**
	 * @var string
	 */
	protected $translateArrayAlias = null;

	/**
	 * @param string $withoutAlias Alias for the without filter.
	 * @param string $replaceKeyAlias Alias for the replaceKey filter.
	 * @param string $removeKeyAlias Alias for the removeKey filter.
	 * @param string $translateArrayAlias Alias for the translateArray filter.
	 */
	public function setAliases($withoutAlias = null, $replaceKeyAlias = null, $removeKeyAlias = null, $translateArrayAlias = null) {
		if (!empty($withoutAlias)) {
			$this->withoutAlias = $withoutAlias;
		}
		if (!empty($replaceKeyAlias)) {
			$this->replaceKeyAlias = $replaceKeyAlias;
		}
		if (!empty($removeKeyAlias)) {
			$this->removeKeyAlias = $removeKeyAlias;
		}
		if (!empty($translateArrayAlias)) {
			$this->translateArrayAlias = $translateArrayAlias;
		}
	}

	/**
	 * {@inheritDoc}
	 */
	public function getName() {
		return 'craue_arrayHelper';
	}

	/**
	 * {@inheritDoc}
	 */
	public function getFilters() {
		return TwigFeatureUtil::getTwigFilters($this, [
			new TwigFeatureDefinition('craue_without', 'without', $this->withoutAlias),
			new TwigFeatureDefinition('craue_replaceKey', 'replaceKey', $this->replaceKeyAlias),
			new TwigFeatureDefinition('craue_removeKey', 'removeKey', $this->removeKeyAlias),
			new TwigFeatureDefinition('craue_translateArray', 'translateArray', $this->translateArrayAlias),
		]);
	}

	/**
	 * @param mixed $entries All entries.
	 * @param mixed $without Entries to be removed.
	 * @return array Remaining entries of {@code $entries} after removing the entries of {@code $without}.
	 */
	public function without($entries, $without) {
		if (!is_array($without)) {
			$without = [$without];
		}

		return array_diff($this->convertToArray($entries), $without);
	}

	/**
	 * @param mixed $entries All entries.
	 * @param mixed $key Key of the entry to be merged.
	 * @param mixed $value Value of the entry to be merged.
	 * @return array Entries of {@code $entries} merged with an entry built from {@code $key} and {@code $value}.
	 */
	public function replaceKey($entries, $key, $value) {
		return array_merge($this->convertToArray($entries), [$key => $value]);
	}

	/**
	 * @param mixed $entries All entries.
	 * @param mixed $key Key of the entry to be removed.
	 * @return array Entries of {@code $entries} without the entry with key {@code $key}.
	 */
	public function removeKey($entries, $key) {
		$result = $this->convertToArray($entries);

		unset($result[$key]);

		return $result;
	}

	/**
	 * Translates all entries in an array.
	 * @param mixed $entries Entries to be translated.
	 * @param array $parameters Parameters used for translation.
	 * @param string $domain Message domain used for translation.
	 * @param string $locale Locale used for translation.
	 * @return array Translated entries.
	 * @throws \LogicException If the translator is not available.
	 */
	public function translateArray($entries, array $parameters = [], $domain = 'messages', $locale = null) {
		if ($this->translator === null) {
			throw new \LogicException('The Symfony Translation component is not available. Try running "composer require symfony/translation".');
		}

		$translatedEntries = [];

		foreach ($this->convertToArray($entries) as $entry) {
			$translatedEntries[] = $this->translator->trans($entry, $parameters, $domain, $locale);
		}

		return $translatedEntries;
	}

	/**
	 * Tries to convert {@code $source} to an array.
	 * @param array|\Traversable $source Variable to be converted.
	 * @throws \InvalidArgumentException If no array representation is available.
	 */
	protected function convertToArray($source) {
		if (is_array($source)) {
			return $source;
		}

		if ($source instanceof \Traversable) {
			return iterator_to_array($source, true);
		}

		throw new \InvalidArgumentException('The filter can be applied to arrays only.');
	}

}

// TODO revert to one clean class definition as soon as Symfony >= 4.2 is required
if (!interface_exists(LegacyTranslatorInterface::class)) {
	/**
	 * Twig extension providing useful array handling filters.
	 *
	 * @author Christian Raue <christian.raue@gmail.com>
	 * @copyright 2011-2019 Christian Raue
	 * @license http://opensource.org/licenses/mit-license.php MIT License
	 */
	class ArrayHelperExtension extends BaseArrayHelperExtension {
		public function setTranslator(TranslatorInterface $translator) {
			$this->translator = $translator;
		}
	}
} else {
	/**
	 * Twig extension providing useful array handling filters.
	 *
	 * @author Christian Raue <christian.raue@gmail.com>
	 * @copyright 2011-2019 Christian Raue
	 * @license http://opensource.org/licenses/mit-license.php MIT License
	 */
	class ArrayHelperExtension extends BaseArrayHelperExtension {
		public function setTranslator(LegacyTranslatorInterface $translator) {
			$this->translator = $translator;
		}
	}
}
