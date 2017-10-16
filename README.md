Laravel Has Settings
============
###### Persisent settings on any Eloquent model
[![Build Status](https://travis-ci.org/Priblo/Laravel-Has-Settings.svg?branch=master)](https://travis-ci.org/Priblo/Laravel-Has-Settings)
[![Codacy Badge](https://api.codacy.com/project/badge/Grade/4553569f57244a09a27ec556654b78f0)](https://www.codacy.com/app/0plus1/Laravel-Has-Settings?utm_source=github.com&amp;utm_medium=referral&amp;utm_content=Priblo/Laravel-Has-Settings&amp;utm_campaign=Badge_Grade)

This package provides a trait to attach settings to any Eloquent model.

Settings are stored following the [Entity-Attribute-Value model](https://en.wikipedia.org/wiki/Entity%E2%80%93attribute%E2%80%93value_model). Data is abstracted using the [Decorator pattern](https://en.wikipedia.org/wiki/Decorator_pattern).

## Install

**Composer**

Until this package is deemed stable e installation through composer must be done using the repositories option of Composer

```
    "minimum-stability": "dev",
    "prefer-stable": true,
    "repositories": [
        {
            "type": "vcs",
            "no-api": true,
            "url": "git@github.com:Priblo/Laravel-Has-Settings.git"
        }
    ],
```

Then:

``` composer install priblo/laravel-has-settings```

**Laravel**

In *./config/app.php*

Add:

```php
Priblo\LaravelUserSettings\LaravelHasSettings::class,
```

To the 'providers' array.

Then run:

```
php artisan vendor:publish --provider="Priblo\LaravelHasSettings\LaravelServiceProvider" --tag="migrations"
```

Then migrate:

```
php artisan migrate
```

## Notes

Please do remember that each of the settings in a EAV model are set as string, thus a value of *true* will be stored as *"1"*

## Roadmap
* Cache decorator
* Tests
* Expand README.MD