<?php namespace Rdehnhardt\Assets\Providers;

use Illuminate\Support\ServiceProvider;
use Laracasts\Commander\CommanderTrait;
use Rdehnhardt\Assets\Commander\GetAssetsTags\GetAssetsTagsCommand;

class AssetsServiceProvider extends ServiceProvider
{
    use CommanderTrait;

    public function boot()
    {
        $this->package('rdehnhardt/assets');

        require __DIR__ . '/../Http/routes.php';
    }

    public function register()
    {
        $this->app->register('Laracasts\Commander\CommanderServiceProvider');
        $this->registerAssets();
    }

    protected function registerAssets()
    {
        $this->app->bind(
            'Assets',
            function ($app) {
                return $this->execute(GetAssetsTagsCommand::class, null);
            }
        );

        $this->app['assets'] = $this->app->share(
            function ($app) {
                return $this->execute(GetAssetsTagsCommand::class, null);
            }
        );
    }
}