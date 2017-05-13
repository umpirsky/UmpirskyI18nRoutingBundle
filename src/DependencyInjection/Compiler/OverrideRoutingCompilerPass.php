<?php

namespace Umpirsky\I18nRoutingBundle\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Alias;
use Symfony\Component\DependencyInjection\Exception\ServiceNotFoundException;
use Umpirsky\I18nRoutingBundle\Routing\Router;

class OverrideRoutingCompilerPass implements CompilerPassInterface
{
    public function process(ContainerBuilder $container)
    {
        if ('prefix_except_default' === $container->getParameter('umpirsky_i18n_routing.strategy')) {
            $container->getDefinition('router.default')->setClass(Router::class);
        }

        $routingLoaderDefinition = $container->getDefinition('routing.loader');
        $routingLoaderDefinition->setPublic(false);
        $container->setDefinition('umpirsky_i18n_routing.routing.loader.i18n_route_loader.parent', $routingLoaderDefinition);
        $container->setAlias('routing.loader', 'umpirsky_i18n_routing.routing.loader.i18n_route_loader');
    }
}
