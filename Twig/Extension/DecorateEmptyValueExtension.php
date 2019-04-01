<?php

namespace Craue\TwigExtensionsBundle\Twig\Extension;

use Craue\TwigExtensionsBundle\Util\TwigFeatureDefinition;
use Craue\TwigExtensionsBundle\Util\TwigFeatureUtil;
use Twig\Extension\AbstractExtension;

/**
 * Twig extension providing an enhanced "default" filter to decorate empty values with a placeholder which can even be
 * an HTML entity.
 *
 * @author Christian Raue <christian.raue@gmail.com>
 * @copyright 2011-2019 Christian Raue
 * @license http://opensource.org/licenses/mit-license.php MIT License
 */
class DecorateEmptyValueExtension extends AbstractExtension {

	/**
	 * @var string
	 */
	protected $placeholder = '&mdash;';

	/**
	 * @var string
	 */
	protected $filterAlias = null;

	/**
	 * @param mixed $placeholder Placeholder to use instead of empty values.
	 */
	public function setPlaceholder($placeholder = null) {
		if ($placeholder !== null) {
			$this->placeholder = $placeholder;
		}
	}

	/**
	 * @param string $filterAlias Alias for the filter.
	 */
	public function setAlias($filterAlias = null) {
		if (!empty($filterAlias)) {
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
		return TwigFeatureUtil::getTwigFilters($this, [
			new TwigFeatureDefinition('craue_default', 'decorateEmptyValue', $this->filterAlias, [
				'pre_escape' => 'html',
				'is_safe' => ['html'],
			]),
		]);
	}

	/**
	 * @param mixed $value Value to be replaced with {@code $placeholder} if it's empty.
	 * @param mixed $placeholder Placeholder to use instead of an empty value.
	 * @return string {@code $value} or, if it's empty, {@code $placeholder}.
	 */
	public function decorateEmptyValue($value, $placeholder = null) {
		$placeholderToUse = $placeholder ?? $this->placeholder;
		return twig_test_empty($value) ? $placeholderToUse : $value;
	}

}
