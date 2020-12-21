<?php

namespace Craue\TwigExtensionsBundle\Tests\Twig\Extension;

use Craue\TwigExtensionsBundle\Tests\TwigBasedTestCase;
use Craue\TwigExtensionsBundle\Twig\Extension\ChangeLanguageExtension;

/**
 * @group integration
 *
 * @author Christian Raue <christian.raue@gmail.com>
 * @copyright 2011-2020 Christian Raue
 * @license http://opensource.org/licenses/mit-license.php MIT License
 */
class ChangeLanguageExtensionIntegrationTest extends TwigBasedTestCase {

	/**
	 * @var ChangeLanguageExtension
	 */
	protected $ext;

	protected function setUp() : void {
		parent::setUp();

		$this->ext = self::$kernel->getContainer()->get('twig.extension.craue_changeLanguage');
	}

	/**
	 * @dataProvider dataGetLanguageName
	 */
	public function testGetLanguageName($showForeignLanguageNames, $showFirstUppercase, $locale, $result) {
		$this->ext->setShowForeignLanguageNames($showForeignLanguageNames);
		$this->ext->setShowFirstUppercase($showFirstUppercase);

		$this->assertSame($result,
				$this->getTwig()->render('@IntegrationTest/ChangeLanguage/languageName.html.twig', [
					'locale' => $locale,
				]));
	}

	public function dataGetLanguageName() {
		return [
			[true, false, null, ''],
			[true, false, '', ''],
			[true, false, 'de', 'Deutsch'],
			[true, false, 'de_DE', 'Deutsch (Deutschland)'],
			[true, false, 'ru', 'русский'],
			[false, false, 'de', 'German'],
			[true, true, 'ru', 'Русский'],
		];
	}

	/**
	 * @dataProvider dataGetAvailableLocales
	 */
	public function testGetAvailableLocales_join($availableLocales, $result) {
		$this->ext->setAvailableLocales($availableLocales);

		$this->assertSame($result, $this->getTwig()->render('@IntegrationTest/ChangeLanguage/availableLocales_join.html.twig'));
	}

	/**
	 * @dataProvider dataGetAvailableLocales
	 */
	public function testGetAvailableLocales_loop($availableLocales, $result) {
		$this->ext->setAvailableLocales($availableLocales);

		$this->assertSame($result, $this->getTwig()->render('@IntegrationTest/ChangeLanguage/availableLocales_loop.html.twig'));
	}

	public function dataGetAvailableLocales() {
		return [
			[[], ''],
			[['de'], 'de'],
			[['de', 'en'], 'de, en'],
			[['de_DE', 'en', 'ru'], 'de_DE, en, ru'],
		];
	}

	/**
	 * @dataProvider dataGetAvailableLocales
	 * @group legacy
	 * @expectedDeprecation Twig global "craue_availableLocales" is deprecated. Use the function with the same name instead.
	 */
	public function testGetAvailableLocales_twigGlobal_join($availableLocales, $result) {
		$this->ext->setAvailableLocales($availableLocales);

		$this->assertSame($result, $this->getTwig()->render('@IntegrationTest/ChangeLanguage/availableLocales_twigGlobal_join.html.twig'));
	}

	/**
	 * @dataProvider dataGetAvailableLocales
	 * @group legacy
	 * @expectedDeprecation Twig global "craue_availableLocales" is deprecated. Use the function with the same name instead.
	 */
	public function testGetAvailableLocales_twigGlobal_loop($availableLocales, $result) {
		$this->ext->setAvailableLocales($availableLocales);

		$this->assertSame($result, $this->getTwig()->render('@IntegrationTest/ChangeLanguage/availableLocales_twigGlobal_loop.html.twig'));
	}

	/**
	 * @dataProvider dataGetAvailableLocales
	 * @group legacy
	 * @expectedDeprecation Twig global "myAppLocales" is deprecated. Use the function with the same name instead.
	 */
	public function testGetAvailableLocales_twigGlobal_join_customAlias($availableLocales, $result) {
		$this->ext->setAliases(null, 'myAppLocales');
		$this->ext->setAvailableLocales($availableLocales);

		$this->assertSame($result, $this->getTwig()->render('@IntegrationTest/ChangeLanguage/availableLocales_twigGlobal_join_customAlias.html.twig'));
	}

}
