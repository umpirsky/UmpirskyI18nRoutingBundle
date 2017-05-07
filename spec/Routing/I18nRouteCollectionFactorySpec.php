<?php

namespace spec\Umpirsky\I18nRoutingBundle\Routing;

use PhpSpec\ObjectBehavior;
use Symfony\Component\Routing\Route;
use Symfony\Component\Routing\RouteCollection;
use Umpirsky\I18nRoutingBundle\Routing\I18nRouteFactoryInterface;

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
        $i18nRouteFactory->create($route)->shouldBeCalled()->willReturn($route);

        $routeCollection->all()->shouldBeCalled()->willReturn(['foo' => $route]);
        $routeCollection->add('foo_i18n', $route)->shouldBeCalled();

        $this->create($routeCollection)->shouldReturnAnInstanceOf(RouteCollection::class);
    }
}
