@extends('layouts.app')

@section('title', 'تسجيل الدخول')

@section('content')
    <h2>تسجيل الدخول</h2>
    <p>اختر الفئة المناسبة لتسجيل الدخول:</p>

    <div class="card-container">
        <div class="card">
            <a href="{{url('superLogin')}}"><img src="{{asset('assets/img/supervisor.jpg')}}" alt="مشرف">
            <p>الدخول كمشرف أو مشرفة.</p>
            </a>
        </div>
        <div class="card">
            <a href="{{url('companyLogin')}}"><img src="{{asset('assets/img/company.jpg')}}" alt="شركة">
            <p>الدخول كشركة.</p>
            </a>
        </div>
        <div class="card">
            <a href="{{url('studentLogin')}}"><img src="{{asset('assets/img/student.jpg')}}" alt="طالب">
            <p>الدخول كطالب أو طالبة.</p>
            </a>
        </div>
        <div class="card">
            <a href="{{url('adminLogin')}}"><img src="{{asset('assets/img/admin.jpg')}}" alt="مسؤول">
            <p>الدخول كمسؤول.</p>
            </a>
        </div>
    </div>
@endsection
