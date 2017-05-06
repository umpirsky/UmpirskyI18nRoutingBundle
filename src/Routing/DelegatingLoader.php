<?php

namespace Umpirsky\I18nRoutingBundle\Routing;

use Symfony\Bundle\FrameworkBundle\Routing\DelegatingLoader as BaseDelegatingLoader;

class DelegatingLoader extends BaseDelegatingLoader
{
    /**
     * {@inheritdoc}
     */
    public function load($resource, $type = null)
    {
        $collection = parent::load($resource, $type);

        foreach ($collection->all() as $route) {
            // TODO: clone route and add localized route to collection
        }
    }
}
