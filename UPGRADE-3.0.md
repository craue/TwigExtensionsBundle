# Upgrade from 2.x to 3.0

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
