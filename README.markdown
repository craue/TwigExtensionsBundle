## Information

TwigExtensionsBundle is just a collection of Twig Extensions i find useful.

 - FormatDateTimeExtension provides filters for locale-aware formatting of date, time, and date/time values.

## Installation

### Add TwigExtensionsBundle to your vendor/Craue directory

	git submodule add git://github.com/craue/TwigExtensionsBundle.git vendor/Craue/TwigExtensionsBundle

### Add TwigExtensionsBundle to your application kernel

	// app/AppKernel.php
	public function registerBundles() {
		$bundles = array(
			// ...
			new Craue\TwigExtensionsBundle\CraueTwigExtensionsBundle(),
		);
		// ...
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

	<h2>with default locale</h2>
	date: {{ someDateTimeVariable | craue_date }}<br/>
	time: {{ someDateTimeVariable | craue_time }}<br/>
	both: {{ someDateTimeVariable | craue_datetime }}
	<h2>with specific locales</h2>
	date: {{ someDateTimeVariable | craue_date('de-DE') }}<br/>
	time: {{ someDateTimeVariable | craue_time('de') }}<br/>
	both: {{ someDateTimeVariable | craue_datetime('en-GB') }}

### Override default values

	; parameters.ini
	locale="de-DE"
	craue_twig_extensions.formatDateTime.datetype="full"
	craue_twig_extensions.formatDateTime.timetype="short"
	; Prefix can be empty but be aware that this will override the default date filter.
	; craue_twig_extensions.formatDateTime.prefix=""
