<?php

namespace Umpirsky\I18nRoutingBundle\Tests\Routing;

use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Bundle\FrameworkBundle\Routing\Router;
use Symfony\Component\HttpFoundation\Request;
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

    public function testI18nRoutingWithPrefixExceptDefaultStrategyWithDefault()
    {
        static::bootKernel(['environment' => 'prefix_except_default']);

        $context = new RequestContext();
        $context->setParameter('_locale', 'en');

        $router = $this->getService('router');
        $router->setContext($context);

        $this->assertEquals($router->generate('blog_list'), '/blog');
    }

    public function testI18nRoutingWithPrefixExceptDefaultStrategySwitchToDefault()
    {
        static::bootKernel(['environment' => 'prefix_except_default']);

        $context = new RequestContext();
        $context->setParameter('_locale', 'pl');

        $router = $this->getService('router');
        $router->setContext($context);

        $this->assertEquals($router->generate('blog_list', ['_locale' => 'en']), '/blog');
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

    /**
     * @dataProvider i18nRoutingWithPrefixExceptDefaultStrategyMatchProvider
     */
    public function testI18nRoutingWithPrefixExceptDefaultStrategyMatch($uri, $locale, $route)
    {
        static::bootKernel(['environment' => 'prefix_except_default']);

        $router = $this->getService('router');
        $match = $router->match($uri);
        $requestMatch = $router->matchRequest(Request::create($uri));

        $this->assertArrayHasKey('_locale', $match);
        $this->assertArrayHasKey('_locale', $requestMatch);

        $this->assertSame($locale, $match['_locale']);
        $this->assertSame($locale, $requestMatch['_locale']);

        $this->assertArrayHasKey('_route', $match);
        $this->assertArrayHasKey('_route', $requestMatch);

        $this->assertSame($route, $match['_route']);
        $this->assertSame($route, $requestMatch['_route']);
    }

    public function i18nRoutingWithPrefixExceptDefaultStrategyMatchProvider()
    {
        return [
            ['/blog', 'en', 'blog_list'],
            ['/pl/blog', 'pl', 'blog_list'],
        ];
    }

    private function getService($id)
    {
        return static::$kernel->getContainer()->get($id);
    }
}
