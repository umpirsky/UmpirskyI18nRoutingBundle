<?php

namespace Umpirsky\I18nRoutingBundle\Routing;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\CacheWarmer\WarmableInterface;
use Symfony\Component\Routing\Exception\RouteNotFoundException;
use Symfony\Component\Routing\Matcher\RequestMatcherInterface;
use Symfony\Component\Routing\RequestContext;
use Symfony\Component\Routing\RouteCollection;
use Symfony\Component\Routing\RouterInterface;

/**
 * @author Kevin Bond <kevinbond@gmail.com>
 */
class Router implements RouterInterface, RequestMatcherInterface, WarmableInterface
{
    private $router;
    private $routeNameSuffix;
    private $defaultLocale;

    public function __construct(RouterInterface $router, string $routeNameSuffix, string $defaultLocale)
    {
        if (!$router instanceof RequestMatcherInterface) {
            throw new \InvalidArgumentException('The wrapped router must implement '.RequestMatcherInterface::class);
        }

        $this->router = $router;
        $this->routeNameSuffix = $routeNameSuffix;
        $this->defaultLocale = $defaultLocale;
    }

    public function setContext(RequestContext $context): void
    {
        $this->router->setContext($context);
    }

    public function getContext(): RequestContext
    {
        return $this->router->getContext();
    }

    public function getRouteCollection(): RouteCollection
    {
        return $this->router->getRouteCollection();
    }

    public function generate($name, $parameters = array(), $referenceType = self::ABSOLUTE_PATH): string
    {
        if (array_key_exists('_locale', $parameters) && $parameters['_locale'] === $this->defaultLocale) {
            unset($parameters['_locale']);

            return $this->router->generate($name, $parameters, $referenceType);
        }

        try {
            return $this->generateI18n($name, $parameters, $referenceType);
        } catch (RouteNotFoundException $e) { }

        return $this->router->generate($name, $parameters, $referenceType);
    }

    public function match($pathinfo): array
    {
        return $this->normalizeI18nMatch($this->router->match($pathinfo));
    }

    public function matchRequest(Request $request): array
    {
        return $this->normalizeI18nMatch($this->router->matchRequest($request));
    }

    public function warmUp($cacheDir, $buildDir = null): array
    {
        if ($this->router instanceof WarmableInterface) {
            return $this->router->warmUp($cacheDir);
        }

        return [];
    }

    /**
     * @todo Inject route name suffix
     */
    private function generateI18n($name, $parameters = [], $referenceType = self::ABSOLUTE_PATH): string
    {
        if (!array_key_exists('_locale', $parameters) && (!$this->getContext()->hasParameter('_locale') || $this->defaultLocale === $this->getContext()->getParameter('_locale'))) {
            return $this->router->generate($name, $parameters, $referenceType);
        }

        $parameters['_locale'] = array_key_exists('_locale', $parameters) ? $parameters['_locale'] : $this->getContext()->getParameter('_locale');

        return $this->router->generate($name.$this->routeNameSuffix, $parameters, $referenceType);
    }

    private function normalizeI18nMatch(array $parameters): array
    {
        $i18nPosition = strlen($parameters['_route']) - strlen($this->routeNameSuffix);

        if ($i18nPosition === strpos($parameters['_route'], $this->routeNameSuffix)) {
            $parameters['_route'] = substr($parameters['_route'], 0, $i18nPosition);
        }

        if (!array_key_exists('_locale', $parameters)) {
            $parameters['_locale'] = $this->defaultLocale;
        }

        return $parameters;
    }
}
