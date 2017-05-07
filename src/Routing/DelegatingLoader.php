<?php

namespace Umpirsky\I18nRoutingBundle\Routing;

use Symfony\Bundle\FrameworkBundle\Routing\DelegatingLoader as BaseDelegatingLoader;
use Symfony\Bundle\FrameworkBundle\Controller\ControllerNameParser;
use Symfony\Component\Config\Loader\LoaderResolverInterface;

class DelegatingLoader extends BaseDelegatingLoader
{
    private $i18nRouteCollectionFactory;

    public function __construct(I18nRouteCollectionFactoryInterface $i18nRouteCollectionFactory, ControllerNameParser $parser, LoaderResolverInterface $resolver)
    {
        $this->i18nRouteCollectionFactory = $i18nRouteCollectionFactory;

        parent::__construct($parser, $resolver);
    }

    public function load($resource, $type = null)
    {
        return $this->i18nRouteCollectionFactory->create(parent::load($resource, $type));
    }
}
