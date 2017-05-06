<?php

namespace Umpirsky\I18nRoutingBundle\Routing;

use Symfony\Bundle\FrameworkBundle\Routing\DelegatingLoader as BaseDelegatingLoader;
use Symfony\Bundle\FrameworkBundle\Controller\ControllerNameParser;
use Symfony\Component\Config\Loader\LoaderResolverInterface;

class DelegatingLoader extends BaseDelegatingLoader
{
    public function __construct(I18nLoader $i18nLoader, ControllerNameParser $parser, LoaderResolverInterface $resolver)
    {
        $this->i18nLoader = $i18nLoader;

        parent::__construct($parser, $resolver);
    }

    public function load($resource, $type = null)
    {
        return $this->i18nLoader->load(parent::load($resource, $type));
    }
}
