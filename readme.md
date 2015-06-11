Laravel Pages
=====================

Simple pages package for Laravel 5. For laravel 4, use version 1 of this package.

[![Scrutinizer Quality Score](https://scrutinizer-ci.com/g/Jeroen-G/laravel-pages/badges/quality-score.png?s=a0e8e2ce3e6f07bb1171e5257b3224a60427bb3c)](https://scrutinizer-ci.com/g/Jeroen-G/laravel-pages/)
[![Latest Stable Version](https://img.shields.io/github/release/jeroen-g/activity-logger.svg?style=flat)](https://github.com/jeroen-g/laravel-pages/releases)
[![License](https://img.shields.io/badge/License-EUPL--1.1-blue.svg?style=flat)](license.md)

## Installation

Via Composer
``` bash
$ composer require jeroen-g/laravel-pages
```

The following command installs the package without the testing requirements.
``` bash
$ composer require jeroen-g/laravel-pages --update-no-dev
```

The next step is to add the service provider in `app/config/app.php`:

    JeroenG\LaravelPages\LaravelPagesServiceProvider::class,

And in the same file, add the alias:

	'LPages'   =>  JeroenG\LaravelPages\Facades\LaravelPages::class,


Then publish the package's migration files.

    $ artisan vendor:publish

The last thing to do is to migrate:

    $ artisan migrate

## Usage
This package does not provide controllers and routes. To show pages you could use the route below. You'll need a page view to show the data from the database.
```php
Route::get('{uri?}', function($uri)
{
	if(LPages::pageExists($uri))
	{
		$pageData = LPages::getPage($uri);
		return View::make('page', $pageData);
	}
	else
	{
		App::abort(404, 'Page Not Found');
	}
});
```
Have a look at `src\JeroenG\LaravelPages\LaravelPages.php` to see what this package can do and what each function needs. Everything is documented.