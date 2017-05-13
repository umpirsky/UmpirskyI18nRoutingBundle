<?php

namespace Umpirsky\I18nRoutingBundle\Routing\Generator;

use Symfony\Component\Routing\Generator\UrlGenerator as BaseUrlGenerator;

class UrlGenerator extends BaseUrlGenerator
{
    protected function doGenerate($variables, $defaults, $requirements, $tokens, $parameters, $name, $referenceType, $hostTokens, array $requiredSchemes = [])
    {
        if (!array_key_exists('_locale', $parameters) && $this->context->hasParameter('_locale')) {
            $name = $name.'_i18n';
            $parameters['_locale'] = $this->context->getParameter('_locale');
        }

        return parent::doGenerate($variables, $defaults, $requirements, $tokens, $parameters, $name, $referenceType, $hostTokens, $requiredSchemes);
    }
}
