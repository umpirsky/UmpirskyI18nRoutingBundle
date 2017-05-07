<?php

namespace Umpirsky\I18nRoutingBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Processor;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\XmlFileLoader;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;

class UmpirskyI18nRoutingExtension extends Extension
{
    public function load(array $configs, ContainerBuilder $container)
    {
        $processor = new Processor();
        $config = $processor->processConfiguration(new Configuration, $configs);

        $loader = new XmlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        $loader->load('services.xml');

        $container->setParameter('umpirsky_i18n_routing.route_name_suffix', $config['route_name_suffix']);
        $container->setParameter('umpirsky_i18n_routing.default_locale', $config['default_locale']);
        $container->setParameter('umpirsky_i18n_routing.locales', $config['locales']);
    }
}
