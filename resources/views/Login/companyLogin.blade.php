@extends('layouts.app')

@section('title', 'تسجيل الدخول لشركة')

@section('content')
    <div class="container">
        <div class="form-layout"> <!-- استخدام التنسيق الجديد -->
            <!-- الصورة على اليمين -->
            <div class="image-container">
                <img src="{{ asset('assets/img/company.jpg') }}" alt="تسجيل الدخول">
            </div>

            <!-- الفورم على الشمال -->
            <div class="form-container">
                <h3>تسجيل الدخول كشركة</h3>
                <form method="POST" action="{{ route('login') }}">
                    @csrf
                    <input type="hidden" name="role" value="company">

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
                            <input type="checkbox" id="remember" name="remember">
                            <label for="remember">تذكرني</label>


                        </div>
                        <div class="forgot-password">
                            <a href="{{route('password.request')}}">هل نسيت كلمة المرور؟</a>
                        </div>
                    </div>
                    <button type="submit" class="btn">تسجيل الدخول</button>


                </form>
            </div>
        </div>
    </div>
@endsection
