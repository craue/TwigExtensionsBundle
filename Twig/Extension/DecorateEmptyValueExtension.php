<?php

namespace Craue\TwigExtensionsBundle\Twig\Extension;

/**
 * Twig Extension providing an enhanced "default" filter to decorate empty values with a placeholder which can even be
 * an HTML entity.
 * @author Christian Raue <christian.raue@gmail.com>
 */
class DecorateEmptyValueExtension extends \Twig_Extension {

	protected $placeholder = '&mdash;';

	protected $filterAlias = null;

	/**
	 * @param mixed $placeholder Placeholder to use instead of empty values.
	 * @param string $filterAlias Alias for the filter.
	 */
	public function __construct($placeholder = null, $filterAlias = null) {
		if ($placeholder !== null) {
			$this->placeholder = $placeholder;
		}
		if ($filterAlias !== null) {
			$this->filterAlias = $filterAlias;
		}
	}

	/**
	 * {@inheritDoc}
	 */
	public function getName() {
		return 'craue_decorateEmptyValue';
	}

	/**
	 * {@inheritDoc}
	 */
	public function getFilters() {
		$filters = array();

		$decorateEmptyValueMethod = new \Twig_Filter_Method($this, 'decorateEmptyValue', array(
			'pre_escape' => 'html',
			'is_safe' => array('html'),
		));
		$filters['craue_default'] = $decorateEmptyValueMethod;
		if ($this->filterAlias !== null) {
			$filters[$this->filterAlias] = $decorateEmptyValueMethod;
		}

		return $filters;
	}

	/**
	 * @param mixed $value Value to be replaced with {@code $placeholder} if it's empty.
	 * @param mixed $placeholder Placeholder to use instead of an empty value.
	 * @return string {@code $value} or, if it's empty, {@code $placeholder}.
	 */
	public function decorateEmptyValue($value, $placeholder = null) {
		$placeholderToUse = $placeholder !== null ? $placeholder : $this->placeholder;
		return twig_test_empty($value) ? $placeholderToUse : $value;
	}

}
