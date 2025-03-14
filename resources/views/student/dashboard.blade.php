@extends('layouts.student')
@section('title', 'الصفحة الرئيسية')

@section('content')
    <div class="my-4 mt-6 mr-10">
        <h3 class="text-right text-xl font-bold">أهلاً {{ \Illuminate\Support\Facades\Auth::user()->name }} !</h3>
        <p class="text-right text-gray-600">اطلع على ملفاتك التدريبية وأبقِ على اطلاع بأحدث التحديثات.</p>
    </div>

    <div class="flex gap-6 mt-6 mr-5 ml-8">

        <div class="bg-blue-100 border border-blue-400 p-4 rounded-lg shadow flex-1 min-h-[120px]">
            <h5 class="text-blue-700 font-bold text-lg">تفاصيل التدريب الحالي</h5>

            @if ($internship)
                <p><strong>اسم الفرصة:</strong> {{$internship->title}}</p>
                <p><strong>الشركة:</strong> {{$internship->company->company_name}}</p>
                <p><strong>تاريخ بدء التدريب:</strong> {{$internship->start_date}}</p>
                <p><strong>تاريخ انتهاء التدريب:</strong> {{$internship->end_date}}</p>
                <p><strong>مدة التدريب:</strong> {{$internship->duration}}</p>
            @else
                <p class="text-red-600 font-semibold break-words overflow-hidden">{{$statusMessage}}</p>
            @endif
        </div>

        <div class="bg-green-100 border border-green-400 p-4 rounded-lg shadow flex-1 min-h-[120px]">
            <h5 class="text-green-700 font-bold text-lg">معلومات المشرف</h5>
            @if ($supervisor)
            <p class="font-semibold">{{$supervisor->full_name}}</p>
            <p>{{$supervisor->department}}</p>
            <p>{{$supervisor->user->email}}</p>
            <p>{{$supervisor->phone_number}}</p>
            @else
                <p class="text-red-600 font-semibold break-words overflow-hidden">{{$supervisormassege}}</p>
            @endif
        </div>
    </div>





    <div class="my-4 mt-6 mr-8 ml-6">
        <div class="flex justify-between items-center px-3 py-2">
            <h3 class="text-xl font-bold">الفرص التدريبية</h3>
            <a href="{{ route('student.showTraining') }}" class="text-blue-600 hover:underline">عرض الكل</a>
        </div>
    </div>
    <div class="mt-5 mr-5 ml-8 mb-20">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-10 mt-4">
            @foreach ($internships as $internship)
                <div class="bg-white rounded-lg shadow p-4 border border-e-black border-opacity-15 relative">
                    <img src="{{ asset('storage/internships/' . $internship->image) }}" class="w-full h-40 object-cover rounded-md" alt="{{ $internship->title }}">
                    <div class="mt-4">
                        <h5 class="text-lg font-bold">{{ $internship->title }}</h5>
                        <p class="text-gray-700">{{ $internship->company_name }}</p>
                        <p class="text-gray-500">{{ $internship->duration }}</p>
                    </div>
                    <a href="{{ route('student.opportunityDetails', ['id' => $internship->id]) }}" class="absolute bottom-4 left-4 bg-blue-600 text-white text-center rounded-md hover:bg-blue-700 w-24 h-7 flex justify-center items-center text-sm">تفاصيل</a>
                </div>
            @endforeach
        </div>
    </div>


@endsection
