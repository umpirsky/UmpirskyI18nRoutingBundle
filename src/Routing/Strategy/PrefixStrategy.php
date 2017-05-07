<?php

namespace Umpirsky\I18nRoutingBundle\Routing\Strategy;

use Symfony\Component\Routing\Route;
use Symfony\Component\Routing\RouteCollection;
use Umpirsky\I18nRoutingBundle\Routing\Generator\LocaleRequirementGeneratorInterface;

class PrefixStrategy implements StrategyInterface
{
    private $localeRequirementGenerator;
    private $defaultLocale;

    public function __construct(LocaleRequirementGeneratorInterface $localeRequirementGenerator, string $defaultLocale)
    {
        $this->localeRequirementGenerator = $localeRequirementGenerator;
        $this->defaultLocale = $defaultLocale;
    }

    public function generate(string $name, Route $route): RouteCollection
    {
        $collection = new RouteCollection();
        $collection->add($name, $route);

        if (false === $route->getOption('i18n')) {
            return $collection;
        }

        $route->setPath(rtrim('/{_locale}'.$route->getPath(), '/'));
        $route->setRequirement('_locale', $this->localeRequirementGenerator->generate());
        $route->setDefault('_locale', $this->defaultLocale);

        return $collection;
    }
}
