<?php

namespace Craue\TwigExtensionsBundle\Tests;

use Symfony\Component\Config\Loader\LoaderInterface;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\HttpKernel\Kernel;

class AppKernel extends Kernel {

	private $config;

	public function __construct($config) {
		parent::__construct('test', true);

		$fs = new Filesystem();
		if (!$fs->isAbsolutePath($config)) {
			$config = __DIR__.'/config/'.$config;
		}

		if (!file_exists($config)) {
			throw new \RuntimeException(sprintf('The config file "%s" does not exist.', $config));
		}

		$this->config = $config;
	}

	public function registerBundles() : iterable {
		return [
			new \Symfony\Bundle\FrameworkBundle\FrameworkBundle(),
			new \Symfony\Bundle\TwigBundle\TwigBundle(),
			new \Craue\TwigExtensionsBundle\CraueTwigExtensionsBundle(),
			new \Craue\TwigExtensionsBundle\Tests\IntegrationTestBundle\IntegrationTestBundle(),
		];
	}

	public function registerContainerConfiguration(LoaderInterface $loader) {
		$loader->load($this->config);
	}

	public function getCacheDir() : string {
		if (array_key_exists('CACHE_DIR', $_ENV)) {
			return $_ENV['CACHE_DIR'] . DIRECTORY_SEPARATOR . $this->environment;
		}

		return parent::getCacheDir();
	}

	public function getLogDir() : string {
		if (array_key_exists('LOG_DIR', $_ENV)) {
			return $_ENV['LOG_DIR'] . DIRECTORY_SEPARATOR . $this->environment;
		}

		return parent::getLogDir();
	}

	public function serialize() {
		return $this->config;
	}

	public function unserialize($config) {
		$this->__construct($config);
	}

}
