<?php

namespace Umpirsky\I18nRoutingBundle\Routing;

use Symfony\Component\Routing\Route;

interface I18nRouteFactoryInterface
{
    public function generateName(string $name): string;
    public function create(Route $route): Route;
}
