<h3 align="center">
    <a href="https://github.com/umpirsky">
        <img src="https://farm2.staticflickr.com/1709/25098526884_ae4d50465f_o_d.png" />
    </a>
</h3>
<p align="center">
  <b>i18n routing bundle</b> &bull;
  <a href="https://github.com/umpirsky/Symfony-Upgrade-Fixer">symfony upgrade fixer</a> &bull;
  <a href="https://github.com/umpirsky/Twig-Gettext-Extractor">twig gettext extractor</a> &bull;
  <a href="https://github.com/umpirsky/wisdom">wisdom</a> &bull;
  <a href="https://github.com/umpirsky/centipede">centipede</a> &bull;
  <a href="https://github.com/umpirsky/PermissionsHandler">permissions handler</a>
</p>

# UmpirskyI18nRoutingBundle

Internationalized routing with minimal performance cost.

[![Build Status](https://travis-ci.org/umpirsky/UmpirskyI18nRoutingBundle.svg?branch=master)](https://travis-ci.org/umpirsky/UmpirskyI18nRoutingBundle)

## Idea

The idea is to create i18n route for each regular route in the project instead of creating separate route for each locale. On large projects with high number of routes and many locales supported this can lead to explosion of routes and performance issues. With more then 1000 routes and 30+ languages it can be a real problem.
With this bundle and `prefix` strategy there is no performance cost. For `prefix_except_default` number of routes is doubled, but again, does not depend on number of languages.

## Installation

```
composer require umpirsky/i18n-routing-bundle
```

```php
<?php

class AppKernel extends Kernel
{
    public function registerBundles()
    {
        return [
            // ...
            new Umpirsky\I18nRoutingBundle\UmpirskyI18nRoutingBundle(),
        ];
    }
}
```

## Configuration

```yaml
umpirsky_i18n_routing:
    default_locale: en
    locales: [en, sr, ru]
```

## Usage

### Disabling i18n routing on route level

If you want route not to be localized, you can disable it using `i18n` option:

```yaml
foo:
    path: /foo
    options:
        i18n: false
```

## Strategies

There are multiple routing strategies supported.

### prefix

This will prefix all urls with given locales:

```
/en/foo
/sr/foo
/ru/foo
```

Configuration:

```yaml
umpirsky_i18n_routing:
    default_locale: en
    locales: [en, sr, ru]
    strategy: prefix
```

### prefix_except_default

This will prefix all urls with given locales except default:

```
/foo
/sr/foo
/ru/foo
```

Configuration:

```yaml
umpirsky_i18n_routing:
    default_locale: en
    locales: [en, sr, ru]
    strategy: prefix_except_default
```

## Example

There is example integration with [Symfony Standard Edition](https://github.com/umpirsky/symfony-standard/tree/umpirsky/i18n-routing-bundle).

## Inspiration

This bundle is inspired by [JMSI18nRoutingBundle](https://github.com/schmittjoh/JMSI18nRoutingBundle) and [BeSimpleI18nRoutingBundle](https://github.com/BeSimple/BeSimpleI18nRoutingBundle), but sacrifices the url translation feature for the sake of performance.
