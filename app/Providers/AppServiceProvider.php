<?php namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider {

	/**
	 * Bootstrap any application services.
	 *
	 * @return void
	 */
	public function boot()
	{
		//
        view()->share(['APP_NAME'=>env('APP_NAME'),'KEY_WORDS'=>'SS,Shadowsocks,加速器','DESCRIPTION'=>'FastSSR，专业的SS服务提供商','COPY_RIGHT'=>'copyright']);
	}

	/**
	 * Register any application services.
	 *
	 * @return void
	 */
	public function register()
	{
		//
	}

}
