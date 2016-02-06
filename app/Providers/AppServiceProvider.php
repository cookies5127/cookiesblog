<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Repositories\PageRepository;
use App\Repositories\PostRepository;
use DB,Schema;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {	
		view()->composer('partials.sidebar','App\ViewComposers\SidebarComposer');
		view()->composer('partials.nav','App\ViewComposers\NavComposer');
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
		$this->registerPageRepository();
		$this->registerPostRepository();
    }

	protected function registerPageRepository()
	{
		$this->app->bind('pagerepository',function($app){
			return new PageRepository;
		});
	}

	protected function registerPostRepository()
	{

		$this->app->bind('postrepository',function($app){
			return new PostRepository;
		});
	}

	public function provides()
	{
		return [
			'pagerepository',
			'postrepository',
		];
	}
	
}
