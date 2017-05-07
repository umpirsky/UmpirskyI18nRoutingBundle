<?php

namespace Umpirsky\I18nRoutingBundle\Routing;

use Symfony\Component\Routing\Route;

interface I18nRouteFactoryInterface
{
    public function create(Route $route): Route;
}
