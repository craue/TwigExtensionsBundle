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
class TwigFeatureDefinition {

	public $name;
	public $methodName;
	public $alias;
	public $options;

	public function __construct($name, $methodName, $alias = null, $options = []) {
		$this->name = $name;
		$this->methodName = $methodName;
		$this->alias = $alias;
		$this->options = $options;
	}

}
