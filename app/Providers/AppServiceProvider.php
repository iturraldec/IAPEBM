<?php

namespace App\Providers;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Blade;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {   
        /////////////////////////////////////////
        // PENDIENTE POR ESTUDIO
        /////////////////////////////////////////
        // Model::preventLazyLoading();
        /////////////////////////////////////////
        Model::preventAccessingMissingAttributes();
        Model::preventSilentlyDiscardingAttributes();
        Blade::withoutDoubleEncoding();
    }
}
