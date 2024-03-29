<?php

namespace Craue\TwigExtensionsBundle\Tests\Twig\Extension;

use Craue\TwigExtensionsBundle\Twig\Extension\AbstractLocaleAwareExtension;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;

/**
 * @group unit
 *
 * @author Christian Raue <christian.raue@gmail.com>
 * @copyright 2011-2022 Christian Raue
 * @license http://opensource.org/licenses/mit-license.php MIT License
 */
class AbstractLocaleAwareExtensionTest extends TestCase {

	/**
	 * @var AbstractLocaleAwareExtension
	 */
	protected $ext;

	protected function setUp() : void {
		$this->ext = $this->getMockForAbstractClass(AbstractLocaleAwareExtension::class);
	}

	public function testSetLocale_invalidArgument() {
		$this->expectException(\InvalidArgumentException::class);
		$this->expectExceptionMessage('Expected argument of either type "string" or "Symfony\Component\HttpFoundation\RequestStack", but "stdClass" given.');

		$this->ext->setLocale(new \stdClass());
	}

	public function testSetGetLocale_string() {
		$locale = 'de';

		$this->ext->setLocale($locale);
		$this->assertSame($locale, $this->ext->getLocale());
	}

	public function testSetGetLocale_requestStack() {
		$locale = 'de';

		$this->ext->setLocale($this->getRequestStack($locale));
		$this->assertSame($locale, $this->ext->getLocale());
	}

	private function getRequestStack($locale) {
		$request = Request::create('');
		$request->setLocale($locale);
		$requestStack = new RequestStack();
		$requestStack->push($request);

		return $requestStack;
	}

}
