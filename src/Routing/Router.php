<?php

namespace Umpirsky\I18nRoutingBundle\Routing;

use Symfony\Bundle\FrameworkBundle\Routing\Router as BaseRouter;
use Symfony\Component\Routing\Exception\RouteNotFoundException;

class Router extends BaseRouter
{
    public function generate($name, $parameters = [], $referenceType = self::ABSOLUTE_PATH)
    {
        try {
            return $this->generateI18n($name, $parameters, $referenceType);
        } catch (RouteNotFoundException $e) { }

        return parent::generate($name, $parameters, $referenceType);
    }

    /**
     * @todo Inject route name suffix
     */
    private function generateI18n($name, $parameters = [], $referenceType = self::ABSOLUTE_PATH)
    {
        if (!array_key_exists('_locale', $parameters) && !$this->context->hasParameter('_locale')) {
            return parent::generate($name, $parameters, $referenceType);
        }

        $parameters['_locale'] = array_key_exists('_locale', $parameters) ? $parameters['_locale'] : $this->context->getParameter('_locale');

        return parent::generate($name.'_i18n', $parameters, $referenceType);
    }
}
