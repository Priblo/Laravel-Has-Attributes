<?php
namespace Priblo\LaravelHasSettings;
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
        $this->app->singleton(HasSettingRepositoryInterface::class, function () {
            $baseRepo = new EloquentHasSettingRepository(new HasSetting);
            return $baseRepo;
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
    }

}