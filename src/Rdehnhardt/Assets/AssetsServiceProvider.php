<?php namespace Rdehnhardt\Assets;

use Illuminate\Support\ServiceProvider;
use Illuminate\Foundation\AliasLoader;

class AssetsServiceProvider extends ServiceProvider
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
        $this->package('rdehnhardt/assets');

        $this->app->booting(
            function () {
                $loader = AliasLoader::getInstance();
                $loader->alias('Assets', 'Rdehnhardt\Assets\Facades\Assets');
            }
        );

        require __DIR__ . '/Http/routes.php';
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
    }

    /**
     * Register the commander service provider.
     *
     * @return void
     */
    public function registerCommander()
    {
        $providers = Config::get('assets::app');
    }

    public function registerAssets()
    {
        $this->app->bind(
            'Assets',
            function ($app) {
                return new Assets;
            }
        );

        $this->app['assets'] = $this->app->share(
            function ($app) {
                return new Assets;
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
        return array();
    }

}
