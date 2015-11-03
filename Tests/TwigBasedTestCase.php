<?php

namespace Craue\TwigExtensionsBundle\Tests;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Kernel;

/**
 * @author Christian Raue <christian.raue@gmail.com>
 * @copyright 2011-2015 Christian Raue
 * @license http://opensource.org/licenses/mit-license.php MIT License
 */
abstract class TwigBasedTestCase extends WebTestCase {

	/**
	 * @var \Twig_Environment
	 */
	protected $twig;

	protected static function createKernel(array $options = array()) {
		$defaultConfigFile = Kernel::VERSION_ID < 20400 ? 'legacy_config.yml' : 'current_config.yml';
		$configFile = isset($options['config']) ? $options['config'] : $defaultConfigFile;

		return new AppKernel($configFile);
	}

	protected function setUp() {
		static::createClient();
		$this->twig = self::$kernel->getContainer()->get('twig');
		$this->fakeRequest();
	}

	protected function getTwig() {
		return $this->twig;
	}

	private function fakeRequest() {
		$container = self::$kernel->getContainer();
		$request = new Request();

		if ($container->has('request_stack')) {
			$container->get('request_stack')->push($request);
		} else {
			$container->set('request', $request); // for Symfony < 2.4
		}
	}

}
