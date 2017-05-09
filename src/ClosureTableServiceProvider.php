<?php

namespace Soda\ClosureTable;

use Illuminate\Support\ServiceProvider;
use Soda\ClosureTable\Console\ClosureTableCommand;

/**
 * ClosureTable service provider.
 */
class ClosureTableServiceProvider extends ServiceProvider
{
    /**
     * Current library version.
     */
    const VERSION = 4;

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
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        // Here we register commands for artisan
        $this->app->singleton('command.closuretable', function ($app) {
            return new ClosureTableCommand;
        });

        $this->app->singleton('command.closuretable.make', function ($app) {
            return $app['Soda\ClosureTable\Console\MakeCommand'];
        });

        $this->commands('command.closuretable', 'command.closuretable.make');
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return [];
    }
}
