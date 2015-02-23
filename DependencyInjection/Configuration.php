<?php

namespace Craue\TwigExtensionsBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * Semantic bundle configuration.
 *
 * @author Christian Raue <christian.raue@gmail.com>
 * @copyright 2011-2015 Christian Raue
 * @license http://opensource.org/licenses/mit-license.php MIT License
 */
class Configuration implements ConfigurationInterface {

	/**
	 * {@inheritDoc}
	 */
	public function getConfigTreeBuilder() {
		$treeBuilder = new TreeBuilder();
		$rootNode = $treeBuilder->root('craue_twig_extensions');

		$rootNode
			->children()
				->arrayNode('enable_only')
					->prototype('scalar')->end()
					->defaultValue(array())
				->end()
			->end()
		;

		return $treeBuilder;
	}

}
