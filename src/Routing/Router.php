<?php

namespace Umpirsky\I18nRoutingBundle\Routing;

use Symfony\Bundle\FrameworkBundle\Routing\Router as BaseRouter;
use Symfony\Component\Routing\Exception\RouteNotFoundException;

class Router extends BaseRouter
{
    public function generate($name, $parameters = [], $referenceType = self::ABSOLUTE_PATH)
    {
        if (array_key_exists('_locale', $parameters) || $this->context->hasParameter('_locale')) {
            $i18nName = $name.'_i18n';

            $i18nParameters = $parameters;
            $i18nParameters['_locale'] = array_key_exists('_locale', $parameters) ? $parameters['_locale'] : $this->context->getParameter('_locale');

            try {
                return parent::generate($i18nName, $i18nParameters, $referenceType);
            } catch (RouteNotFoundException $e) { }
        }

        return parent::generate($name, $parameters, $referenceType);
    }
}
