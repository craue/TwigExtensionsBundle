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

### Make the Twig functions available

	<parameters>
		<parameter key="twig.extension.formatDateTime.class">Craue\TwigExtensionsBundle\Twig\Extension\FormatDateTimeExtension</parameter>
	</parameters>

	<services>
		<service id="twig.extension.formatDateTime" class="%twig.extension.formatDateTime.class%">
			<tag name="twig.extension" />
			<argument>%locale%</argument><!-- locale -->
			<argument>medium</argument><!-- date format -->
			<argument>medium</argument><!-- time format -->
			<argument>null</argument><!-- prefix (null = keep default. Can be empty but be aware that this will override the default date filter.) -->
		</service>
	</services>

### Use the filters in your Twig template

	<ul>
		<li>date: {{ someDateTimeVariable | date }}</li>
		<li>time: {{ someDateTimeVariable | time }}</li>
		<li>both: {{ someDateTimeVariable | datetime('de-DE') }}</li>
	</ul>
