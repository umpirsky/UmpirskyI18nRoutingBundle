<?php

namespace Umpirsky\I18nRoutingBundle\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Umpirsky\I18nRoutingBundle\Routing\Router;

class OverrideRoutingCompilerPass implements CompilerPassInterface
{
    public function process(ContainerBuilder $container)
    {
        if ('prefix_except_default' !== $container->getParameter('umpirsky_i18n_routing.strategy')) {
            return;
        }

        $routerDefinition = $container->getDefinition('router.default');
        $routerDefinition->setClass(Router::class);
        $options = $routerDefinition->getArgument(2);
        $options['i18n_route_name_suffix'] = $container->getParameter('umpirsky_i18n_routing.route_name_suffix');
        $options['i18n_default_locale'] = $container->getParameter('umpirsky_i18n_routing.default_locale');
        $routerDefinition->replaceArgument(2, $options);
    }
}
