<?php

namespace Umpirsky\I18nRoutingBundle;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;
use Umpirsky\I18nRoutingBundle\DependencyInjection\Compiler\OverrideRoutingCompilerPass;

class UmpirskyI18nRoutingBundle extends Bundle
{
    public function build(ContainerBuilder $container)
    {
        $container->addCompilerPass(new OverrideRoutingCompilerPass());

        parent::build($container);
    }
}
