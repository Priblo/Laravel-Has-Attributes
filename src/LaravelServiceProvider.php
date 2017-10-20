<?php
namespace Priblo\LaravelHasSettings;
use Priblo\LaravelHasSettings\Repositories\Decorators\CachingHasSettingRepository;
use Illuminate\Support\ServiceProvider as IlluminateServiceProvider;
use Priblo\LaravelHasSettings\Models\HasSetting;
use Priblo\LaravelHasSettings\Repositories\EloquentHasSettingRepository;
use Priblo\LaravelHasSettings\Repositories\Interfaces\HasSettingRepositoryInterface;

/**
 * Class LaravelServiceProvider
 * @package Priblo\LaravelHasSettings\Laravel
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
        $configPath = __DIR__ . '/../config/has-settings.php';
        $this->mergeConfigFrom($configPath, 'has-settings');

        $this->app->singleton(HasSettingRepositoryInterface::class, function () {
            $baseRepo = new EloquentHasSettingRepository(new HasSetting);
            if(config('has-settings.caching_enabled')===false) {
                return $baseRepo;
            }
            return new CachingHasSettingRepository($baseRepo, $this->app['cache.store']);
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
            __DIR__ . '/../config/has-settings.php' => config_path('has-settings.php')
        ], 'config');
    }

}