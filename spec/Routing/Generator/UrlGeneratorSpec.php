<?php

namespace spec\Umpirsky\I18nRoutingBundle\Routing\Generator;

use Umpirsky\I18nRoutingBundle\Routing\Generator\UrlGenerator;
use Symfony\Component\Routing\RequestContext;
use Symfony\Component\Routing\RouteCollection;
use Symfony\Component\Routing\CompiledRoute;
use Symfony\Component\Routing\Route;
use Iterator;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class UrlGeneratorSpec extends ObjectBehavior
{
    function let(RouteCollection $routeCollection, RequestContext $requestContext, Iterator $routeCollectionIterator)
    {
        $routeCollection->getIterator()->willReturn($routeCollectionIterator);
        $requestContext->getParameters()->willReturn([]);
        $requestContext->getHost()->willReturn(null);
        $requestContext->getBaseUrl()->willReturn('');
        $requestContext->hasParameter('_locale')->willReturn(false);

        $this->beConstructedWith($routeCollection, $requestContext);
    }

    function it_generates_regular_urls(RouteCollection $routeCollection, Route $route, CompiledRoute $compiledRoute)
    {
        $routeCollection->get('foo')->willReturn($route);
        $route->compile()->willReturn($compiledRoute);
        $route->getDefaults()->willReturn([]);
        $route->getRequirements()->willReturn([]);
        $route->getSchemes()->willReturn([]);
        $compiledRoute->getVariables()->willReturn([]);
        $compiledRoute->getTokens()->willReturn([
            ['text', '/foo']
        ]);
        $compiledRoute->getHostTokens()->willReturn([]);

        $this->generate('foo')->shouldReturn('/foo');
    }

    function it_generates_i18n_urls_when_current_url_is_i18n(RouteCollection $routeCollection, Route $route, CompiledRoute $compiledRoute, RequestContext $requestContext)
    {
        $requestContext->hasParameter('_locale')->willReturn(true);
        $requestContext->getParameter('_locale')->willReturn('sr');
        $routeCollection->get('foo')->willReturn($route);
        $route->compile()->willReturn($compiledRoute);
        $route->getDefaults()->willReturn([]);
        $route->getRequirements()->willReturn([]);
        $route->getSchemes()->willReturn([]);
        $compiledRoute->getVariables()->willReturn(['sr' => '_locale']);
        $compiledRoute->getTokens()->willReturn([
            ['text', '/foo'],
            ['variable', '/', 'sr|ru|pl|de|es|it|mk|fr|gr', '_locale'],
        ]);
        $compiledRoute->getHostTokens()->willReturn([]);

        $this->generate('foo')->shouldReturn('/sr/foo');
    }
}
