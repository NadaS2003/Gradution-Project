@extends('layouts.app')

@section('title', 'إنشاء حساب')

@section('content')
    <h2>إنشاء حساب</h2>
    <p>اختر الفئة المناسبة لإنشاء الحساب:</p>

    <div class="card-container">
        <div class="card">
            <img src="{{asset('assets/img/supervisor.jpg')}}" alt="مشرف">
            <p>حساب كمشرف أو مشرفة.</p>
        </div>
        <div class="card">
            <img src="{{asset('assets/img/company.jpg')}}" alt="شركة">
            <p>حساب كشركة.</p>
        </div>
        <div class="card">
            <img src="{{asset('assets/img/student.jpg')}}" alt="طالب">
            <p>حساب كطالب أو طالبة.</p>
        </div>
        <div class="card">
            <img src="{{asset('assets/img/admin.jpg')}}" alt="مسؤول">
            <p>حساب كمسؤول.</p>
        </div>
    </div>
@endsection

