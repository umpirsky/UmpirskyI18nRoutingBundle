<?php

namespace Umpirsky\I18nRoutingBundle\Tests\Routing;

use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\Routing\Router;

class RouterTest extends KernelTestCase
{
    public function testI18nRouting()
    {
        static::bootKernel();

        $router = static::$kernel->getContainer()->get('router');

        $this->assertInstanceOf(Router::class, $router);
    }
}
