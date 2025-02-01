<?php

namespace Support\Providers;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\App;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        App::useAppPath(base_path('app/App'));

        Model::unguard();

    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
