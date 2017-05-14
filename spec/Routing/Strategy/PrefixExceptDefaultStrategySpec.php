<?php

namespace spec\Umpirsky\I18nRoutingBundle\Routing\Strategy;

use Umpirsky\I18nRoutingBundle\Routing\Strategy\PrefixExceptDefaultStrategy;
use Umpirsky\I18nRoutingBundle\Routing\Generator\LocaleRequirementGeneratorInterface;
use Symfony\Component\Routing\Route;
use Symfony\Component\Routing\RouteCollection;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class PrefixExceptDefaultStrategySpec extends ObjectBehavior
{
    function let(LocaleRequirementGeneratorInterface $localeRequirementGenerator)
    {
        $localeRequirementGenerator->generate()->willReturn('sr|ru|pl');

        $this->beConstructedWith($localeRequirementGenerator, 'en', '_i18n');
    }

    function it_generates_route_collection_one_as_is_and_one_with_locale_prefixed_route(Route $route)
    {
        $this->generate('foo', $route)->shouldReturnAnInstanceOf(RouteCollection::class);
    }
}
