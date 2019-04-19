<?php

namespace Craue\TwigExtensionsBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * Semantic bundle configuration.
 *
 * @author Christian Raue <christian.raue@gmail.com>
 * @copyright 2011-2019 Christian Raue
 * @license http://opensource.org/licenses/mit-license.php MIT License
 */
class Configuration implements ConfigurationInterface {

	/**
	 * {@inheritDoc}
	 */
	public function getConfigTreeBuilder() {
		$treeBuilder = new TreeBuilder('craue_twig_extensions');

		if (!method_exists($treeBuilder, 'getRootNode')) {
			// TODO remove as soon as Symfony >= 4.2 is required
			$rootNode = $treeBuilder->root('craue_twig_extensions');
		} else {
			$rootNode = $treeBuilder->getRootNode();
		}

		$rootNode
			->children()
				->arrayNode('enable_only')
					->prototype('scalar')->end()
					->defaultValue([])
				->end()
			->end()
		;

		return $treeBuilder;
	}

}
