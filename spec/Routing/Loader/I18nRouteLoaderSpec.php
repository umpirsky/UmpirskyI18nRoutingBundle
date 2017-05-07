<?php

namespace spec\Umpirsky\I18nRoutingBundle\Routing\Loader;

use Umpirsky\I18nRoutingBundle\Routing\Factory\I18nRouteCollectionFactoryInterface;
use PhpSpec\ObjectBehavior;
use Symfony\Bundle\FrameworkBundle\Routing\DelegatingLoader;
use Symfony\Component\Routing\RouteCollection;

class I18nRouteLoaderSpec extends ObjectBehavior
{
    function let(DelegatingLoader $delegatingLoader, I18nRouteCollectionFactoryInterface $i18nRouteCollectionFactory)
    {
        $this->beConstructedWith($delegatingLoader, $i18nRouteCollectionFactory);
    }

    function it_loads_i18n_routes_based_on_regular_routes(
        DelegatingLoader $delegatingLoader,
        I18nRouteCollectionFactoryInterface $i18nRouteCollectionFactory,
        RouteCollection $routeCollection
    ) {
        $delegatingLoader->load('routing.yml', 'yml')->shouldBeCalled()->willReturn($routeCollection);
        $i18nRouteCollectionFactory->create($routeCollection)->willReturn($routeCollection);

        $this->load('routing.yml', 'yml')->shouldReturn($routeCollection);
    }
}
