<?php

namespace Craue\TwigExtensionsBundle\Util;

/**
 * for internal use only
 *
 * @author Christian Raue <christian.raue@gmail.com>
 * @copyright 2011-2017 Christian Raue
 * @license http://opensource.org/licenses/mit-license.php MIT License
 */
abstract class TwigFeatureUtil {

	private function __construct() {}

	/**
	 * @param \Twig_ExtensionInterface $extension The extension instance implementing the filters.
	 * @param TwigFeatureDefinition[] $definitions
	 * @return \Twig_SimpleFilter[]|\Twig_Filter_Method[]
	 */
	public static function getTwigFilters($extension, array $definitions) {
		return self::getTwigFeatures($extension, $definitions, 'Twig_SimpleFilter', 'Twig_Filter_Method');
	}

	/**
	 * @param \Twig_ExtensionInterface $extension The extension instance implementing the functions.
	 * @param TwigFeatureDefinition[] $definitions
	 * @return \Twig_SimpleFunction[]|\Twig_Function_Method[]
	 */
	public static function getTwigFunctions($extension, array $definitions) {
		return self::getTwigFeatures($extension, $definitions, 'Twig_SimpleFunction', 'Twig_Function_Method');
	}

	/**
	 * @param \Twig_ExtensionInterface $extension The extension instance implementing the features.
	 * @param TwigFeatureDefinition[] $definitions
	 * @param string $featureClass FQCN
	 * @param string $legacyFeatureClass FQCN
	 * @return $featureClass[]|$legacyFeatureClass[]
	 */
	private static function getTwigFeatures($extension, array $definitions, $featureClass, $legacyFeatureClass) {
		$features = array();
		$isLegacyTwig = version_compare(\Twig_Environment::VERSION, '1.12', '<');

		foreach ($definitions as $definition) {
			$names = array($definition->name);
			if (!empty($definition->alias)) {
				$names[] = $definition->alias;
			}

			foreach ($names as $name) {
				if ($isLegacyTwig) {
					$features[$name] = new $legacyFeatureClass($extension, $definition->methodName, $definition->options);
					continue;
				}
				$features[] = new $featureClass($name, array($extension, $definition->methodName), $definition->options);
			}
		}

		return $features;
	}

}
