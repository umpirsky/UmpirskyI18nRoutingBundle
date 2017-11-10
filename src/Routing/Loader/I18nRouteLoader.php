<?php

namespace Umpirsky\I18nRoutingBundle\Routing\Loader;

use Symfony\Component\Config\Loader\LoaderInterface;
use Symfony\Component\Config\Loader\LoaderResolverInterface;
use Symfony\Component\Routing\RouteCollection;
use Umpirsky\I18nRoutingBundle\Routing\Strategy\StrategyInterface;

class I18nRouteLoader implements LoaderInterface
{
    private $loader;
    private $strategy;

    public function __construct(LoaderInterface $loader, StrategyInterface $strategy)
    {
        $this->loader = $loader;
        $this->strategy = $strategy;
    }

    public function load($resource, $type = null): RouteCollection
    {
        $routeCollection = $this->loader->load($resource, $type);

        $i18nRouteCollection = $this->cloneCollection($routeCollection);

        foreach ($routeCollection->all() as $name => $route) {
            $i18nRouteCollection->addCollection($this->strategy->generate($name, $route));
        }

        return $i18nRouteCollection;
    }

    public function supports($resource, $type = null): bool
    {
        return $this->loader->supports($resource, $type);
    }

    public function getResolver()
    {
        return $this->loader->getResolver();
    }

    public function setResolver(LoaderResolverInterface $resolver)
    {
        $this->loader->setResolver($resolver);
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
