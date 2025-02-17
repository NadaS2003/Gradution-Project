@extends('layouts.app')

@section('title', 'إنشاء حساب')

@section('content')
    <h2>إنشاء حساب</h2>
    <p>اختر الفئة المناسبة لإنشاء الحساب:</p>

    <div class="card-container">
        <div class="card">
            <a href="{{route('register.supervisor')}}"><img src="{{asset('assets/img/supervisor.jpg')}}" alt="مشرف">
            <p>حساب كمشرف أو مشرفة.</p>
            </a>
        </div>
        <div class="card">
            <a href="{{route('register.company')}}"><img src="{{asset('assets/img/company.jpg')}}" alt="شركة">
            <p>حساب كشركة.</p>
            </a>
        </div>
        <div class="card">
            <a href="{{route('register.student')}}"><img src="{{asset('assets/img/student.jpg')}}" alt="طالب">
            <p>حساب كطالب أو طالبة.</p>
            </a>
        </div>
{{--        <div class="card">--}}
{{--            <a href="{{url('adminReg')}}"><img src="{{asset('assets/img/admin.jpg')}}" alt="مسؤول">--}}
{{--            <p>حساب كمسؤول.</p>--}}
{{--            </a>--}}
{{--        </div>--}}
    </div>
@endsection

