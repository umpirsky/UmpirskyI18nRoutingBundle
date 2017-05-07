<?php

namespace spec\Umpirsky\I18nRoutingBundle\Routing\Generator;

use PhpSpec\ObjectBehavior;

class LocaleRequirementGeneratorSpec extends ObjectBehavior
{
    function let()
    {
        $this->beConstructedWith(['sr', 'ru', 'pl']);
    }

    function it_generates_locale_requirement()
    {
        $this->generate()->shouldReturn('sr|ru|pl');
    }
}
