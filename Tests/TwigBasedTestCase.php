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

	protected function setUp() {
		static::createClient();
		$this->twig = self::$kernel->getContainer()->get('twig');
	}

	protected function getTwig() {
		return $this->twig;
	}

}
