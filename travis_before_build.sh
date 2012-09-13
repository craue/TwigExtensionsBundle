#!/bin/sh

wget http://getcomposer.org/composer.phar
sed -i -e "s/\"minimum-stability\": \"dev\"/\"minimum-stability\": \"${MIN_STABILITY}\"/" composer.json
php composer.phar --no-interaction --no-update require symfony/symfony:${SYMFONY_VERSION} symfony/twig-bundle:${SYMFONY_VERSION}
php composer.phar --no-interaction --no-update require --dev symfony/symfony:${SYMFONY_VERSION}
php composer.phar --no-interaction update --dev
