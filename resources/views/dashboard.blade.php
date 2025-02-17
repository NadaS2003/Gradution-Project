@extends('layouts.app')
@section('content')
    <form action="{{ route('logout') }}" method="POST">
        @csrf
        <button type="submit" class="btn btn-danger">تسجيل الخروج</button>
    </form>
@endsection
