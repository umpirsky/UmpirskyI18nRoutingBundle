<?php

namespace spec\Umpirsky\I18nRoutingBundle\Routing;

use Symfony\Bundle\FrameworkBundle\Routing\Router;
use Symfony\Component\Routing\RequestContext;
use PhpSpec\ObjectBehavior;

class RouterSpec extends ObjectBehavior
{
    function let(Router $router)
    {
        $this->beConstructedWith($router, '_i18n', 'en');
    }

    function it_generates_regular_urls(Router $router, RequestContext $requestContext)
    {
        $requestContext->hasParameter('_locale')->willReturn(false);
        $router->getContext()->willReturn($requestContext);
        $router->generate('foo', [], Router::ABSOLUTE_PATH)->willReturn('/foo');

        $this->generate('foo')->shouldReturn('/foo');
    }

    function it_generates_i18n_urls_when_current_url_is_i18n(Router $router, RequestContext $requestContext)
    {
        $requestContext->hasParameter('_locale')->willReturn(true);
        $requestContext->getParameter('_locale')->willReturn('sr');
        $router->getContext()->willReturn($requestContext);
        $router->generate('foo_i18n', ['_locale' => 'sr'], Router::ABSOLUTE_PATH)->willReturn('/sr/foo');

        $this->generate('foo')->shouldReturn('/sr/foo');
    }
}
