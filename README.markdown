## Information

TwigExtensionsBundle is just a collection of Twig Extensions i find useful.

## Installation

### Add TwigExtensionsBundle to your vendor/Craue directory

	git submodule add git://github.com/craue/TwigExtensionsBundle.git vendor/Craue/TwigExtensionsBundle

### Add TwigExtensionsBundle to your application kernel

	// app/AppKernel.php
	public function registerBundles() {
		return array(
			// ...
			new Craue\TwigExtensionsBundle\CraueTwigExtensionsBundle(),
		);
	}

### Register the Craue namespace

	// app/autoload.php
	$loader->registerNamespaces(array(
		// ...
		'Craue' => __DIR__.'/../vendor',
	));

### Make the Twig Extension available by updating your configuration

    // app/config/config.yml
    craue_twig_extensions: ~

### Use the filters in your Twig template

	<ul>
		<li>date: {{ someDateTimeVariable | date }}</li>
		<li>time: {{ someDateTimeVariable | time }}</li>
		<li>both: {{ someDateTimeVariable | datetime('de-DE') }}</li>
	</ul>
