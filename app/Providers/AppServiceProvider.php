<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use App\Models\Course;

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
        View::composer('components.mobileMenu', function ($view) {
            $view->with('courses', Course::all());
        });

        View::composer('components.footer', function ($view) {
            $view->with('courses', Course::latest()->take(2)->get());
        });

        View::composer('components.search_box', function ($view) {
            $courses = Course::where('is_active', true)->take(6)->get();
            $view->with('courses', $courses);
        });
    }
}