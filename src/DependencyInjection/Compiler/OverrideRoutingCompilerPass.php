<?php

namespace Umpirsky\I18nRoutingBundle\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;

class OverrideRoutingCompilerPass implements CompilerPassInterface
{
    public function process(ContainerBuilder $container)
    {
        $definition = $container->getDefinition('routing.loader');
        $definition->setPublic(false);
        $container->setDefinition('umpirsky_i18n_routing.routing.loader.i18n_route_loader.parent', $definition);
        $container->setAlias('routing.loader', 'umpirsky_i18n_routing.routing.loader.i18n_route_loader');
    }
}
