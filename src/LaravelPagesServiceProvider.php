<?php

namespace JeroenG\LaravelPages;

use Illuminate\Support\ServiceProvider;

/**
 * This is the service provider for Laravel.
 *
 * Place the line below in the providers array inside app/config/app.php
 * <code>'JeroenG\LaravelPages\LaravelPagesServiceProvider',</code>
 * And this line into the alias array in the same file
 * <code>'LPages' => 'JeroenG\LaravelPages\Facades\LaravelPages',</code>
 *
 * @author 	JeroenG
 **/
class LaravelPagesServiceProvider extends ServiceProvider
{
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
        $this->loadMigrationsFrom(__DIR__.'/../migrations');
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton('laravelpages', function ($app) {
            return new LaravelPages;
        });
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return ['laravelpages'];
    }
}
