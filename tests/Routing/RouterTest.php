<?php

namespace Umpirsky\I18nRoutingBundle\Tests\Routing;

use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\Routing\Router;

class RouterTest extends KernelTestCase
{
    /**
     * @beforeClass
     */
    public static function setUpKernel()
    {
        static::bootKernel();
    }

    public function testI18nRouting()
    {
        $router = $this->getService('router');

        $this->assertEquals('/{_locale}/blog', $router->getRouteCollection()->get('blog_list')->getPath());
        $this->assertEquals('/{_locale}/blog/{slug}', $router->getRouteCollection()->get('blog_show')->getPath());
    }

    private function getService($id)
    {
        return static::$kernel->getContainer()->get($id);
    }
}
