# Upgrade from 2.x to 3.0

## Twig extension services

- If you rely on the service instances of Twig extensions registered by this bundle, you need to adjust the service IDs to address them:

	`twig.extension.craue_arrayHelper` ➔ `Craue\TwigExtensionsBundle\Twig\Extension\ArrayHelperExtension`
	`twig.extension.craue_changeLanguage` ➔ `Craue\TwigExtensionsBundle\Twig\Extension\ChangeLanguageExtension`
	`twig.extension.craue_decorateEmptyValue` ➔ `Craue\TwigExtensionsBundle\Twig\Extension\DecorateEmptyValueExtension`
	`twig.extension.craue_formatDateTime` ➔ `Craue\TwigExtensionsBundle\Twig\Extension\FormatDateTimeExtension`
	`twig.extension.craue_formatNumber` ➔ `Craue\TwigExtensionsBundle\Twig\Extension\FormatNumberExtension`
	`twig.extension.craue_form` ➔ `Craue\TwigExtensionsBundle\Twig\Extension\FormExtension`
	`twig.extension.craue_stringHelper` ➔ `Craue\TwigExtensionsBundle\Twig\Extension\StringHelperExtension`

- Be aware that these services are now private so you either have to use proper dependency injection or create public aliases.

## Global `craue_availableLocales`

- The Twig global `craue_availableLocales` has been replaced by a Twig function with the same name.

	before:
	```twig
	{{ craue_availableLocales | join(', ') }}

	{% for locale in craue_availableLocales %}
		...
	{% endfor %}
	```

	after:
	```twig
	{{ craue_availableLocales() | join(', ') }}

	{% for locale in craue_availableLocales() %}
		...
	{% endfor %}
	```
