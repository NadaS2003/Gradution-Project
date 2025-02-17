<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('Login.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
//        $request->authenticate();
//
//        $request->session()->regenerate();
//
//        return redirect()->intended(RouteServiceProvider::HOME);

      //  dd($request);
        $validator=Validator::make($request->all(),[
            'email' => 'required|email',
            'password' => 'required',
            'role'=>'required'
        ]);
        if ($validator->fails()) {
            dd($validator->errors()->all());
        }
        //dd('validation passed');
        // تمرير خيار "تذكرني" هنا

        $credentials = $request->only('email', 'password');
        $remember = $request->has('remember');

        if (Auth::attempt($credentials,$remember)) {
            $user = Auth::user();
          //  dd($user);
            // التأكد من أن المستخدم ينتمي إلى الدور الذي اختاره
            if ($user->role !== $request->role) {
                Auth::logout();
                return back()->withErrors(['role' => 'هذا الحساب ليس له الصلاحية للدخول كـ ' . $request->role]);
            }

            // توجيه المستخدم حسب دوره
            return redirect()->route($user->role . '.dashboard');
        }

        return back()->withErrors(['email' => 'بيانات تسجيل الدخول غير صحيحة']);

    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
