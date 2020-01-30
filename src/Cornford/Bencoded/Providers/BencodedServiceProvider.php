<?php namespace Cornford\Bencoded\Providers;

use Cornford\Bencoded\Bencoded;
use Illuminate\Support\ServiceProvider;

class BencodedServiceProvider extends ServiceProvider
{

    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = true;

    /**
     * Bootstrap the application events.
     *
     * @return void
     */
    public function boot()
    {
        $this->package('cornford/bencoded');
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->app['bencoded'] = $this->app->share(function()
        {
            return (new Bencoded());
        });
    }

    /**
     * Get the services provided by the provider.
     *
     * @return string[]
     */
    public function provides()
    {
        return ['bencoded'];
    }
}
