@extends('layouts.app')

@section('title', 'إنشاء حساب للمشرف')

@section('content')
    <div class="container">
        <div class="form-layout">
            <div class="image-container">
                <img src="{{ asset('assets/img/supervisor.jpg') }}" alt="إنشاء حساب">
            </div>

            <div class="form-container">
                <h3 style="margin-left: 60px">إنشاء حساب كمشرف أو مشرفة</h3>
                <form method="POST" action="{{ route('register.supervisor') }}">
                    @csrf
                    <input type="hidden" name="role" value="supervisor">

                    <div class="form-group">
                        <label for="name">الاسم رباعي:</label>
                        <input type="text" id="name" name="name"
                               class="form-control @error('name') is-invalid @enderror"
                               value="{{ old('name') }}" required autofocus>
                    </div>
                    @error('name')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror

                    <div class="form-group">
                        <label for="employee_id">الرقم الوظيفي:</label>
                        <input type="text" id="employee_id" name="employee_id"
                               class="form-control @error('employee_id') is-invalid @enderror"
                               value="{{ old('employee_id') }}" required>

                    </div>
                    @error('employee_id')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                    <div class="form-group">
                        <label for="department">التخصص:</label>
                        <input type="text" id="department" name="department"
                               class="form-control @error('department') is-invalid @enderror"
                               value="{{ old('department') }}" required>

                    </div>
                    @error('department')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                    <div class="form-group">
                        <label for="email">البريد الإلكتروني:</label>
                        <input type="email" id="email" name="email"
                               class="form-control @error('email') is-invalid @enderror"
                               value="{{ old('email') }}" required>

                    </div>
                    @error('email')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                    <div class="form-group">
                        <label for="phone_number">رقم الجوال:</label>
                        <input type="text" id="phone_number" name="phone_number"
                               class="form-control @error('phone_number') is-invalid @enderror"
                               value="{{ old('phone_number') }}" required>

                    </div>
                    @error('phone_number')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                    <div class="form-group">
                        <label for="password">كلمة المرور:</label>
                        <input type="password" id="password" name="password"
                               class="form-control @error('password') is-invalid @enderror" required>

                    </div>
                    @error('password')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                    <div class="form-group">
                        <label for="password_confirmation">أدخل كلمة المرور مرة أخرى:</label>
                        <input type="password" id="password_confirmation" name="password_confirmation"
                               class="form-control" required>
                    </div>

                    <button type="submit" class="btn">إنشاء حساب</button>

                </form>
            </div>
        </div>
    </div>
@endsection
