@extends('layouts.student')

@section('title', 'عرض الفرص التدريبية')

@section('content')

    <div class=" mt-6">
        <div class="flex justify-center items-center px-3 py-2">
            <h2 class="text-xl font-bold  text-center">قائمة الفرص التدريبية</h2>
        </div>
    </div>

    <div class="mt-3 mb-10 px-8" style="margin-right: 800px">
        <div class="flex items-center mb-4">

                <input type="text" class="form-control px-2 rounded border border-gray-300 w-full py-2 h-10 w-25" placeholder="البحث">

            <button class="bg-blue-600 text-white rounded border px-4 py-2 h-10 mx-2">بحث</button>

            <button class="bg-gray-400 hover:bg-gray-500 text-white rounded border px-2 py-2 h-10 flex justify-center items-center">
                <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7"></path>
                </svg>
            </button>
        </div>
    </div>



    <div class="mt-5 mr-5 ml-8 mb-6">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-10 mt-4">
            @for ($i = 0; $i < 3; $i++)
                <div class="bg-white rounded-lg shadow p-4 border border-e-black border-opacity-15 relative">
                    <img src="{{ asset('assets/img/react.jpg') }}" class="w-full h-40 object-cover rounded-md" alt="React">
                    <div class="mt-4">
                        <h5 class="text-lg font-bold">React JS</h5>
                        <p class="text-gray-700">شركة برمجيات متقدمة</p>
                        <p class="text-gray-500">3 شهور</p>
                    </div>
                    <a href="{{route('student.opportunityDetails')}}" class="absolute bottom-4 left-4 bg-blue-600 text-white text-center rounded-md hover:bg-blue-700 w-24 h-7 flex justify-center items-center text-sm">تفاصيل</a>
                </div>
            @endfor
        </div>
    </div>

@endsection

