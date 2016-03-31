# Wiki for Laravel 5.1

This is wiki for **Laravel 5.1**.

## Table of content

* [Features](#features)
* [Installation](#installation)
* [Usage](#usage)

---
[Back to top][url]

## Features

* popular markdown syntax
* page history
* configurable

## Installation

1. Create your laravel project as usual
2. Via `composer` (make sure to allow dev stability): `composer require vi-kon/laravel-wiki`
3. In your `app.php` add the entry `ViKon\Wiki\WikiServiceProvider::class,` to the providers array
4. Call `php artisan vendor:publish --provider="ViKon\Wiki\WikiServiceProvider"` command
4. Call `php artisan migrate` command
5. Call `php artisan vi-kon:wiki:install` command (This will seed database with required entries)

Now browse to the path `/wiki` of your project.

Add following lines `providers` array found in `app.php` file:

```php
// Wiki
\ViKon\Wiki\WikiServiceProvider::class,
// Dependencies
\ViKon\Support\SupportServiceProvider::class,
\ViKon\Auth\AuthServiceProvider::class,
\ViKon\Bootstrap\BootstrapServiceProvider::class,
\ViKon\DbConfig\DbConfigServiceProvider::class,
\Collective\Html\HtmlServiceProvider::class,
```

---
[Back to top][url]

## License

This package is licensed under the MIT License

---
[Back to top][url]

[url]: #wiki-for-laravel-5
