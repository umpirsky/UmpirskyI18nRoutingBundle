<?php

namespace Umpirsky\I18nRoutingBundle\Tests\Routing;

use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\Routing\Router;

class RouterTest extends KernelTestCase
{
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

    public function testI18nRoutingWithPrefixExceptDefaultStrategy()
    {
        static::bootKernel(['environment' => 'prefix_except_default']);

        $router = $this->getService('router');

        $this->assertEquals('/blog', $router->getRouteCollection()->get('blog_list')->getPath());
        $this->assertEquals('/{_locale}/blog', $router->getRouteCollection()->get('blog_list_i18n')->getPath());
        $this->assertEquals('/blog/{slug}', $router->getRouteCollection()->get('blog_show')->getPath());
        $this->assertEquals('/{_locale}/blog/{slug}', $router->getRouteCollection()->get('blog_show_i18n')->getPath());
        $this->assertEquals('/blog/{slug}/comments', $router->getRouteCollection()->get('blog_show_comments')->getPath());
        $this->assertFalse($router->getRouteCollection()->has('blog_show_comments_i18n'));
    }

    private function getService($id)
    {
        return static::$kernel->getContainer()->get($id);
    }
}
