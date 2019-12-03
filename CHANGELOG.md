# Changelog

## [2.7.0] – 2019-12-03

- added support for Symfony 5.*
- dropped support for Symfony 4.1

[2.7.0]: https://github.com/craue/TwigExtensionsBundle/compare/2.6.0...2.7.0

## [2.6.0] – 2019-11-14

- deprecated passing the service container to `setLocale`, pass the request stack instead

[2.6.0]: https://github.com/craue/TwigExtensionsBundle/compare/2.5.0...2.6.0

## [2.5.0] – 2019-11-13

- [#11]: deprecated Twig global `craue_availableLocales`, added a function with the same name as replacement
- throw helpful exceptions about missing components when using certain features

[#11]: https://github.com/craue/TwigExtensionsBundle/issues/11
[2.5.0]: https://github.com/craue/TwigExtensionsBundle/compare/2.4.1...2.5.0

## [2.4.1] – 2019-04-29

- [#14]: fixed returning the locale in CLI

[#14]: https://github.com/craue/TwigExtensionsBundle/issues/14
[2.4.1]: https://github.com/craue/TwigExtensionsBundle/compare/2.4.0...2.4.1

## [2.4.0] – 2019-01-06

- dropped support for Symfony 2.7, 2.8, 3.0, 3.1, 3.2, 3.3, 4.0
- dropped support for PHP 5.3, 5.4, 5.5, 5.6
- dropped support for HHVM

[2.4.0]: https://github.com/craue/TwigExtensionsBundle/compare/2.3.1...2.4.0

## [2.3.1] – 2018-01-05

- fixed support for Traversable in ArrayHelperExtension

[2.3.1]: https://github.com/craue/TwigExtensionsBundle/compare/2.3.0...2.3.1

## [2.3.0] – 2017-12-14

- [#12]: added support for Symfony 4.*
- bumped Symfony dependency to 2.7

[#12]: https://github.com/craue/TwigExtensionsBundle/issues/12
[2.3.0]: https://github.com/craue/TwigExtensionsBundle/compare/2.2.0...2.3.0

## [2.2.0] – 2017-01-09

- added support for DateTimeInterface in FormatDateTimeExtension
- use namespaced template names in ChangeLanguageExtension (available since Twig 1.10)

[2.2.0]: https://github.com/craue/TwigExtensionsBundle/compare/2.1.1...2.2.0

## [2.1.1] – 2015-12-29

- added support for PHP 7.0 and HHVM

[2.1.1]: https://github.com/craue/TwigExtensionsBundle/compare/2.1.0...2.1.1

## [2.1.0] – 2015-12-01

- added forward compatibility for Twig 2.0
- added conditional code updates to avoid deprecation notices with Symfony 2.8
- added support for Symfony 3.*
- dropped support for Symfony 2.0, 2.1, 2.2

[2.1.0]: https://github.com/craue/TwigExtensionsBundle/compare/2.0.1...2.1.0

## [2.0.1] – 2014-06-01

- updated version constraint for installation instructions

[2.0.1]: https://github.com/craue/TwigExtensionsBundle/compare/2.0.0...2.0.1

## [2.0.0] – 2014-06-01

- BC break (follow `UPGRADE-2.0.md` to upgrade):
  - [#10]: dropped support for passing a `FormView` instance to the `craue_cloneForm` function

[#10]: https://github.com/craue/TwigExtensionsBundle/issues/10
[2.0.0]: https://github.com/craue/TwigExtensionsBundle/compare/1.0.2...2.0.0

## [1.0.2] – 2013-12-03

- added filter `craue_removeKey`

[1.0.2]: https://github.com/craue/TwigExtensionsBundle/compare/1.0.1...1.0.2

## [1.0.1] – 2013-09-25

- adjusted the Composer requirements to also allow Symfony 2.3 and up (now 2.0 and up)
- fixed test config

[1.0.1]: https://github.com/craue/TwigExtensionsBundle/compare/1.0.0...1.0.1

## 1.0.0 - 2013-02-28

- first stable release

## 2011-05-20

- initial commit
