<?php

namespace Umpirsky\I18nRoutingBundle\Routing\Strategy;

use Symfony\Component\Routing\Route;
use Symfony\Component\Routing\RouteCollection;

interface StrategyInterface
{
    public function generate(string $name, Route $route): RouteCollection;
}
