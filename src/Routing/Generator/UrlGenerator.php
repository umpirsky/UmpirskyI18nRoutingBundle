<?php

namespace Umpirsky\I18nRoutingBundle\Routing\Generator;

use Symfony\Component\Routing\Generator\UrlGenerator as BaseUrlGenerator;

class UrlGenerator extends BaseUrlGenerator
{
    public function generate($name, $parameters = [], $referenceType = self::ABSOLUTE_PATH)
    {
        if (!array_key_exists('_locale', $parameters) && $this->context->hasParameter('_locale')) {
            $name = $name.'_i18n';
            $parameters['_locale'] = $this->context->getParameter('_locale');
        }

        return parent::generate($name, $parameters, $referenceType);
    }
}
