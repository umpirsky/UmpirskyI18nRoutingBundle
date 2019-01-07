<?php

namespace Umpirsky\I18nRoutingBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

final class Configuration implements ConfigurationInterface
{
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder('umpirsky_i18n_routing');

        if (method_exists($treeBuilder, 'getRootNode')) {
            $rootNode = $treeBuilder->getRootNode();
        } else {
            // BC layer for symfony/config 4.1 and older
            $rootNode = $treeBuilder->root('umpirsky_i18n_routing');
        }

        $rootNode
            ->children()
                ->scalarNode('route_name_suffix')->defaultValue('_i18n')->end()
                ->scalarNode('default_locale')->isRequired()->end()
                ->arrayNode('locales')
                    ->requiresAtLeastOneElement()
                    ->prototype('scalar')->end()
                ->end()
                ->scalarNode('strategy')
                    ->defaultValue('prefix')
                    ->validate()
                        ->ifNotInArray(array('prefix', 'prefix_except_default'))
                        ->thenInvalid('Must be prefix (default) or prefix_except_default')
                    ->end()
                ->end()
            ->end()
        ;

        return $treeBuilder;
    }
}
