<?php

namespace Umpirsky\I18nRoutingBundle\Tests\Routing;

use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\Routing\Router;
use Umpirsky\I18nRoutingBundle\Routing\Router as I18nRouter;

class RouterTest extends KernelTestCase
{
    public function testRouterClassWithPrefixStrategy()
    {
        static::bootKernel(['environment' => 'prefix']);

        $this->assertInstanceOf(Router::class, $this->getService('router'));
        $this->assertNotInstanceOf(I18nRouter::class, $this->getService('router'));
    }

    public function testI18nRoutingWithPrefixStrategy()
    {
        static::bootKernel(['environment' => 'prefix']);

        $router = $this->getService('router');

        $this->assertEquals('/{_locale}/blog', $router->getRouteCollection()->get('blog_list')->getPath());
        $this->assertEquals('en', $router->getRouteCollection()->get('blog_list')->getDefault('_locale'));
        $this->assertEquals('/{_locale}/blog/{slug}', $router->getRouteCollection()->get('blog_show')->getPath());
        $this->assertEquals('en', $router->getRouteCollection()->get('blog_show')->getDefault('_locale'));
        $this->assertEquals('/blog/{slug}/comments', $router->getRouteCollection()->get('blog_show_comments')->getPath());
    }

    public function testRouterClassWithPrefixExceptDefaultStrategy()
    {
        static::bootKernel(['environment' => 'prefix_except_default']);

        $this->assertInstanceOf(I18nRouter::class, $this->getService('router'));
    }

    public function testI18nRoutingWithPrefixExceptDefaultStrategy()
    {
        static::bootKernel(['environment' => 'prefix_except_default']);

        $router = $this->getService('router');

        $this->assertEquals('/blog', $router->getRouteCollection()->get('blog_list')->getPath());
        $this->assertEquals('/{_locale}/blog', $router->getRouteCollection()->get('blog_list_i18n')->getPath());
        $this->assertEquals('/blog/{slug}', $router->getRouteCollection()->get('blog_show')->getPath());
        $this->assertEquals('/{_locale}/blog/{slug}', $router->getRouteCollection()->get('blog_show_i18n')->getPath());
        $this->assertEquals('/blog/{slug}/comments', $router->getRouteCollection()->get('blog_show_comments')->getPath());
        $this->assertNull($router->getRouteCollection()->get('blog_show_comments_i18n'));
    }

    private function getService($id)
    {
        return static::$kernel->getContainer()->get($id);
    }
}
