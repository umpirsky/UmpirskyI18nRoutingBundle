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

        $this->beConstructedWith($routeCollection, $requestContext);
    }

    function it_generates_urls(RouteCollection $routeCollection, Route $route, CompiledRoute $compiledRoute)
    {
        $routeCollection->get('foo')->willReturn($route);
        $route->compile()->willReturn($compiledRoute);
        $route->getDefaults()->willReturn([]);
        $route->getRequirements()->willReturn([]);
        $route->getSchemes()->willReturn([]);
        $compiledRoute->getVariables()->willReturn([]);
        $compiledRoute->getTokens()->willReturn([
            ['', '/foo']
        ]);
        $compiledRoute->getHostTokens()->willReturn([]);

        $this->generate('foo')->shouldReturn('/foo');
    }
}
