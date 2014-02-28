<?php namespace JeroenG\LaravelPages\Facades;

use Illuminate\Support\Facades\Facade;

class LaravelPages extends Facade {

	/**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'laravelpages';
    }
}