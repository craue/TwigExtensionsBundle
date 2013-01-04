<?php

namespace Craue\TwigExtensionsBundle\Twig\Extension;

use Symfony\Component\Translation\TranslatorInterface;

/**
 * Twig extension providing useful array handling filters.
 *
 * @author Christian Raue <christian.raue@gmail.com>
 * @copyright 2011-2013 Christian Raue
 * @license http://www.opensource.org/licenses/mit-license.php MIT License
 */
class ArrayHelperExtension extends \Twig_Extension {

	/**
	 * @var TranslatorInterface
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
	protected $translateArrayAlias = null;

	public function setTranslator(TranslatorInterface $translator) {
		$this->translator = $translator;
	}

	/**
	 * @param string $withoutAlias Alias for the without filter.
	 * @param string $replaceKeyAlias Alias for the replaceKey filter.
	 * @param string $translateArrayAlias Alias for the translateArray filter.
	 */
	public function setAliases($withoutAlias = null, $replaceKeyAlias = null, $translateArrayAlias = null) {
		if (!empty($withoutAlias)) {
			$this->withoutAlias = $withoutAlias;
		}
		if (!empty($replaceKeyAlias)) {
			$this->replaceKeyAlias = $replaceKeyAlias;
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
		$filters = array();

		$withoutMethod = new \Twig_Filter_Method($this, 'without');
		$filters['craue_without'] = $withoutMethod;
		if (!empty($this->withoutAlias)) {
			$filters[$this->withoutAlias] = $withoutMethod;
		}

		$replaceKeyMethod = new \Twig_Filter_Method($this, 'replaceKey');
		$filters['craue_replaceKey'] = $replaceKeyMethod;
		if (!empty($this->replaceKeyAlias)) {
			$filters[$this->replaceKeyAlias] = $replaceKeyMethod;
		}

		$translateArrayMethod = new \Twig_Filter_Method($this, 'translateArray');
		$filters['craue_translateArray'] = $translateArrayMethod;
		if (!empty($this->translateArrayAlias)) {
			$filters[$this->translateArrayAlias] = $translateArrayMethod;
		}

		return $filters;
	}

	/**
	 * @param mixed $entries All entries.
	 * @param mixed $without Entries to be removed.
	 * @return array Remaining entries of {@code $entries} after removing the entries of {@code $without}.
	 */
	public function without($entries, $without) {
		if (!is_array($without)) {
			$without = array($without);
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
		return array_merge($this->convertToArray($entries), array($key => $value));
	}

	/**
	 * Translates all entries in an array.
	 * @param mixed $entries Entries to be translated.
	 * @param array $parameters Parameters used for translation.
	 * @param string $domain Message domain used for translation.
	 * @param string $locale Locale used for translation.
	 * @return array Translated entries.
	 */
	public function translateArray($entries, array $parameters = array(), $domain = 'messages', $locale = null) {
		if ($this->translator === null) {
			throw new \RuntimeException('No translator available.');
		}

		$translatedEntries = array();

		foreach ($this->convertToArray($entries) as $entry) {
			$translatedEntries[] = $this->translator->trans($entry, $parameters, $domain, $locale);
		}

		return $translatedEntries;
	}

	/**
	 * Tries to convert {@code $source} to an array.
	 * @param array|Traversable $source Variable to be converted.
	 * @throws \InvalidArgumentException If no array representation is available.
	 */
	protected function convertToArray($source) {
		if (is_array($source)) {
			return $source;
		}

		if ($source instanceof Traversable) {
			return iterator_to_array($source, true);
		}

		throw new \InvalidArgumentException('The filter can be applied to arrays only.');
	}

}
