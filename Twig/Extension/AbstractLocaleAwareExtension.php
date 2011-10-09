<?php

namespace Craue\TwigExtensionsBundle\Twig\Extension;

use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\Request;

/**
 * Common base class for Twig extensions dealing with the current locale.
 *
 * @author Christian Raue <christian.raue@gmail.com>
 * @copyright 2011 Christian Raue
 * @license http://www.opensource.org/licenses/mit-license.php MIT License
 */
abstract class AbstractLocaleAwareExtension extends \Twig_Extension {

	/**
	 * @var string
	 */
	protected $locale = 'en-US';

	/**
	 * @param mixed $requestOrServiceContainer Can be a locale string, the request, or the service container.
	 */
	public function setCurrentLocale($value) {
		if ($value === null) {
			return;
		}

		if (is_string($value)) {
			$this->locale = $value;
			return;
		}

		if ($value instanceof ContainerInterface && $value->isScopeActive('request') && $value->has('request')) {
			$value = $value->get('request');
		}

		if ($value instanceof Request) {
			$this->locale = $value->getLocale();
		}
	}

	/**
	 * @return string
	 */
	public function getLocale() {
		return $this->locale;
	}

}
