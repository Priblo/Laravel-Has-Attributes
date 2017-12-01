<?php
namespace Priblo\LaravelHasAttributes;
use Priblo\LaravelHasAttributes\Repositories\Decorators\CachingHasAttributeRepository;
use Illuminate\Support\ServiceProvider as IlluminateServiceProvider;
use Priblo\LaravelHasAttributes\Models\HasAttribute;
use Priblo\LaravelHasAttributes\Repositories\EloquentHasAttributeRepository;
use Priblo\LaravelHasAttributes\Repositories\Interfaces\HasAttributeRepositoryInterface;

/**
 * Class LaravelServiceProvider
 * @package Priblo\LaravelHasAttributes\Laravel
 */
class LaravelServiceProvider extends IlluminateServiceProvider {

    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = false;

    /**
     * Register the service provider.
     *
     * @throws \Exception
     * @return void
     */
    public function register()
    {
        $configPath = __DIR__ . '/../config/has-attributes.php';
        $this->mergeConfigFrom($configPath, 'has-attributes');

        $this->app->singleton(HasAttributeRepositoryInterface::class, function () {
            $baseRepo = new EloquentHasAttributeRepository(new HasAttribute);
            if(config('has-attributes.caching_enabled')===false) {
                return $baseRepo;
            }
            return new CachingHasAttributeRepository($baseRepo, $this->app['cache.store']);
        });
    }

    /**
     * Boots the package
     */
    public function boot()
    {
        $this->publishes([
            __DIR__.'/../migrations' => database_path('migrations')
        ], 'migrations');
        $this->publishes([
            __DIR__ . '/../config/has-attributes.php' => config_path('has-attributes.php')
        ], 'config');
    }

}