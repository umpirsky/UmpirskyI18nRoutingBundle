<?php

namespace Umpirsky\I18nRoutingBundle\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;

class OverrideRoutingCompilerPass implements CompilerPassInterface
{
    public function process(ContainerBuilder $container)
    {
        $container->setAlias('routing.loader', 'umpirsky_i18n_routing.routing.i18n_route_loader');
    }
}
