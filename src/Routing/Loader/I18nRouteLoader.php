<?php

namespace Umpirsky\I18nRoutingBundle\Routing\Loader;

use Symfony\Bundle\FrameworkBundle\Routing\DelegatingLoader;
use Symfony\Component\Routing\RouteCollection;
use Umpirsky\I18nRoutingBundle\Routing\Factory\I18nRouteCollectionFactoryInterface;
use Umpirsky\I18nRoutingBundle\Routing\Strategy\StrategyInterface;

class I18nRouteLoader implements I18nRouteLoaderInterface
{
    private $delegatingLoader;
    private $strategy;

    public function __construct(DelegatingLoader $delegatingLoader, StrategyInterface $strategy)
    {
        $this->delegatingLoader = $delegatingLoader;
        $this->strategy = $strategy;
    }

    public function load($resource, $type = null): RouteCollection
    {
        $routeCollection = $this->delegatingLoader->load($resource, $type);

        $i18nRouteCollection = $this->cloneCollection($routeCollection);

        foreach ($routeCollection->all() as $name => $route) {
            $i18nRouteCollection->addCollection($this->strategy->generate($name, $route));
        }

        return $i18nRouteCollection;
    }

    private function cloneCollection(RouteCollection $routeCollection): RouteCollection
    {
        $routeCollectionClone = new RouteCollection();
        foreach ($routeCollection->getResources() as $resource) {
            $routeCollectionClone->addResource($resource);
        }

        return $routeCollectionClone;
    }
}
