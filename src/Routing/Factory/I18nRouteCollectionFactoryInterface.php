<?php

namespace Umpirsky\I18nRoutingBundle\Routing\Factory;

use Symfony\Component\Routing\RouteCollection;

interface I18nRouteCollectionFactoryInterface
{
    public function create(RouteCollection $routeCollection);
}
