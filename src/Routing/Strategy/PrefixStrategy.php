<?php

namespace Umpirsky\I18nRoutingBundle\Routing\Strategy;

use Symfony\Component\Routing\Route;
use Symfony\Component\Routing\RouteCollection;

class PrefixStrategy extends AbstractStrategy
{
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
