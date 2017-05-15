<?php

namespace Umpirsky\I18nRoutingBundle\Routing\Strategy;

use Symfony\Component\Routing\Route;
use Symfony\Component\Routing\RouteCollection;
use Umpirsky\I18nRoutingBundle\Routing\Generator\LocaleRequirementGeneratorInterface;

class PrefixExceptDefaultStrategy extends AbstractStrategy
{
    private $routeNameSuffix;

    public function __construct(LocaleRequirementGeneratorInterface $localeRequirementGenerator, string $defaultLocale, string $routeNameSuffix)
    {
        $this->routeNameSuffix = $routeNameSuffix;

        parent::__construct($localeRequirementGenerator, $defaultLocale);
    }

    public function generate(string $name, Route $route): RouteCollection
    {
        $collection = new RouteCollection();
        $collection->add($name, $route);

        if (false === $route->getOption('i18n')) {
            return $collection;
        }

        $i18nRoute = clone $route;

        $i18nRoute->setPath('/{_locale}'.$route->getPath());
        $i18nRoute->setRequirement('_locale', $this->localeRequirementGenerator->generate());
        $collection->add($name.$this->routeNameSuffix, $i18nRoute);

        return $collection;
    }
}
