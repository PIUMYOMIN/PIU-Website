<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use App\Models\Course;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Auth\Notifications\ResetPassword;

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
        ResetPassword::createUrlUsing(function (object $user, string $token) {
            $frontendUrl = rtrim((string) env('FRONTEND_URL', 'https://www.piueducation.org'), '/');
            return $frontendUrl . '/reset-password?token=' . urlencode($token) . '&email=' . urlencode($user->email);
        });

        RateLimiter::for('api', function (Request $request) {
            return Limit::perMinute(60)->by($request->user()?->id ?: $request->ip());
        });

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