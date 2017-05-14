<?php

namespace Umpirsky\I18nRoutingBundle\Routing\Strategy;

use Umpirsky\I18nRoutingBundle\Routing\Generator\LocaleRequirementGeneratorInterface;

abstract class AbstractStrategy implements StrategyInterface
{
    protected $localeRequirementGenerator;
    protected $defaultLocale;

    public function __construct(LocaleRequirementGeneratorInterface $localeRequirementGenerator, string $defaultLocale)
    {
        $this->localeRequirementGenerator = $localeRequirementGenerator;
        $this->defaultLocale = $defaultLocale;
    }
}
