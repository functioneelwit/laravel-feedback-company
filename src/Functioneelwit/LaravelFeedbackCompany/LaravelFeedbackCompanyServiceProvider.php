<?php namespace Functioneelwit\LaravelFeedbackCompany;

use Illuminate\Support\ServiceProvider;

class LaravelFeedbackCompanyServiceProvider extends ServiceProvider {

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
		$this->package('functioneelwit/laravel-feedback-company');
	}

	/**
	 * Register the service provider.
	 *
	 * @return void
	 */
	public function register()
	{
		//
		$this->app['feedback'] = $this->app->share(function($app)
		{
		    return new Feedback;
		});
		
	}

	/**
	 * Get the services provided by the provider.
	 *
	 * @return array
	 */
	public function provides()
	{
		return array('feedback');
	}

}
