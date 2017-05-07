<?php

namespace Umpirsky\I18nRoutingBundle\Routing\Loader;

use Symfony\Bundle\FrameworkBundle\Routing\DelegatingLoader;
use Symfony\Component\Routing\RouteCollection;
use Umpirsky\I18nRoutingBundle\Routing\Factory\I18nRouteCollectionFactoryInterface;

class I18nRouteLoader implements I18nRouteLoaderInterface
{
    private $delegatingLoader;
    private $i18nRouteCollectionFactory;

    public function __construct(DelegatingLoader $delegatingLoader, I18nRouteCollectionFactoryInterface $i18nRouteCollectionFactory)
    {
        $this->delegatingLoader = $delegatingLoader;
        $this->i18nRouteCollectionFactory = $i18nRouteCollectionFactory;
    }

    public function load($resource, $type = null): RouteCollection
    {
        return $this->i18nRouteCollectionFactory->create($this->delegatingLoader->load($resource, $type));
    }
}
