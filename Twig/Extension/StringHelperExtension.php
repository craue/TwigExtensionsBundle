<?php

namespace Craue\TwigExtensionsBundle\Twig\Extension;

/**
 * Twig extension providing useful string handling filters.
 *
 * @author Christian Raue <christian.raue@gmail.com>
 * @copyright 2011-2014 Christian Raue
 * @license http://opensource.org/licenses/mit-license.php MIT License
 */
class StringHelperExtension extends \Twig_Extension {

	/**
	 * @var string
	 */
	protected $dot = '.';

	/**
	 * @var string
	 */
	protected $trailingDotAlias = null;

	/**
	 * @param string $trailingDotAlias Alias for the trailingDot filter.
	 */
	public function setAliases($trailingDotAlias = null) {
		if (!empty($trailingDotAlias)) {
			$this->trailingDotAlias = $trailingDotAlias;
		}
	}

	/**
	 * {@inheritDoc}
	 */
	public function getName() {
		return 'craue_stringHelper';
	}

	/**
	 * {@inheritDoc}
	 */
	public function getFilters() {
		$filters = array();

		$trailingDotMethod = new \Twig_Filter_Method($this, 'addTrailingDot');
		$filters['craue_trailingDot'] = $trailingDotMethod;
		if (!empty($this->trailingDotAlias)) {
			$filters[$this->trailingDotAlias] = $trailingDotMethod;
		}

		return $filters;
	}

	/**
	 * This will NOT remove any trailing dots, i.e. won't change "There must be something more...".
	 * @param string $value Text possibly containing a trailing dot.
	 * @return string Text with trailing dot added if there was none before.
	 * @throws \InvalidArgumentException If {@code $value} is not a string.
	 */
	public function addTrailingDot($value) {
		if (!is_string($value)) {
			throw new \InvalidArgumentException('The filter can be applied to strings only.');
		}
		if (strrpos($value, $this->dot) + strlen($this->dot) !== strlen($value)) {
			$value .= $this->dot;
		}

		return $value;
	}

}
