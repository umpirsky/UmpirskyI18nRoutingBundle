<?php

namespace spec\Umpirsky\I18nRoutingBundle\Routing;

use Umpirsky\I18nRoutingBundle\Routing\DelegatingLoader;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class DelegatingLoaderSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(DelegatingLoader::class);
    }
}
