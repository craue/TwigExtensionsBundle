<?php

namespace Craue\TwigExtensionsBundle\Tests\Twig\Extension;

use Craue\TwigExtensionsBundle\Tests\TwigBasedTestCase;
use Craue\TwigExtensionsBundle\Twig\Extension\ChangeLanguageExtension;

/**
 * @group integration
 *
 * @author Christian Raue <christian.raue@gmail.com>
 * @copyright 2011 Christian Raue
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

	public function testGetLanguageName() {
		$cases = array(
			array(
				'showForeignLanguageNames' => true,
				'showFirstUppercase' => false,
				'locale' => null,
				'result' => '',
			),
			array(
				'showForeignLanguageNames' => true,
				'showFirstUppercase' => false,
				'locale' => '',
				'result' => '',
			),
			array(
				'showForeignLanguageNames' => true,
				'showFirstUppercase' => false,
				'locale' => 'de',
				'result' => 'Deutsch',
			),
			array(
				'showForeignLanguageNames' => true,
				'showFirstUppercase' => false,
				'locale' => 'de_DE',
				'result' => 'Deutsch (Deutschland)',
			),
			array(
				'showForeignLanguageNames' => true,
				'showFirstUppercase' => false,
				'locale' => 'ru',
				'result' => 'русский',
			),
			array(
				'showForeignLanguageNames' => false,
				'showFirstUppercase' => false,
				'locale' => 'de',
				'result' => 'German',
			),
			array(
				'showForeignLanguageNames' => true,
				'showFirstUppercase' => true,
				'locale' => 'ru',
				'result' => 'Русский',
			),
		);

		foreach ($cases as $index => $case) {
			$this->ext->setShowForeignLanguageNames($case['showForeignLanguageNames']);
			$this->ext->setShowFirstUppercase($case['showFirstUppercase']);

			$this->assertSame($case['result'],
					$this->getTwig()->render('IntegrationTestBundle:ChangeLanguage:languageName.html.twig', array(
						'locale' => $case['locale'],
					)),
					'test case with index '.$index);
		}
	}

}
