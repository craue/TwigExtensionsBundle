# Information

TwigExtensionsBundle is a collection of useful Twig extensions for your Symfony project.

A live demo with code examples can is available at http://craue.de/symfony-playground/en/CraueTwigExtensions/.

## DecorateEmptyValueExtension

Provides an enhanced `default` filter, `craue_default`, to decorate empty values with a placeholder which can even be
HTML.

Usually, if you want to use HTML, e.g. the HTML entity `&mdash;`, as value for the default filter in an HTML Twig
template you have to do cumbersome

```twig
{{ somevalue | e | default('&mdash;') | raw }}
```

to make it render properly. With this extension you can write

```twig
{{ somevalue | craue_default }}
```

instead.

## ArrayHelperExtension

Provides the filters

- `craue_without` wrapping PHP's `array_diff` function,
- `craue_replaceKey` which adds/replaces an array entry (whereupon the key can be a variable),
- `craue_removeKey` which removes an array entry by key (whereupon the key can be a variable), and
- `craue_translateArray` which translates all entries in an array.

## FormExtension

Provides a mechanism to render a form several times on one page. This is done by cloning the form prior to rendering
using the `craue_cloneForm` function.

## StringHelperExtension

Provides the `craue_trailingDot` filter for ensuring that a text ends with a dot.
This comes in handy when using error messages (e.g. for validation) of vendor bundles (which are written like sentences
but are missing the trailing dots) together with your own ones (which should include the trailing dot).

## FormatDateTimeExtension

Provides the filters `craue_date`, `craue_time`, and `craue_datetime` for locale-aware formatting of date, time, and
date/time values.

## FormatNumberExtension

Provides the filters `craue_number`, `craue_currency`, and `craue_spellout` for locale-aware formatting of numbers and
currencies.

## ChangeLanguageExtension

Provides the functions `craue_languageName` and `craue_availableLocales` as well as a template for implementing a
language change mechanism.

# Installation

## Get the bundle

Let Composer download and install the bundle by running

```sh
composer require craue/twigextensions-bundle
```

in a shell.

## Enable the bundle

```php
// in app/AppKernel.php
public function registerBundles() {
	$bundles = [
		// ...
		new Craue\TwigExtensionsBundle\CraueTwigExtensionsBundle(),
	];
	// ...
}
```

# Examples to use the extensions in your Twig template

## DecorateEmptyValueExtension

```twig
{{ someValueWhichMayBeEmpty | craue_default }}<br />
{{ someValueWhichMayBeEmpty | craue_default('no value') }}<br />
{{ someValueWhichMayBeEmpty | craue_default('&ndash;') }}<br />
{{ someValueWhichMayBeEmpty | craue_default(0) }}
```

## ArrayHelperExtension

```twig
{{ anArray | craue_without(aValueOrAnArray) | join(', ') }}<br />
{{ ['red', 'green', 'yellow', 'blue'] | craue_without('yellow') | join(', ') }} will print "red, green, blue"<br />
{{ ['red', 'green', 'yellow', 'blue'] | craue_without(['yellow', 'black', 'red']) | join(', ') }} will print "green, blue"

{{ anArray | craue_replaceKey(key, value) | join(', ') }}<br />
{% set newKey = 'key3' %}
{{ {'key1': 'value1', 'key2': 'value2'} | craue_replaceKey(newKey, 'value3') | join(', ') }} will print "value1, value2, value3"

{{ anArray | craue_removeKey(key) | join(', ') }}<br />
{{ {'key1': 'value1', 'key2': 'value2'} | craue_removeKey('key1') | join(', ') }} will print "value2"

{{ anArray | craue_translateArray() | join(', ') }}<br />
```

## FormExtension

```twig
{% for myEntity in myEntities %}
	{% set myFormInstance = craue_cloneForm(myForm) %}
	<form action="{{ path('my_route', {'id': myEntity.getId()}) }}" method="post" {{ form_enctype(myFormInstance) }}>
		{{ form_widget(myFormInstance) }}
		<input type="submit" />
	</form>
{% endfor %}
```

## StringHelperExtension

```twig
{{ aString | craue_trailingDot }}<br />
{{ 'This text should end with a dot' | craue_trailingDot }}<br />
{{ 'This text should end with exactly one dot.' | craue_trailingDot }}
```

## FormatDateTimeExtension

```twig
<h2>with the current locale</h2>
date: {{ someDateTimeValue | craue_date }}<br />
time: {{ someDateTimeValue | craue_time }}<br />
both: {{ someDateTimeValue | craue_datetime }}

<h2>with a specific locale</h2>
date: {{ someDateTimeValue | craue_date('de-DE') }}<br />
time: {{ someDateTimeValue | craue_time('de') }}<br />
both: {{ someDateTimeValue | craue_datetime('en-GB') }}
```

## FormatNumberExtension

```twig
<h2>with the current locale</h2>
thousands separator: {{ someNumber | craue_number }}<br />
default currency: {{ someNumber | craue_currency }}<br />
specific currency: {{ someNumber | craue_currency('EUR') }}<br />
spelled out number: {{ someNumber | craue_spellout }}

<h2>with a specific locale</h2>
thousands separator: {{ someNumber | craue_number('de-DE') }}<br />
default currency: {{ someNumber | craue_currency(null, 'de-DE') }}<br />
specific currency: {{ someNumber | craue_currency('EUR', 'de-DE') }}<br />
spelled out number: {{ someNumber | craue_spellout('de-DE') }}
```

## ChangeLanguageExtension

There's a Twig template provided which you can use to render a "change language" menu like this:

```twig
{% include '@CraueTwigExtensions/ChangeLanguage/changeLanguage.html.twig' %}
```

This will render a list of links to the current route in all defined languages. Wrap it in a div to style it via CSS.
Take a look at the template if you want to customize it.

# Set/override default values

## DecorateEmptyValueExtension

```yaml
# in app/config/parameters.yml
  craue_twig_extensions.decorateEmptyValue.placeholder: &ndash;
```

## FormatDateTimeExtension

```yaml
# in app/config/parameters.yml
  craue_twig_extensions.formatDateTime.datetype: full
  craue_twig_extensions.formatDateTime.timetype: short
  craue_twig_extensions.formatDateTime.timeZone: Europe/Berlin
```

## FormatNumberExtension

```yaml
# in app/config/parameters.yml
  craue_twig_extensions.formatNumber.currency: EUR
```

## ChangeLanguageExtension

```yaml
# in app/config/parameters.yml
  craue_twig_extensions.changeLanguage.availableLocales: [de, en, ru]
  craue_twig_extensions.changeLanguage.showForeignLanguageNames: true
  craue_twig_extensions.changeLanguage.showFirstUppercase: false
```

You can also set the keys to be more specific about the locales:

```yaml
# in app/config/parameters.yml
  craue_twig_extensions.changeLanguage.availableLocales:
    de_DE: de
    en: en
    ru: ru
```

```xml
<!-- in app/config/parameters.xml -->
<parameter key="craue_twig_extensions.changeLanguage.availableLocales" type="collection">
	<parameter key="de_DE">de</parameter>
	<parameter key="en">en</parameter>
	<parameter key="ru">ru</parameter>
</parameter>
```

# Advanced stuff

## Aliases

Optionally, you can define aliases for all provided filters/functions to be used within your project.
This allows you to use names you prefer instead of the pre-defined ones. E.g., if you don't like to write

```twig
{{ somevalue | craue_default }}
```

all the time, you may define an alias like `d` for the `craue_default` filter which allows you to write

```twig
{{ somevalue | d }}
```

in your Twig templates. But pay attention to not accidentally override built-in filters/functions, although you
can do it intentionally.

### DecorateEmptyValueExtension

```yaml
# in app/config/parameters.yml
  craue_twig_extensions.decorateEmptyValue.filterAlias: d
```

### ArrayHelperExtension

```yaml
# in app/config/parameters.yml
  craue_twig_extensions.arrayHelper.withoutAlias: without
  craue_twig_extensions.arrayHelper.replaceKeyAlias: replaceKey
  craue_twig_extensions.arrayHelper.removeKeyAlias: removeKey
  craue_twig_extensions.arrayHelper.translateArrayAlias: translateArray
```

### FormExtension

```yaml
# in app/config/parameters.yml
  craue_twig_extensions.form.cloneFormAlias: cloneForm
```

### StringHelperExtension

```yaml
# in app/config/parameters.yml
  craue_twig_extensions.stringHelper.trailingDotAlias: trailingDot
```

### FormatDateTimeExtension

```yaml
# in app/config/parameters.yml
  craue_twig_extensions.formatDateTime.dateFilterAlias: date
  craue_twig_extensions.formatDateTime.timeFilterAlias: time
  craue_twig_extensions.formatDateTime.dateTimeFilterAlias: datetime
```

### FormatNumberExtension

```yaml
# in app/config/parameters.yml
  craue_twig_extensions.formatNumber.numberFilterAlias: number
  craue_twig_extensions.formatNumber.currencyFilterAlias: currency
  craue_twig_extensions.formatNumber.spelloutFilterAlias: spellout
```

### ChangeLanguageExtension

```yaml
# in app/config/parameters.yml
  craue_twig_extensions.changeLanguage.languageNameAlias: languageName
  craue_twig_extensions.changeLanguage.availableLocalesAlias: availableLocales
```

## Enabling only specific extensions

By default, all provided extensions are enabled. If you're using only one or some of them, you may want to disable the
others. The following enables them all, so remove the ones you don't need:

```yaml
# in app/config/config.yml
craue_twig_extensions:
  enable_only:
    - ArrayHelperExtension
    - ChangeLanguageExtension
    - DecorateEmptyValueExtension
    - FormatDateTimeExtension
    - FormatNumberExtension
    - FormExtension
    - StringHelperExtension
```
