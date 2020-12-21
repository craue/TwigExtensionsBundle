<?php

namespace Craue\TwigExtensionsBundle\Tests;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Twig\Environment;

/**
 * @author Christian Raue <christian.raue@gmail.com>
 * @copyright 2011-2020 Christian Raue
 * @license http://opensource.org/licenses/mit-license.php MIT License
 */
abstract class TwigBasedTestCase extends WebTestCase {

	/**
	 * @var Environment
	 */
	private $twig;

	protected static function createKernel(array $options = []) {
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
	protected function getService($id) {
		// TODO remove as soon as Symfony >= 4.3 is required
		if (!property_exists($this, 'container')) {
			return static::$kernel->getContainer()->get($id);
		}

		return self::$container->get($id);
	}

	/**
	 * @return Environment
	 */
	protected function getTwig() {
		return $this->twig;
	}

}
