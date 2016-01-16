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

1. Create your laravel project as usual.
2. Via `composer` (make sure to allow dev stability): `composer require vi-kon/laravel-wiki`
3. In your `app.php` add the entry `ViKon\Wiki\WikiServiceProvider::class,` to the providers array.
4. Call `php artisan vendor:publish --provider="ViKon\Wiki\WikiServiceProvider"`

Now browse to the path `/wiki` of your project.

---
[Back to top][url]

## License

This package is licensed under the MIT License

---
[Back to top][url]

[url]: #wiki-for-laravel-5
