@extends('layouts.app')

@section('title', 'إنشاء حساب لشركة')

@section('content')
    <div class="container">
        <div class="form-layout">
            <div class="image-container">
                <img src="{{ asset('assets/img/company.jpg') }}" alt="إنشاء حساب">
            </div>

            <div class="form-container">
                <h3>إنشاء حساب كشركة</h3>
                <form method="POST" action="{{ route('register.company') }}" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="role" value="company">

                    <div class="form-group">
                        <label for="name">اسم الشركة:</label>
                        <input type="text" id="name" name="name" class="form-control @error('name') is-invalid @enderror"
                               value="{{ old('name') }}" required autofocus>
                    </div>
                    @error('name')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror

                    <div class="form-group">
                        <label for="website">الموقع الإلكتروني:</label>
                        <input type="text" id="website" name="website" class="form-control @error('website') is-invalid @enderror"
                               value="{{ old('website') }}" required>
                    </div>
                    @error('website')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror

                    <div class="form-group">
                        <label for="description">الوصف:</label>
                        <textarea id="description" name="description" class="form-control @error('description') is-invalid @enderror"
                                  rows="3" required>{{ old('description') }}</textarea>
                    </div>
                    @error('description')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror

                    <div class="form-group">
                        <label for="location">العنوان:</label>
                        <input type="text" id="location" name="location" class="form-control @error('location') is-invalid @enderror"
                               value="{{ old('location') }}" required>
                    </div>
                    @error('location')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror

                    <div class="form-group">
                        <label for="email">البريد الإلكتروني:</label>
                        <input type="email" id="email" name="email" class="form-control @error('email') is-invalid @enderror"
                               value="{{ old('email') }}" required>
                    </div>
                    @error('email')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror

                    <div class="form-group">
                        <label for="phone_number">رقم الجوال:</label>
                        <input type="text" id="phone_number" name="phone_number" class="form-control @error('phone_number') is-invalid @enderror"
                               value="{{ old('phone_number') }}" required>
                    </div>
                    @error('phone_number')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror

                    <div class="form-group">
                        <label for="password">كلمة المرور:</label>
                        <input type="password" id="password" name="password" class="form-control @error('password') is-invalid @enderror" required>
                    </div>
                    @error('password')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror

                    <div class="form-group">
                        <label for="password_confirmation">أدخل كلمة المرور مرة أخرى:</label>
                        <input type="password" id="password_confirmation" name="password_confirmation" class="form-control" required>
                    </div>

                    <button type="submit" class="btn">إنشاء حساب</button>

                </form>
            </div>
        </div>
    </div>
@endsection
