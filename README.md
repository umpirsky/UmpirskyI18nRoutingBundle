# UmpirskyI18nRoutingBundle

Internationalized routing with minimal performance cost.

[![Build Status](https://travis-ci.org/umpirsky/UmpirskyI18nRoutingBundle.svg?branch=master)](https://travis-ci.org/umpirsky/UmpirskyI18nRoutingBundle)

## Idea

The idea is to create i18n route for each regular route in the project instead of creating separate route for each locale. On large projects with high number of routes and many locales supported this can lead to explosion of routes and performance issues.

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
    locales: [en, sr, ru, pl]
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

## Example

There is example integration with [Symfony Standard Edition](https://github.com/umpirsky/symfony-standard/tree/umpirsky/i18n-routing-bundle).
