<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    public function create(): View
    {
        return view('Login.login');
    }

    public function store(LoginRequest $request): RedirectResponse
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required',
            'role' => 'required'
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator);
        }

        $credentials = $request->only('email', 'password');
        $remember = $request->has('remember');


        if (Auth::check()) {
            Auth::logout();

            request()->session()->invalidate();
            request()->session()->regenerateToken();
        }

        if (Auth::attempt($credentials, $remember)) {
            $user = Auth::user();

            if ($user->role !== $request->role) {
                Auth::logout();
                return back()->withErrors(['role' => 'هذا الحساب ليس له الصلاحية للدخول كـ ' . $request->role]);
            }

            Auth::login($user, true);
            $request->session()->regenerate();

            return redirect()->route("{$user->role}.dashboard");
        }

        return back()->withErrors(['email' => 'بيانات تسجيل الدخول غير صحيحة']);
    }


    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }

    protected function redirectTo()
    {
        $user = Auth::user();
        return route("{$user->role}.dashboard");
    }
}
