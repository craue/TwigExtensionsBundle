<?php

namespace Craue\TwigExtensionsBundle\Twig\Extension;

use Symfony\Component\DependencyInjection\ContainerInterface;
use Twig\Extension\AbstractExtension;

/**
 * Common base class for Twig extensions dealing with the current locale.
 *
 * @author Christian Raue <christian.raue@gmail.com>
 * @copyright 2011-2019 Christian Raue
 * @license http://opensource.org/licenses/mit-license.php MIT License
 */
abstract class AbstractLocaleAwareExtension extends AbstractExtension {

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
				ContainerInterface::class,
				is_object($value) ? get_class($value) : gettype($value)
		));
	}

	/**
	 * @return string
	 */
	public function getLocale() {
		if ($this->container !== null) {
			$currentRequest = $this->container->get('request_stack')->getCurrentRequest();
			if ($currentRequest !== null) {
				return $currentRequest->getLocale();
			}
		}

		return $this->locale;
	}

}
