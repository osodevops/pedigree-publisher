<?php

namespace App\Providers;

use App\RepoStat;
use App\Observers\RepoStatObserver;
use Illuminate\Support\ServiceProvider;

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
        // Model observers
        RepoStat::observe(RepoStatObserver::class);
    }
}
