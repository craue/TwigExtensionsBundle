<?php

require __DIR__.'/../vendor/autoload.php';

spl_autoload_register(function($class) {
	if (strpos($class, 'Craue\\TwigExtensionsBundle\\') === 0) {
		$path = __DIR__.'/../'.implode('/', array_slice(explode('\\', $class), 2)).'.php';

		if (!stream_resolve_include_path($path)) {
		    return false;
		}

		require_once $path;

		return true;
	}
});
