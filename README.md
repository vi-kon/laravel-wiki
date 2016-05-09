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
4. Call `php artisan vendor:publish` command (this will publish every vendor assets)
4. Call `php artisan migrate` command
5. Call `php artisan vi-kon:wiki:install` command (This will seed database with required entries)
6. Install `npm` and `bower` packages to publish public assets

Now browse to the path `/wiki` of your project.

Add following lines `providers` array found in `app.php` file:

```php
// Wiki
\ViKon\Wiki\WikiServiceProvider::class,
```

Required npm packages (`package.json` in project's root directory):

```json
{
    "private"     : true,
    "dependencies": {
        "bower"          : "^1.7.9",
        "gulp"           : "^3.9.1",
        "gulp-clean"     : "^0.3.2",
        "gulp-concat"    : "^2.6.0",
        "gulp-debug"     : "^2.1.2",
        "gulp-less"      : "^3.0.5",
        "gulp-livereload": "^3.8.1",
        "gulp-minify-css": "^1.2.4",
        "gulp-notify"    : "^2.2.0",
        "gulp-rename"    : "^1.2.2",
        "gulp-rev"       : "^7.0.0",
        "gulp-sourcemaps": "^1.6.0",
        "gulp-uglify"    : "^1.5.3",
        "less"           : "^2.6.1",
        "rev-del"        : "^1.0.5",
        "underscore"     : "^1.8.3"
    }
}
```

Required bower packages (`bower.json` in project's root directory):

```json
{
    "name"        : "laravel-5.2-wiki",
    "version"     : "1.0.0",
    "description" : "Wiki Engine",
    "moduleType"  : [
        "node"
    ],
    "authors"     : [
        "Kovács Vince"
    ],
    "license"     : "MIT",
    "ignore"      : [
        "**/.*",
        "node_modules",
        "bower_components",
        "test",
        "tests"
    ],
    "dependencies": {
        "bootstrap"     : "^3.3.6",
        "jquery"        : "~2.1.4",
        "jquery-timeago": "~1.4.3",
        "codemirror"    : "~5.10.0"
    }
}
```

Gulp tasks for publishing assets (`guplfile.js` in project's root directory):

```js
var path       = require('path');
var Gulper     = require('./vendor/vi-kon/laravel-support/src/resources/assets/Gulper');
var WikiGulper = require('./vendor/vi-kon/laravel-wiki/src/resources/assets/WikiGulper');

var gulper = new Gulper();

var __bower_components = path.join(__dirname, 'bower_components');

gulper
    .buildPath(path.join(__dirname, 'public', 'build'))
    .setBowerComponentsDirname(__bower_components)
    .registerLessInclude(__bower_components)
    .registerCssTask([
                         path.join(__bower_components, 'bootstrap', 'less', 'bootstrap.less'),
                         path.join(__bower_components, 'codemirror', 'lib', 'codemirror.css')
                     ], path.join('css', 'main.css'))
    .registerJsTask([
                        path.join(__bower_components, 'jquery', 'dist', 'jquery.js'),
                        path.join(__bower_components, 'jquery-timeago', 'jquery.timeago.js'),
                        path.join(__bower_components, 'bootstrap', 'dist', 'js', 'bootstrap.js'),
                        path.join(__bower_components, 'codemirror', 'lib', 'codemirror.js'),
                        path.join(__bower_components, 'codemirror', 'mode', 'markdown', 'markdown.js')
                    ], path.join('js', 'main.js'));

new WikiGulper(gulper);

gulper.registerTasks();

```


---
[Back to top][url]

## License

This package is licensed under the MIT License

---
[Back to top][url]

[url]: #wiki-for-laravel-5
