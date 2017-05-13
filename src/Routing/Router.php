<?php

namespace Umpirsky\I18nRoutingBundle\Routing;

use Symfony\Bundle\FrameworkBundle\Routing\Router as BaseRouter;

class Router extends BaseRouter
{
    public function generate($name, $parameters = [], $referenceType = self::ABSOLUTE_PATH)
    {
        if (array_key_exists('_locale', $parameters) || $this->context->hasParameter('_locale')) {
            $name = $name.'_i18n';
            $parameters['_locale'] = array_key_exists('_locale', $parameters) ? $parameters['_locale'] : $this->context->getParameter('_locale');
        }

        return parent::generate($name, $parameters, $referenceType);
    }
}
