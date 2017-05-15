<?php

namespace Umpirsky\I18nRoutingBundle\Routing;

use Symfony\Bundle\FrameworkBundle\Routing\Router as BaseRouter;
use Symfony\Component\Routing\Exception\RouteNotFoundException;
use Symfony\Component\Routing\RequestContext;
use Symfony\Component\DependencyInjection\ContainerInterface;
use InvalidArgumentException;

class Router extends BaseRouter
{
    private $routeNameSuffix;
    private $defaultLocale;

    public function __construct(ContainerInterface $container, $resource, array $options = [], RequestContext $context = null)
    {
        if (!array_key_exists('i18n_route_name_suffix', $options)) {
            throw new InvalidArgumentException('Router requires "i18n_route_name_suffix" option.');
        }
        if (!array_key_exists('i18n_default_locale', $options)) {
            throw new InvalidArgumentException('Router requires "i18n_default_locale" option.');
        }

        $this->routeNameSuffix = $options['i18n_route_name_suffix'];
        $this->defaultLocale = $options['i18n_route_name_suffix'];
        unset($options['i18n_route_name_suffix']);
        unset($options['i18n_default_locale']);

        parent::__construct($container, $resource, $options, $context);
    }

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
        if (!array_key_exists('_locale', $parameters) && (!$this->context->hasParameter('_locale') || $this->defaultLocale === $this->context->getParameter('_locale'))) {
            return parent::generate($name, $parameters, $referenceType);
        }

        $parameters['_locale'] = array_key_exists('_locale', $parameters) ? $parameters['_locale'] : $this->context->getParameter('_locale');

        return parent::generate($name.$this->routeNameSuffix, $parameters, $referenceType);
    }
}
