<?php

namespace Craue\TwigExtensionsBundle\Twig\Extension;

/**
 * Twig extension providing useful string handling filters.
 *
 * @author Christian Raue <christian.raue@gmail.com>
 * @copyright 2011 Christian Raue
 * @license http://www.opensource.org/licenses/mit-license.php MIT License
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
	 * @var string
	 */
	protected $substrAlias = null;

	/**
	 * @param string $trailingDotAlias Alias for the trailingDot filter.
	 * @param string $substrAlias Alias for the substr filter.
	 */
	public function setAliases($trailingDotAlias = null, $substrAlias = null) {
		if (!empty($trailingDotAlias)) {
			$this->trailingDotAlias = $trailingDotAlias;
		}
		if (!empty($substrAlias)) {
			$this->substrAlias = $substrAlias;
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
	 * {@inheritDoc}
	 */
	public function getFunctions() {
		$functions = array();

		$substrFunction = new \Twig_Function_Function('substr');
		$functions['craue_substr'] = $substrFunction;
		if (!empty($this->substrAlias)) {
			$functions[$this->substrAlias] = $substrFunction;
		}

		return $functions;
	}

	/**
	 * This will NOT remove any trailing dots, i.e. won't change "There must be something more...".
	 * @param string $value Text possibly containing a trailing dot.
	 * @return string Text with trailing dot added if there was none before.
	 */
	public function addTrailingDot($value) {
		if (!is_string($value)) {
			throw new \Twig_Error_Runtime('The filter can be applied to strings only.');
		}
		if (strrpos($value, $this->dot) + strlen($this->dot) !== strlen($value)) {
			$value .= $this->dot;
		}
		return $value;
	}

}
