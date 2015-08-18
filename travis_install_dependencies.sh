#!/bin/sh

export COMPOSER_NO_INTERACTION=1
composer self-update

if [ -n "${MIN_STABILITY:-}" ]; then
	sed -i -e "s/\"minimum-stability\": \"stable\"/\"minimum-stability\": \"${MIN_STABILITY}\"/" composer.json
fi

composer remove --no-update symfony/twig-bundle
composer require --no-update --dev symfony/symfony:${SYMFONY_VERSION}

if [ "${PHPUNIT_BRIDGE:-}" = true ]; then
	composer require --no-update --dev symfony/phpunit-bridge:"${SYMFONY_VERSION}"
fi

composer update
