@extends('layouts.student')
@section('title', 'تفاصيل الفرصة')

@section('content')
    <div class="mx-auto p-6">
        <h2 class="text-2xl font-bold text-center mb-6">تفاصيل الفرصة</h2>

        <div class="bg-white p-6 rounded-lg shadow-md max-w-4xl max-h-4xl mx-auto border border-gray-200 py-10 px-10">
            <div class="flex flex-col md:flex-row items-start">
                <!-- القسم الأيسر: الصورة + الزر -->
                <div class="flex-1 mr-5">
                    <h3 class="text-xl font-semibold text-gray-800 mr-20 mb-5">React js</h3>
                    <p class="mt-2 text-black"><strong>الوصف:</strong> برمجة واجهات باستخدام React js</p>
                    <p class="mt-2 text-black"><strong>اسم الشركة:</strong> ويبرا</p>
                    <p class="mt-2 text-black"><strong>مدة التدريب:</strong> 3 أشهر</p>
                    <p class="mt-2 text-black"><strong>تاريخ بداية التدريب:</strong> 3/2/2025</p>
                    <p class="mt-2 text-black"><strong>تاريخ نهاية التدريب:</strong> 3/5/2025</p>
                    <p class="mt-2 text-black"><strong>البريد الإلكتروني:</strong> company@gmail.com</p>
                    <p class="mt-2 text-black"><strong>الموقع الإلكتروني:</strong>
                        <a href="#" target="_blank" class="text-blue-500 hover:underline">www.company.com</a>
                    </p>
                    <p class="mt-2 text-black"><strong>رقم الهاتف:</strong> 0592459665</p>
                    <p class="mt-2 text-black"><strong>العنوان:</strong> الرمال, شارع الوحدة</p>
                </div>

                <div class="relative  ml-5">
                    <img src="{{ asset('assets/img/react.jpg') }}"
                         alt="Training Image"
                         class="w-80 h-50 object-cover rounded-lg shadow mt-10">

                    <!-- زر تقديم الطلب في أسفل يمين الصورة -->
                    <div class="absolute left-0 mt-10">
                        <a href="{{route('student.applyRequest')}}" class="bg-blue-600 text-white px-5 py-2.5 rounded-lg shadow-md hover:bg-blue-700 transition">
                            تقديم الطلب
                        </a>
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection

