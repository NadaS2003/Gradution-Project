<?php

namespace App\Http\Middleware;

use App\Providers\RouteServiceProvider;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, string ...$guards): Response
    {
        $guards = empty($guards) ? [null] : $guards;

        foreach ($guards as $guard) {
            if (Auth::guard($guard)->check()) {
                Auth::logout();
                $request->session()->invalidate();
                $request->session()->regenerateToken();

                $request->session()->flash('message', 'تم تسجيل الخروج بنجاح. يمكنك الآن تسجيل الدخول بحساب آخر.');

                return redirect()->route('login');
            }
        }

        return $next($request);
    }

    protected function redirectToBasedOnRole()
    {
        $user = Auth::user();
        if ($user) {
            if ($user->role === 'admin') {
                if (Auth::user()->role !== 'admin') {
                    Auth::logout();
                    return redirect()->route('login')->withErrors(['role' => 'لا يمكنك الدخول كـ Admin.']);
                }
                return redirect()->route('admin.dashboard');
            }
            elseif ($user->role === 'student') {
                if (Auth::user()->role !== 'student') {
                    Auth::logout();
                    return redirect()->route('login')->withErrors(['role' => 'لا يمكنك الدخول كـ Student.']);
                }
                return redirect()->route('student.dashboard');
            }
            elseif ($user->role === 'supervisor') {
                if (Auth::user()->role !== 'supervisor') {
                    Auth::logout();
                    return redirect()->route('login')->withErrors(['role' => 'لا يمكنك الدخول كـ Supervisor.']);
                }
                return redirect()->route('supervisor.dashboard');
            }
            elseif ($user->role === 'company') {
                if (Auth::user()->role !== 'company') {
                    Auth::logout();
                    return redirect()->route('login')->withErrors(['role' => 'لا يمكنك الدخول كـ Company.']);
                }
                return redirect()->route('company.dashboard');
            }
        }

        return redirect('/');
    }

}
