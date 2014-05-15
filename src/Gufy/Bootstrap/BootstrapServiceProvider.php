<?php namespace Gufy\Bootstrap;

use Illuminate\Support\ServiceProvider;

class BootstrapServiceProvider extends ServiceProvider {

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
		$this->package('gufy/bootstrap');
	}

	/**
	 * Register the service provider.
	 *
	 * @return void
	 */
	public function register()
	{
		//
		$this->app['bootstrap.install'] = $this->app->share(function($app){
			return new Commands\BootstrapInstall;
		});
		$this->app['bootstrap.list'] = $this->app->share(function($app){
			return new Commands\BootstrapList;
		});
		$this->app['bootstrap.update'] = $this->app->share(function($app){
			return new Commands\BootstrapUpdate;
		});
		$this->commands('bootstrap.install');
		$this->commands('bootstrap.list');
		$this->commands('bootstrap.update');
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
