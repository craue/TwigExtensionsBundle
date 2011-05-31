# Information

TwigExtensionsBundle is just a collection of Twig extensions i find useful.

## DecorateEmptyValueExtension

Provides an enhanced "default" filter to decorate empty values with a placeholder which can even be HTML.

Usually, if you want to use HTML, e.g. the HTML entity "&mdash;", as value for the default filter in an HTML Twig
template you have to do cumbersome

	{{ somevalue | e | default('&mdash;') | raw }}

to make it render properly. With this extension you can write

	{{ somevalue | craue_default }}

instead.

## FormatDateTimeExtension

Provides filters for locale-aware formatting of date, time, and date/time values.

## ChangeLanguageExtension

Providing helpers for implementing a language change mechanism and handling localized routes.

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

## Make the Twig extensions available by updating your configuration

	// app/config/config.yml
	craue_twig_extensions: ~

# Examples to use the extensions in your Twig template

## DecorateEmptyValueExtension

	{{ someValueWhichMayBeEmpty | craue_default }}<br />
	{{ someValueWhichMayBeEmpty | craue_default('no value') }}<br />
	{{ someValueWhichMayBeEmpty | craue_default('&ndash;') }}<br />
	{{ someValueWhichMayBeEmpty | craue_default(0) }}

## FormatDateTimeExtension

	<h2>with current locale</h2>
	date: {{ someDateTimeValue | craue_date }}<br />
	time: {{ someDateTimeValue | craue_time }}<br />
	both: {{ someDateTimeValue | craue_datetime }}

	<h2>with specific locales</h2>
	date: {{ someDateTimeValue | craue_date('de-DE') }}<br />
	time: {{ someDateTimeValue | craue_time('de') }}<br />
	both: {{ someDateTimeValue | craue_datetime('en-GB') }}

## ChangeLanguageExtension

Rendering links for some kind of "change language" menu:

	<ul>
		{% for locale in craue_availableLocales %}
			<li>
				{% if locale == app.session.locale %}
					{{ craue_languageName(locale) }}
				{% else %}
					<a href="{{ path(app.request.attributes.get('_route'), app.request.attributes.all
							| craue_cleanRouteParameters | merge({'_locale': locale})) }}"
						>{{ craue_languageName(locale) }}</a>
				{% endif %}
			</li>
		{% endfor %}
	</ul>

Additionally, instead of

	<a href="{{ path('route', {'_locale': app.session.locale}) }}">text</a>

you can use

	<a href="{{ craue_localizedPath('route') }}">text</a>

to build links containing the current locale.

# Set/override default values

## DecorateEmptyValueExtension

	; app/config/parameters.ini
	craue_twig_extensions.decorateEmptyValue.placeholder="&ndash;"

## FormatDateTimeExtension

	; app/config/parameters.ini
	craue_twig_extensions.formatDateTime.datetype="full"
	craue_twig_extensions.formatDateTime.timetype="short"

## ChangeLanguageExtension

	; app/config/parameters.ini
	craue_twig_extensions.changeLanguage.availableLocales[]="de"
	craue_twig_extensions.changeLanguage.availableLocales[]="en"
	craue_twig_extensions.changeLanguage.availableLocales[]="ru"
	craue_twig_extensions.changeLanguage.showForeignLanguageNames=true
	craue_twig_extensions.changeLanguage.showFirstUppercase=false

With XML for example you can also set the keys to be more specific about the locales:

	<parameter key="craue_twig_extensions.changeLanguage.availableLocales" type="collection">
		<parameter key="de_DE">de</parameter>
		<parameter key="en">en</parameter>
		<parameter key="ru">ru</parameter>
	</parameter>

# Advanced stuff

## DecorateEmptyValueExtension

### Alias

You can define an alias for the filter if you don't like to write

	{{ somevalue | craue_default }}

all the time. Setting this to "d" for example with

	; app/config/parameters.ini
	craue_twig_extensions.decorateEmptyValue.filterAlias="d"

allows you to write

	{{ somevalue | d }}

in your Twig Template. But pay attention to not accidentally override built-in filters, although you can do it
intentionally, e.g. by setting the alias to "default".

## FormatDateTimeExtension

### Aliases

Similar to the DecorateEmptyValueExtension you can define an alias for each filter:

	; app/config/parameters.ini
	craue_twig_extensions.formatDateTime.dateFilterAlias="date"
	craue_twig_extensions.formatDateTime.timeFilterAlias="time"
	craue_twig_extensions.formatDateTime.dateTimeFilterAlias="datetime"

But, again, pay attention to not accidentally override built-in filters, although you can do it intentionally, e.g. by
setting the dateFilterAlias to "date".

## ChangeLanguageExtension

Again, you can define aliases:

	; app/config/parameters.ini
	craue_twig_extensions.changeLanguage.languageNameAlias=
	craue_twig_extensions.changeLanguage.localizedPathAlias="path"
	craue_twig_extensions.changeLanguage.cleanRouteParametersAlias=
	craue_twig_extensions.changeLanguage.availableLocalesAlias=

Don't accidentally override built-in filters/functions/globals, although you can do it intentionally, e.g. by setting
the localizedPathAlias to "path".
