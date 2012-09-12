<?php

namespace Craue\TwigExtensionsBundle\Tests\Twig\Extension;

use Craue\TwigExtensionsBundle\Tests\TwigBasedTestCase;
use Craue\TwigExtensionsBundle\Twig\Extension\ChangeLanguageExtension;

/**
 * @group integration
 *
 * @author Christian Raue <christian.raue@gmail.com>
 * @copyright 2011-2012 Christian Raue
 * @license http://www.opensource.org/licenses/mit-license.php MIT License
 */
class ChangeLanguageExtensionIntegrationTest extends TwigBasedTestCase {

	/**
	 * @var ChangeLanguageExtension
	 */
	protected $ext;

	protected function setUp() {
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
				$this->getTwig()->render('IntegrationTestBundle:ChangeLanguage:languageName.html.twig', array(
					'locale' => $locale,
				)));
	}

	public function dataGetLanguageName() {
		return array(
			array(true, false, null, ''),
			array(true, false, '', ''),
			array(true, false, 'de', 'Deutsch'),
			array(true, false, 'de_DE', 'Deutsch (Deutschland)'),
			array(true, false, 'ru', 'русский'),
			array(false, false, 'de', 'German'),
			array(true, true, 'ru', 'Русский'),
		);
	}

}
