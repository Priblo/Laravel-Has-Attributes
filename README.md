Laravel Has Settings
============
###### Persisent settings on any Eloquent model
[![Build Status](https://travis-ci.org/Priblo/Laravel-Has-Settings.svg?branch=master)](https://travis-ci.org/Priblo/Laravel-Has-Settings)
[![Codacy Badge](https://api.codacy.com/project/badge/Grade/4553569f57244a09a27ec556654b78f0)](https://www.codacy.com/app/0plus1/Laravel-Has-Settings?utm_source=github.com&amp;utm_medium=referral&amp;utm_content=Priblo/Laravel-Has-Settings&amp;utm_campaign=Badge_Grade)

This package provides a trait to attach settings to any Eloquent model.

Settings are stored following the [Entity-Attribute-Value model](https://en.wikipedia.org/wiki/Entity%E2%80%93attribute%E2%80%93value_model). Data is abstracted using the [Decorator pattern](https://en.wikipedia.org/wiki/Decorator_pattern).

## Install

**Composer**

```
    composer require priblo/laravel-has-settings
```

**Laravel**

This package supports Auto Discovery. If your Laravel version doesn't support it or you have disabled it, you can install this package by adding to the 'providers' array in *./config/app.php*

```php
Priblo\LaravelHasSettings\LaravelServiceProvider::class,
```


Then run:

```
php artisan vendor:publish --provider="Priblo\LaravelHasSettings\LaravelServiceProvider" --tag="migrations"
php artisan vendor:publish --provider="Priblo\LaravelHasSettings\LaravelServiceProvider" --tag="config"
```

Then migrate:

```
php artisan migrate
```

## Cache
**Caching requires a driver which supports tags**. File and Database won't work. Please make sure to either disable caching in the config or use the array driver for local development.

In the *has-settings.php* config file you can enable/disable caching and set the cache expiration time.

**Caching is enabled by default**

## Notes

Please do remember that each of the settings in a EAV model are set as string, thus a value of *true* will be stored as *"1"*

## Roadmap
* More tests
* Expand README.MD