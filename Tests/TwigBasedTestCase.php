<?php

namespace Craue\TwigExtensionsBundle\Tests;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpKernel\KernelInterface;
use Twig\Environment;

/**
 * @author Christian Raue <christian.raue@gmail.com>
 * @copyright 2011-2022 Christian Raue
 * @license http://opensource.org/licenses/mit-license.php MIT License
 */
abstract class TwigBasedTestCase extends WebTestCase {

	/**
	 * @var Environment
	 */
	private $twig;

	protected static function createKernel(array $options = []) : KernelInterface {
		$configFile = $options['config'] ?? 'config.yml';

		return new AppKernel($configFile);
	}

	protected function setUp() : void {
		static::createClient();
		$this->twig = $this->getService('twig.test');
	}

	/**
	 * @param string $id The service identifier.
	 * @return object The associated service.
	 */
	protected function getService(string $id) : object {
		if (\method_exists($this, 'getContainer')) {
			return $this->getContainer()->get($id);
		} else {
			// TODO remove as soon as Symfony >= 5.3 is required
			return self::$container->get($id);
		}
	}

	/**
	 * @return Environment
	 */
	protected function getTwig() {
		return $this->twig;
	}

}
