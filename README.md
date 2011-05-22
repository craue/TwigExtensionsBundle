# Information

TwigExtensionsBundle is just a collection of Twig Extensions i find useful.

### DecorateEmptyValueExtension

Provides an enhanced "default" filter to decorate empty values with a placeholder which can be even an HTML entity.

Usually, if you want to use HTML, e.g. "&mdash;", as value for the default filter in an HTML Twig template you have to
do cumbersome {{ somevalue | e | default('&mdash;') | raw }} to make it render properly. With this extension you can
write {{ somevalue | craue_default }} instead.

### FormatDateTimeExtension

Provides filters for locale-aware formatting of date, time, and date/time values.

# Installation

## Add TwigExtensionsBundle to your vendor/Craue directory

	git submodule add git://github.com/craue/TwigExtensionsBundle.git vendor/Craue/TwigExtensionsBundle

## Add TwigExtensionsBundle to your application kernel

	// app/AppKernel.php
	public function registerBundles() {
		$bundles = array(
			// ...
			new Craue\TwigExtensionsBundle\CraueTwigExtensionsBundle(),
		);
		// ...
	}

## Register the Craue namespace

	// app/autoload.php
	$loader->registerNamespaces(array(
		// ...
		'Craue' => __DIR__.'/../vendor',
	));

## Make the Twig Extensions available by updating your configuration

	// app/config/config.yml
	craue_twig_extensions: ~

# Examples to use the filters in your Twig template

## DecorateEmptyValueExtension

	{{ someValueWhichMayBeEmpty | craue_default }}<br />
	{{ someValueWhichMayBeEmpty | craue_default('no value') }}<br />
	{{ someValueWhichMayBeEmpty | craue_default('&ndash;') }}<br />
	{{ someValueWhichMayBeEmpty | craue_default(0) }}

## FormatDateTimeExtension

	<h2>with default locale</h2>
	date: {{ someDateTimeVariable | craue_date }}<br />
	time: {{ someDateTimeVariable | craue_time }}<br />
	both: {{ someDateTimeVariable | craue_datetime }}

	<h2>with specific locales</h2>
	date: {{ someDateTimeVariable | craue_date('de-DE') }}<br />
	time: {{ someDateTimeVariable | craue_time('de') }}<br />
	both: {{ someDateTimeVariable | craue_datetime('en-GB') }}

# Set/override default values

## DecorateEmptyValueExtension

	; app/config/parameters.ini
	craue_twig_extensions.decorateEmptyValue.placeholder="&ndash;"

## FormatDateTimeExtension

	; app/config/parameters.ini
	locale="de-DE"
	craue_twig_extensions.formatDateTime.datetype="full"
	craue_twig_extensions.formatDateTime.timetype="short"

## Advanced stuff

### DecorateEmptyValueExtension

#### Alias

You can define an alias for the filter if you don't like to write

	{{ somevalue | craue_default }}

all the time. Setting this to "d" for example with

	; app/config/parameters.ini
	craue_twig_extensions.decorateEmptyValue.filterAlias="d"

allows you to write

	{{ somevalue | d }}

in your Twig Template. But pay attention to not accidentally override built-in filters, although you can do it
intentionally, e.g. by setting the alias to "default".

### FormatDateTimeExtension

#### Aliases

Similar to the DecorateEmptyValueExtension you can define aliases for each filter:

	; app/config/parameters.ini
	craue_twig_extensions.formatDateTime.dateFilterAlias="date"
	craue_twig_extensions.formatDateTime.timeFilterAlias="time"
	craue_twig_extensions.formatDateTime.dateTimeFilterAlias="datetime"

But, again, pay attention to not accidentally override built-in filters, although you can do it
intentionally, e.g. by setting the dateFilterAlias to "date".
