<?php

namespace Craue\TwigExtensionsBundle\Twig\Extension;

use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\RequestStack;
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
	 * @var ContainerInterface|null
	 */
	protected $container;

	/**
	 * @var RequestStack|null
	 */
	private $requestStack;

	/**
	 * @param mixed $value The request stack, the service container or a locale string.
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

		if ($value instanceof RequestStack) {
			$this->requestStack = $value;
			return;
		}

		if ($value instanceof ContainerInterface) {
			@trigger_error(sprintf('Passing the service container to "%s" is deprecated. Instead, pass either the request stack or a locale string.', __METHOD__), E_USER_DEPRECATED);
			$this->container = $value;
			return;
		}

		throw new \InvalidArgumentException(sprintf(
				'Expected argument of either type "string", "%s", or "%s", but "%s" given.',
				RequestStack::class,
				ContainerInterface::class,
				is_object($value) ? get_class($value) : gettype($value)
		));
	}

	/**
	 * @return string
	 */
	public function getLocale() {
		if ($this->container !== null) {
			$this->requestStack = $this->container->get('request_stack');
		}

		if ($this->requestStack !== null) {
			$currentRequest = $this->requestStack->getCurrentRequest();
			if ($currentRequest !== null) {
				return $currentRequest->getLocale();
			}
		}

		return $this->locale;
	}

}
