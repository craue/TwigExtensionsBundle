<?php

namespace Craue\TwigExtensionsBundle\Util;

use Twig\Extension\ExtensionInterface;
use Twig\TwigFilter;
use Twig\TwigFunction;

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
	 * @param ExtensionInterface $extension The extension instance implementing the filters.
	 * @param TwigFeatureDefinition[] $definitions
	 * @return TwigFilter[]
	 */
	public static function getTwigFilters($extension, array $definitions) {
		return self::getTwigFeatures($extension, $definitions, TwigFilter::class);
	}

	/**
	 * @param ExtensionInterface $extension The extension instance implementing the functions.
	 * @param TwigFeatureDefinition[] $definitions
	 * @return TwigFunction[]
	 */
	public static function getTwigFunctions($extension, array $definitions) {
		return self::getTwigFeatures($extension, $definitions, TwigFunction::class);
	}

	/**
	 * @param ExtensionInterface $extension The extension instance implementing the features.
	 * @param TwigFeatureDefinition[] $definitions
	 * @param string $featureClass FQCN
	 * @return TwigFilter[]|TwigFunction[] Actually an array of objects of type {@code $featureClass}.
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
