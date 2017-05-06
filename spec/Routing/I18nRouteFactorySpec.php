<?php

namespace spec\Umpirsky\I18nRoutingBundle\Routing;

use PhpSpec\ObjectBehavior;
use Symfony\Component\Routing\Route;
use Umpirsky\I18nRoutingBundle\Routing\LocaleRequirementGenerator;

class I18nRouteFactorySpec extends ObjectBehavior
{
    function let(LocaleRequirementGenerator $localeRequirementGenerator)
    {
        $localeRequirementGenerator->generate()->willReturn('sr|ru|pl');

        $this->beConstructedWith($localeRequirementGenerator);
    }

    function it_creates_i18n_route_based_on_regular_route(Route $route)
    {
        $this->create($route)->shouldReturnAnInstanceOf(Route::class);
    }
}
