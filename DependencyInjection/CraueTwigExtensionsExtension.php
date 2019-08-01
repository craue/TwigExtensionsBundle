<?php

namespace Craue\TwigExtensionsBundle\DependencyInjection;

use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Extension\Extension;
use Symfony\Component\DependencyInjection\Loader\XmlFileLoader;

/**
 * Registration of the bundle via DI.
 *
 * @author Christian Raue <christian.raue@gmail.com>
 * @copyright 2011-2019 Christian Raue
 * @license http://opensource.org/licenses/mit-license.php MIT License
 */
class CraueTwigExtensionsExtension extends Extension {

	/**
	 * {@inheritDoc}
	 */
	public function load(array $configs, ContainerBuilder $container) {
		$config = $this->processConfiguration(new Configuration(), $configs);

		$loader = new XmlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));

		$availableExtensions = [
			'ArrayHelperExtension',
			'ChangeLanguageExtension',
			'DecorateEmptyValueExtension',
			'FormatDateTimeExtension',
			'FormatNumberExtension',
			'FormExtension',
			'StringHelperExtension',
		];

		if (!empty($config['enable_only'])) {
			$loadExtensions = [];
			foreach ($config['enable_only'] as $ext) {
				if (!in_array($ext, $availableExtensions, true)) {
					throw new \InvalidArgumentException(sprintf('Extension with name "%s" is invalid.', $ext));
				}
				$loadExtensions[] = $ext;
			}
		} else {
			$loadExtensions = $availableExtensions;
		}

		foreach ($loadExtensions as $ext) {
			$loader->load(sprintf('twig/%s.xml', $ext));
		}
	}

}
