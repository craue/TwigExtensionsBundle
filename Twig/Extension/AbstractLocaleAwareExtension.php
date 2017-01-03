<?php

namespace Craue\TwigExtensionsBundle\Twig\Extension;

use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Common base class for Twig extensions dealing with the current locale.
 *
 * @author Christian Raue <christian.raue@gmail.com>
 * @copyright 2011-2017 Christian Raue
 * @license http://opensource.org/licenses/mit-license.php MIT License
 */
abstract class AbstractLocaleAwareExtension extends \Twig_Extension {

	/**
	 * @var string
	 */
	protected $locale = 'en-US';

	/**
	 * @var ContainerInterface
	 */
	protected $container;

	/**
	 * @param mixed $value The service container or a locale string.
	 * @throws \InvalidArgumentException
	 */
	public function setLocale($value) {
		if ($value === null) {
			return;
		}

		if (is_string($value)) {
			$this->locale = $value;
			return;
		}

		if ($value instanceof ContainerInterface) {
			$this->container = $value;
			return;
		}

		throw new \InvalidArgumentException(sprintf(
				'Expected argument of either type "string" or "%s", but "%s" given.',
				'Symfony\Component\DependencyInjection\ContainerInterface',
				is_object($value) ? get_class($value) : gettype($value)
		));
	}

	/**
	 * @return string
	 */
	public function getLocale() {
		if ($this->container !== null) {
			if ($this->container->has('request_stack')) {
				return $this->container->get('request_stack')->getCurrentRequest()->getLocale();
			}

			if ($this->container->isScopeActive('request')) {
				return $this->container->get('request')->getLocale();
			}
		}

		return $this->locale;
	}

}
