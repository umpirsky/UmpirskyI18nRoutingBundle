<?php

namespace Umpirsky\I18nRoutingBundle\Tests\Routing;

use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Bundle\FrameworkBundle\Routing\Router;
use Symfony\Component\Routing\Generator\UrlGenerator;
use Symfony\Component\Routing\RequestContext;
use Umpirsky\I18nRoutingBundle\Routing\Router as I18nRouter;

class RouterTest extends KernelTestCase
{
    public function testRouterClassWithPrefixStrategy()
    {
        static::bootKernel(['environment' => 'prefix']);

        $this->assertInstanceOf(Router::class, $this->getService('router'));
        $this->assertNotInstanceOf(I18nRouter::class, $this->getService('router'));
    }

    public function testI18nRoutingPathWithPrefixStrategy()
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

    public function testI18nRoutingPathWithPrefixExceptDefaultStrategy()
    {
        static::bootKernel(['environment' => 'prefix_except_default']);

        $router = $this->getService('router');

        $this->assertEquals('/blog', $router->getRouteCollection()->get('blog_list')->getPath());
        $this->assertEquals('/{_locale}/blog', $router->getRouteCollection()->get('blog_list_i18n')->getPath());
        $this->assertEquals('/blog/{slug}', $router->getRouteCollection()->get('blog_show')->getPath());
        $this->assertEquals('/{_locale}/blog/{slug}', $router->getRouteCollection()->get('blog_show_i18n')->getPath());
        $this->assertEquals('/blog/{slug}/comments', $router->getRouteCollection()->get('blog_show_comments')->getPath());
        $this->assertEquals('/', $router->getRouteCollection()->get('homepage')->getPath());
        $this->assertEquals('/{_locale}/', $router->getRouteCollection()->get('homepage_i18n')->getPath());
        $this->assertEquals('/blog/media/', $router->getRouteCollection()->get('blog_media')->getPath());
        $this->assertEquals('/{_locale}/blog/media/', $router->getRouteCollection()->get('blog_media_i18n')->getPath());
        $this->assertNull($router->getRouteCollection()->get('blog_show_comments_i18n'));
    }

    /**
     * @dataProvider i18nRoutingWithPrefixExceptDefaultStrategyProvider
     */
    public function testI18nRoutingWithPrefixExceptDefaultStrategy($locale)
    {
        static::bootKernel(['environment' => 'prefix_except_default']);

        $context = new RequestContext();
        $context->setParameter('_locale', $locale);

        $router = $this->getService('router');
        $router->setContext($context);

        $this->assertEquals($router->generate('blog_list'), sprintf('/%s/blog', $locale));
        $this->assertEquals($router->generate('blog_show', ['slug' => 'slug']), sprintf('/%s/blog/slug', $locale));
        $this->assertEquals($router->generate('blog_show_comments', ['slug' => 'slug']), '/blog/slug/comments');
    }

    public function i18nRoutingWithPrefixExceptDefaultStrategyProvider()
    {
        return [
            ['sr'],
            ['ru'],
            ['pl'],
        ];
    }

    private function getService($id)
    {
        return static::$kernel->getContainer()->get($id);
    }
}
