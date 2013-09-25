#!/bin/sh

wget http://getcomposer.org/composer.phar

php composer.phar config -g preferred-install source

sed -i -e "s/\"minimum-stability\": \"stable\"/\"minimum-stability\": \"${MIN_STABILITY}\"/" composer.json

php composer.phar --no-interaction --no-update require symfony/symfony:${SYMFONY_VERSION} symfony/twig-bundle:${SYMFONY_VERSION}
php composer.phar --no-interaction --no-update require --dev symfony/symfony:${SYMFONY_VERSION}
php composer.phar --no-interaction update
