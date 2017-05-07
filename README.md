# UmpirskyI18nRoutingBundle

Internationalized routing with minimal performance cost.

[![Build Status](https://travis-ci.org/umpirsky/UmpirskyI18nRoutingBundle.svg?branch=master)](https://travis-ci.org/umpirsky/UmpirskyI18nRoutingBundle)

## Idea

The idea is to create i18n route for each regular route in the project instead of creating separate route for each locale. On large projects with high number of routes and many locales supported this can lead to explosion of routes and performance issues.
