<?php

namespace Craue\TwigExtensionsBundle\Tests;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpKernel\Kernel;

/**
 * @author Christian Raue <christian.raue@gmail.com>
 * @copyright 2011-2013 Christian Raue
 * @license http://www.opensource.org/licenses/mit-license.php MIT License
 */
abstract class TwigBasedTestCase extends WebTestCase {

	/**
	 * @var \Twig_Environment
	 */
	protected $twig;

	protected static function createKernel(array $options = array()) {
		$configFile = 'config.yml';

		// https://github.com/symfony/symfony/issues/9429
		if (version_compare(Kernel::VERSION, '2.4', '>=')) {
			$configFile = 'config_symfony_2.4.yml';
		}

		return new AppKernel(isset($options['config']) ? $options['config'] : $configFile);
	}

	protected function setUp() {
		static::createClient();
		$this->twig = self::$kernel->getContainer()->get('twig');
	}

	protected function getTwig() {
		return $this->twig;
	}

}
