@extends('layouts.student')
@section('title', 'الصفحة الرئيسية')

@section('content')
    <div class="my-4 mt-6 mr-10">
        <h3 class="text-right text-xl font-bold">أهلاً {{ \Illuminate\Support\Facades\Auth::user()->name }} !</h3>
        <p class="text-right text-gray-600">اطلع على ملفاتك التدريبية وأبقِ على اطلاع بأحدث التحديثات.</p>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-6 mr-5 ml-8">
        <div class="bg-blue-100 border border-blue-400 p-4 rounded-lg shadow">
            <h5 class="text-blue-700 font-bold text-lg">تفاصيل التدريب الحالي</h5>
            <p><strong>الشركة:</strong> التكنولوجية</p>
            <p><strong>تاريخ بدء التدريب:</strong> 15/4/2020</p>
            <p><strong>تاريخ انتهاء التدريب:</strong> 15/7/2020</p>
            <p><strong>مدة التدريب:</strong> 3 شهور</p>
            <p><strong>حالة التدريب:</strong> بدأ</p>
        </div>

        <div class="bg-green-100 border border-green-400 p-4 rounded-lg shadow">
            <h5 class="text-green-700 font-bold text-lg">معلومات المشرف</h5>
            <p class="font-semibold">د. مازن سمير</p>
            <p>علم الحاسوب</p>
            <p>ahmed@gmail.com</p>
            <p>059321589674</p>
        </div>
    </div>

    <div class="my-4 mt-6 mr-8 ml-6">
        <div class="flex justify-between items-center px-3 py-2">
            <h3 class="text-xl font-bold">الفرص التدريبية</h3>
            <a href="{{route('student.showTraining')}}" class="text-blue-600 hover:underline">عرض الكل</a>
        </div>
    </div>
    <div class="mt-5 mr-5 ml-8 mb-20">
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
