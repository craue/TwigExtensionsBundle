#!/bin/bash

set -euv

export COMPOSER_NO_INTERACTION=1
composer self-update

case "${DEPS:-}" in
	'lowest')
		COMPOSER_UPDATE_ARGS='--prefer-lowest'
		;;
	'unmodified')
		# don't modify dependencies, install them as defined
		;;
	*)
		if [ -n "${MIN_STABILITY:-}" ]; then
			composer config minimum-stability "${MIN_STABILITY}"
		fi

		composer remove --no-update symfony/config symfony/dependency-injection symfony/twig-bundle

		if [ -n "${SYMFONY_VERSION:-}" ]; then
			composer require --no-update --dev symfony/symfony:"${SYMFONY_VERSION}"
		fi

		if [ -n "${TWIG_VERSION:-}" ]; then
			composer require --no-update --dev twig/twig:"${TWIG_VERSION}"
		fi
esac

if [ -n "${WITH_STATIC_ANALYSIS:-}" ]; then
	composer require --no-update --dev phpstan/phpstan-shim
fi

# TODO remove as soon as Symfony >= 4.2 is required
if [ -n "${WITH_TRANSLATION_CONTRACTS:-}" ]; then
	composer require --no-update --dev "symfony/translation-contracts:~1.1"
fi

composer update ${COMPOSER_UPDATE_ARGS:-}
