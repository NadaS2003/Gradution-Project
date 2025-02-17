<?php
namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function showLoginForm()
    {
        return view('Login.login'); // صفحة اختيار الدور
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
            'role' => 'required'
        ]);

        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            $user = Auth::user();

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

    public function logout()
    {
        Auth::logout();
        return redirect('/login');
    }
}
