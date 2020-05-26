<?php

namespace App\Providers;

use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Schema::defaultStringLength(191);

        $footer = \App\Model\Cms::find(19);
        View::share('footer_right', $footer);

        $config = \App\Model\Config::first();
        if(!is_null($config)) {
          $config->data = json_decode($config->data);
        }
        View::share('config', $config);
    }
}
