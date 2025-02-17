@extends('layouts.app')

@section('title', 'إنشاء حساب للطالب')

@section('content')
    <div class="container">
        <div class="form-layout">
            <!-- الصورة على اليمين -->
            <div class="image-container">
                <img src="{{ asset('assets/img/student.jpg') }}" alt="إنشاء حساب">
            </div>

            <!-- الفورم على الشمال -->
            <div class="form-container">
                <h3 style="margin-left: 70px">إنشاء حساب كطالب أو طالبة</h3>
                <form method="POST" action="{{ route('register.student') }}" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="role" value="student">

                    <div class="form-group">
                        <label for="name">الاسم رباعي:</label>
                        <input type="text" id="name" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}" required autofocus>
                    </div>
                    @error('name')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror

                    <div class="form-group">
                        <label for="university_id">الرقم الجامعي:</label>
                        <input type="text" id="university_id" name="university_id" class="form-control @error('university_id') is-invalid @enderror" value="{{ old('university_id') }}" required>
                    </div>
                    @error('university_id')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror

                    <div class="form-group">
                        <label for="major">التخصص:</label>
                        <input type="text" id="major" name="major" class="form-control @error('major') is-invalid @enderror" value="{{ old('major') }}" required>
                    </div>
                    @error('major')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror

                    <div class="form-group">
                        <label for="academic_year">السنة الدراسية:</label>
                        <input type="number" id="academic_year" name="academic_year" class="form-control @error('academic_year') is-invalid @enderror" value="{{ old('academic_year') }}" required>
                    </div>
                    @error('academic_year')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror

                    <div class="form-group">
                        <label for="cv_file">ملف السيرة الذاتية:</label>
                        <input type="file" id="cv_file" name="cv_file" class="form-control @error('cv_file') is-invalid @enderror" required>
                    </div>
                    @error('cv_file')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror

                    <div class="form-group">
                        <label for="gpa">المعدل التراكمي:</label>
                        <input type="text" id="gpa" name="gpa" class="form-control @error('gpa') is-invalid @enderror" value="{{ old('gpa') }}" required>
                    </div>
                    @error('gpa')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror

                    <div class="form-group">
                        <label for="email">البريد الإلكتروني:</label>
                        <input type="email" id="email" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}" required>
                    </div>
                    @error('email')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror

                    <div class="form-group">
                        <label for="phone_number">رقم الجوال:</label>
                        <input type="text" id="phone_number" name="phone_number" class="form-control @error('phone_number') is-invalid @enderror" value="{{ old('phone_number') }}" required>
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
