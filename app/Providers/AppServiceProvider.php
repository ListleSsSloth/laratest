<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use DB;

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
        if (config('settings.dump_sql_requests')) {
            DB::listen(function ($query) { dump($query->sql); });
        }
        if (config('settings.dump_sql_requests_bindings')) {
            DB::listen(function ($query) { dump($query->bindings); });
        }
    }
}
