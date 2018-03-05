Laravel Has Attributes
============
###### EAV Attributes in an handy Trait
[![Build Status](https://travis-ci.org/Priblo/Laravel-Has-Attributes.svg?branch=master)](https://travis-ci.org/Priblo/Laravel-Has-Settings)
[![Codacy Badge](https://api.codacy.com/project/badge/Grade/fa7f45945f53451ea768d3572a421383)](https://www.codacy.com/app/0plus1/Laravel-Has-Attributes?utm_source=github.com&amp;utm_medium=referral&amp;utm_content=Priblo/Laravel-Has-Attributes&amp;utm_campaign=Badge_Grade)

This package provides a trait to attach attributes to any Eloquent model. The common use case is to add Settings to a model.

Attributes are stored following the [Entity-Attribute-Value model](https://en.wikipedia.org/wiki/Entity%E2%80%93attribute%E2%80%93value_model). Data is abstracted using the [Decorator pattern](https://en.wikipedia.org/wiki/Decorator_pattern).

## Install

_Requires: Laravel >=5.4_

**Composer**

```
    composer require priblo/laravel-has-attributes
```

**Laravel**

This package supports Auto Discovery. If your Laravel version doesn't support it or you have disabled it, you can install this package by adding to the 'providers' array in *./config/app.php*

```php
Priblo\LaravelHasAttributes\LaravelServiceProvider::class,
```


Then run:

```
php artisan vendor:publish --provider="Priblo\LaravelHasAttributes\LaravelServiceProvider" --tag="migrations"
php artisan vendor:publish --provider="Priblo\LaravelHasAttributes\LaravelServiceProvider" --tag="config"
```

Then migrate:

```
php artisan migrate
```

## Cache
**Caching requires a driver which supports tags**. File and Database won't work, redis is suggested. Please make sure to either disable caching in the config or use the array driver for local development.

In the *has-settings.php* config file you can enable/disable caching and set the cache expiration time.

**Caching is enabled by default**

## Notes

Please do remember that each of the settings in a EAV model are set in a TEXT field, thus a value of *true* will be stored as *"1"*

## Roadmap
* More tests
* Expand README.MD