<?php

namespace spec\Umpirsky\I18nRoutingBundle\Routing\Factory;

use PhpSpec\ObjectBehavior;
use Symfony\Component\Routing\Route;
use Symfony\Component\Routing\RouteCollection;
use Umpirsky\I18nRoutingBundle\Routing\Factory\I18nRouteFactoryInterface;

class I18nRouteCollectionFactorySpec extends ObjectBehavior
{
    function let(I18nRouteFactoryInterface $i18nRouteFactory)
    {
        $this->beConstructedWith($i18nRouteFactory, '_i18n');
    }

    function it_creates_i18n_route_collection_based_on_regular_route_collection(
        I18nRouteFactoryInterface $i18nRouteFactory,
        RouteCollection $routeCollection,
        Route $route
    ) {
        $i18nRouteFactory->generateName('foo')->shouldBeCalled()->willReturn('foo_i18n');
        $i18nRouteFactory->create($route)->shouldBeCalled()->willReturn($route);

        $routeCollection->getResources()->shouldBeCalled()->willReturn([]);
        $routeCollection->all()->shouldBeCalled()->willReturn(['foo' => $route]);

        $this->create($routeCollection)->shouldReturnAnInstanceOf(RouteCollection::class);
    }
}
