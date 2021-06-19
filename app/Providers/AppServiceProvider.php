<?php

namespace App\Providers;

use App\Models\Announcement;
use Illuminate\Pagination\Paginator;
use App\Observers\AnnouncementObserver;
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
        Announcement::observe(AnnouncementObserver::class);
        Paginator::useBootstrap();
    }
}
