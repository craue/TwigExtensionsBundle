<?php

namespace Craue\TwigExtensionsBundle\Twig\Extension;

use Doctrine\Common\Collections\Collection;
use Symfony\Component\Translation\TranslatorInterface;

/**
 * Twig extension providing useful array handling filters.
 *
 * @author Christian Raue <christian.raue@gmail.com>
 * @copyright 2011 Christian Raue
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
	protected $translateArrayAlias = null;

	public function setTranslator(TranslatorInterface $translator) {
		$this->translator = $translator;
	}

	/**
	 * @param string $withoutAlias Alias for the without filter.
	 * @param string $translateArrayAlias Alias for the translateArray filter.
	 */
	public function setAliases($withoutAlias = null, $translateArrayAlias = null) {
		if (!empty($withoutAlias)) {
			$this->withoutAlias = $withoutAlias;
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
	 * @return array Remaining entries of {@code $value} after removing the entries of {@code $without}.
	 */
	public function without($entries, $without) {
		if (!is_array($without)) {
			$without = array($without);
		}

		return array_diff($this->convertToArray($entries), $without);
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
	 * @param mixed $source Variable to be converted.
	 * @throws \Twig_Error_Runtime If no array representation is available.
	 */
	protected function convertToArray($source) {
		if (is_array($source)) {
			return $source;
		}

		if ($source instanceof Collection) {
			return $source->toArray();
		}

		throw new \Twig_Error_Runtime('The filter can be applied to arrays only.');
	}

}
