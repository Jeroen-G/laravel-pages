<?php namespace JeroenG\LaravelPages;

use Illuminate\Support\ServiceProvider;

/**
 * This is the service provider for Laravel.
 *
 * Place the line below in the providers array inside app/config/app.php
 * <code>'JeroenG\LaravelPages\LaravelPagesServiceProvider',</code>
 * And this line into the alias array in the same file
 * <code>'LPages' => 'JeroenG\LaravelPages\Facades\LaravelPages',</code>
 *
 * @package LaravelPages
 * @author 	JeroenG
 * 
 **/
class LaravelPagesServiceProvider extends ServiceProvider {

	/**
	 * Indicates if loading of the provider is deferred.
	 *
	 * @var bool
	 */
	protected $defer = false;

	/**
	 * Bootstrap the application events.
	 *
	 * @return void
	 */
	public function boot()
	{
		$this->publishes([
            __DIR__.'/../../migrations' => $this->app->databasePath().'/migrations',
        ]);
	}

	/**
	 * Register the service provider.
	 *
	 * @return void
	 */
	public function register()
	{
		$this->app['laravelpages'] = $this->app->share( function ($app)
            {
                return new LaravelPages;
            }
        );
	}

	/**
	 * Get the services provided by the provider.
	 *
	 * @return array
	 */
	public function provides()
	{
		return array('laravelpages');
	}

}