<?php

namespace Craue\TwigExtensionsBundle\Util;

/**
 * for internal use only
 * @internal
 *
 * @author Christian Raue <christian.raue@gmail.com>
 * @copyright 2011-2019 Christian Raue
 * @license http://opensource.org/licenses/mit-license.php MIT License
 */
abstract class TwigFeatureUtil {

	private function __construct() {}

	/**
	 * @param \Twig_ExtensionInterface $extension The extension instance implementing the filters.
	 * @param TwigFeatureDefinition[] $definitions
	 * @return \Twig_SimpleFilter[]
	 */
	public static function getTwigFilters($extension, array $definitions) {
		return self::getTwigFeatures($extension, $definitions, 'Twig_SimpleFilter');
	}

	/**
	 * @param \Twig_ExtensionInterface $extension The extension instance implementing the functions.
	 * @param TwigFeatureDefinition[] $definitions
	 * @return \Twig_SimpleFunction[]
	 */
	public static function getTwigFunctions($extension, array $definitions) {
		return self::getTwigFeatures($extension, $definitions, 'Twig_SimpleFunction');
	}

	/**
	 * @param \Twig_ExtensionInterface $extension The extension instance implementing the features.
	 * @param TwigFeatureDefinition[] $definitions
	 * @param string $featureClass FQCN
	 * @return $featureClass[]
	 */
	private static function getTwigFeatures($extension, array $definitions, $featureClass) {
		$features = [];

		foreach ($definitions as $definition) {
			$names = [$definition->name];
			if (!empty($definition->alias)) {
				$names[] = $definition->alias;
			}

			foreach ($names as $name) {
				$features[] = new $featureClass($name, [$extension, $definition->methodName], $definition->options);
			}
		}

		return $features;
	}

}
