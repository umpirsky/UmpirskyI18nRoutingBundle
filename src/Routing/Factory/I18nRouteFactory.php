<?php

namespace Umpirsky\I18nRoutingBundle\Routing\Factory;

use Symfony\Component\Routing\Route;
use Umpirsky\I18nRoutingBundle\Routing\Generator\LocaleRequirementGeneratorInterface;

class I18nRouteFactory implements I18nRouteFactoryInterface
{
    private $localeRequirementGenerator;
    private $defaultLocale;

    public function __construct(LocaleRequirementGeneratorInterface $localeRequirementGenerator, string $defaultLocale)
    {
        $this->localeRequirementGenerator = $localeRequirementGenerator;
        $this->defaultLocale = $defaultLocale;
    }

    public function generateName(string $name): string
    {
        return $name;
    }

    public function create(Route $route): Route
    {
        if (false === $route->getOption('i18n')) {
            return $route;
        }

        $i18nRoute = clone $route;

        $i18nRoute->setPath(rtrim('/{_locale}'.$route->getPath(), '/'));
        $i18nRoute->setRequirement('_locale', $this->localeRequirementGenerator->generate());
        $i18nRoute->setDefault('_locale', $this->defaultLocale);

        return $i18nRoute;
    }
}
