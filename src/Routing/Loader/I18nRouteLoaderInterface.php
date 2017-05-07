<?php

namespace Umpirsky\I18nRoutingBundle\Routing\Loader;

use Symfony\Component\Routing\RouteCollection;

interface I18nRouteLoaderInterface
{
    public function load($resource, $type = null): RouteCollection;
}
