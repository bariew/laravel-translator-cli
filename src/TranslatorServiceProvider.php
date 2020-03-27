<?php namespace Bariew\Translator;

use Illuminate\Support\ServiceProvider;

/**
 * The TranslatorServiceProvider class.
 *
 * @author bariew <bariew@yandex.ru>
 */
class TranslatorServiceProvider extends ServiceProvider {

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
		$this->package('bariew/laravel-translator-cli');
	}

	/**
	 * Register the service provider.
	 *
	 * @return void
	 */
	public function register()
	{
		$this->app['translator.command.generate'] = $this->app->share(function ($app) {
            return new Commands\TranslatorGenerateCommand($app['files'], $app['config']);
        });
        $this->commands('translator.command.generate');
	}

	/**
	 * Get the services provided by the provider.
	 *
	 * @return array
	 */
	public function provides()
	{
		return array('translator.command.generate');
	}

}
