<?php

namespace spec\Umpirsky\I18nRoutingBundle\Routing\Loader;

use PhpSpec\ObjectBehavior;
use Symfony\Bundle\FrameworkBundle\Routing\DelegatingLoader;
use Symfony\Component\Routing\Route;
use Symfony\Component\Routing\RouteCollection;
use Umpirsky\I18nRoutingBundle\Routing\Strategy\StrategyInterface;

class I18nRouteLoaderSpec extends ObjectBehavior
{
    function let(DelegatingLoader $delegatingLoader, StrategyInterface $strategy)
    {
        $this->beConstructedWith($delegatingLoader, $strategy);
    }

    function it_loads_i18n_routes_based_on_regular_routes(
        DelegatingLoader $delegatingLoader,
        StrategyInterface $strategy,
        RouteCollection $routeCollection,
        Route $route
    ) {
        $delegatingLoader->load('routing.yml', 'yml')->shouldBeCalled()->willReturn($routeCollection);
        $routeCollection->getResources()->shouldBeCalled()->willReturn([]);
        $routeCollection->all()->shouldBeCalled()->willReturn(['foo' => $route]);

        $strategy->generate('foo', $route)->willReturn($routeCollection);

        $this->load('routing.yml', 'yml')->shouldReturnAnInstanceOf(RouteCollection::class);
    }
}
