<?php

namespace Umpirsky\I18nRoutingBundle\Routing\Factory;

use Symfony\Component\Routing\Route;
use Umpirsky\I18nRoutingBundle\Routing\Generator\LocaleRequirementGeneratorInterface;

class I18nRouteFactory implements I18nRouteFactoryInterface
{
    private $localeRequirementGenerator;

    public function __construct(LocaleRequirementGeneratorInterface $localeRequirementGenerator)
    {
        $this->localeRequirementGenerator = $localeRequirementGenerator;
    }

    public function generateName(string $name): string
    {
        return $name;
    }

    public function create(Route $route): Route
    {
        $i18nRoute = clone $route;

        $i18nRoute->setPath(rtrim('/{_locale}'.$route->getPath(), '/'));
        $i18nRoute->setRequirement('_locale', $this->localeRequirementGenerator->generate());

        return $i18nRoute;
    }
}
