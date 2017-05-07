<?php

namespace Umpirsky\I18nRoutingBundle\Routing;

interface LocaleRequirementGeneratorInterface
{
    public function generate(): string;
}
