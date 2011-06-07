<?php

namespace Craue\TwigExtensionsBundle\Twig\Extension;

use Doctrine\Common\Collections\Collection;

/**
 * Twig extension providing useful array handling filters.
 *
 * @author Christian Raue <christian.raue@gmail.com>
 * @copyright 2011 Christian Raue
 * @license http://www.opensource.org/licenses/mit-license.php MIT License
 */
class ArrayHelperExtension extends \Twig_Extension {

	/**
	 * @var string
	 */
	protected $withoutAlias = null;

	/**
	 * @param string $withoutAlias Alias for the without filter.
	 */
	public function setAlias($withoutAlias = null) {
		if (!empty($withoutAlias)) {
			$this->withoutAlias = $withoutAlias;
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

		return $filters;
	}

	/**
	 * @param mixed $entries All entries.
	 * @param mixed $without Entries to be removed.
	 * @return array Remaining entries of {@code $value} after removing the entries of {@code $without}.
	 */
	public function without($entries, $without) {
		if ($entries instanceof Collection) {
			$entries = $entries->toArray();
		}
		if (!is_array($entries)) {
			throw new \Twig_Error_Runtime('The filter can be applied to arrays only.');
		}

		if (!is_array($without)) {
			$without = array($without);
		}

		return array_diff($entries, $without);
	}

}
