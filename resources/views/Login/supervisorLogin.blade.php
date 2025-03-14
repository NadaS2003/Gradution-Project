@extends('layouts.app')

@section('title', 'تسجيل الدخول للمشرف')

@section('content')
    <div class="container">
        <div class="form-layout">

            <div class="image-container">
                <img src="{{ asset('assets/img/supervisor.jpg') }}" alt="تسجيل الدخول">
            </div>

            <div class="form-container">
                <h3 style="margin-left: 60px">تسجيل الدخول كمشرف أو مشرفة</h3>
                <form method="POST" action="{{ route('login') }}">
                    @csrf
                    <input type="hidden" name="role" value="supervisor">
                    @if ($errors->any())
                        <div class="error-feedback">
                            @foreach ($errors->all() as $error)
                                {{ $error }}
                            @endforeach
                        </div>
                    @endif
                    <div class="form-group">
                        <label for="email">البريد الإلكتروني:</label>
                        <input type="email" id="email" name="email" required autofocus>
                    </div>

                    <div class="form-group">
                        <label for="password">كلمة المرور:</label>
                        <input type="password" id="password" name="password" required>
                    </div>


                    <button type="submit" class="btn">تسجيل الدخول</button>


                </form>
            </div>
        </div>
    </div>
@endsection
