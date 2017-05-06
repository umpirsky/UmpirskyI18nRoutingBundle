<?php

namespace Umpirsky\I18nRoutingBundle\Routing;

use Symfony\Component\Routing\Route;

class I18nRouteFactory
{
    private $localeRequirementGenerator;

    public function __construct(LocaleRequirementGenerator $localeRequirementGenerator)
    {
        $this->localeRequirementGenerator = $localeRequirementGenerator;
    }

    public function create(Route $route): Route
    {
        $i18nRoute = clone $route;

        $i18nRoute->setPath(rtrim('/{_locale}'.$route->getPath(), '/'));
        $i18nRoute->setRequirement('_locale', $this->localeRequirementGenerator->generate());

        return $i18nRoute;
    }
}
