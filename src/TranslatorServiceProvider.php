<?php

namespace Bariew\Translator;

use Bariew\Translator\Commands\GenerateCommand;
use Illuminate\Routing\Router;
use Illuminate\Support\ServiceProvider;

class TranslatorServiceProvider extends ServiceProvider
{
    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = false;

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->publishes([dirname(__DIR__) . '/config/translator.php' => config_path('translator.php')], 'config');
    }

    /**
     * Bootstrap the application events.
     *
     * @return void
     */
    public function boot()
    {

        if ($this->app->runningInConsole()) {
            $this->commands([
                GenerateCommand::class,
            ]);
        }
    }
}
