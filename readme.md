Laravel Pages
=====================

Simple pages package for Laravel 4.1

## Installation
First you should install this package through Composer and edit your project's `composer.json`:

    "require": {
		"laravel/framework": "4.1.*",
		"jeroen-g/laravel-pages": "v1.*"
	}

Next, update Composer via the command line:

    composer update

The next step is to add the service provider in `app/config/app.php`:

    'JeroenG\LaravelPages\LaravelPagesServiceProvider',

And in the same file, add the alias:

	'LPages'          => 'JeroenG\LaravelPages\Facades\LaravelPages',


The last thing to do is to migrate to create the pages table:

	php artisan migrate --package="jeroen-g/laravel-pages"

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