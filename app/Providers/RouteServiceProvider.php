<?php

namespace App\Providers;

use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * The path to the "home" route for your application.
     *
     * Typically, users are redirected here after authentication.
     *
     * @var string
     */
//    public const HOME = '/'; // المسار الافتراضي في حالة عدم تحديد دور معين

    /**
     * Define your route model bindings, pattern filters, and other route configuration.
     */
    public function boot(): void
    {
        $this->configureRateLimiting();

        $this->routes(function () {
            Route::middleware('api')
                ->prefix('api')
                ->group(base_path('routes/api.php'));

            Route::middleware('web')
                ->group(base_path('routes/web.php'));
        });
    }

    /**
     * Configure the rate limiters for the application.
     */
    protected function configureRateLimiting(): void
    {
        RateLimiter::for('api', function (Request $request) {
            return Limit::perMinute(60)->by($request->user()?->id ?: $request->ip());
        });
    }

    /**
     * Handle the redirection after authentication based on the user's role.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
//    public static function redirectToBasedOnRole()
//    {
//        $user = Auth::user();
//        if ($user) {
//            if ($user->role === 'admin') {
//                return redirect()->route('admin.dashboard'); // تأكد من وجود هذا المسار في routes/web.php
//            } elseif ($user->role === 'student') {
//                return redirect()->route('student.dashboard'); // تأكد من وجود هذا المسار في routes/web.php
//            } else {
//                return redirect(self::HOME); // في حالة عدم وجود دور محدد
//            }
//        }
//
//        return redirect(self::HOME); // في حالة عدم وجود مستخدم مسجل الدخول
//    }
}
