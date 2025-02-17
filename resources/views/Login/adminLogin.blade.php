@extends('layouts.app')

@section('title', 'تسجيل الدخول للمسؤول')

@section('content')
    <div class="container">
        <div class="form-layout"> <!-- استخدام التنسيق الجديد -->
            <!-- الصورة على اليمين -->
            <div class="image-container">
                <img src="{{ asset('assets/img/admin.jpg') }}" alt="تسجيل الدخول">
            </div>

            <!-- الفورم على الشمال -->
            <div class="form-container">
                <h3>تسجيل الدخول كمسؤول</h3>
                <form method="POST" action="{{ route('login') }}">
                    @csrf
                    <input type="hidden" name="role" value="admin">

                    <div class="form-group">
                        <label for="email">البريد الإلكتروني:</label>
                        <input type="email" id="email" name="email" required autofocus>
                    </div>

                    <div class="form-group">
                        <label for="password">كلمة المرور:</label>
                        <input type="password" id="password" name="password" required>
                    </div>

                    <div class="form-group remember-forgot">

                        <div class="remember-me">
                            <input type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                            <label for="remember">تذكرني</label>


                        </div>
                        <div class="forgot-password">
                            <a href="#">هل نسيت كلمة المرور؟</a>
                        </div>
                    </div>
                    <button type="submit" class="btn">تسجيل الدخول</button>


                </form>
            </div>
        </div>
    </div>
@endsection
