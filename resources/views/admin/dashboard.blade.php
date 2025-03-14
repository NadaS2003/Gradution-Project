@extends('layouts.admin')
@section('content')

    <div class="my-4 mt-6 mr-10">
            <h3 class="text-xl font-bold">أهلاً وسهلاً بك في لوحة تحكم النظام</h3>
            <p class="text-gray-600">إدارة شاملة لكل العمليات والتحديثات في مكان واحد.</p>
        </div>
    <div class="grid grid-cols-4 gap-4 mt-6 mr-10 ml-10">
        <div class="p-4 bg-yellow-400 text-white rounded text-right">عدد الطلبة المتدربين <br> <span class="text-xl">{{ $studentsCount }}  طالب</span></div>
        <div class="p-4 bg-blue-600 text-white rounded text-right">عدد الفرص المتاحة <br> <span class="text-xl">{{ $opportunitiesCount }}  فرصة</span></div>
        <div class="p-4 bg-green-700 text-white rounded text-right">عدد المشرفين <br> <span class="text-xl">{{ $supervisorsCount }}  مشرف</span></div>
        <div class="p-4 bg-red-600 text-white rounded text-right">عدد الشركات <br> <span class="text-xl">{{ $companiesCount }}  شركة</span></div>
    </div>


        <div class="mt-6 mr-10 ml-10 mt-10 bg-white p-6 rounded-lg shadow-lg border border-e-black border-opacity-15">
            <h2 class="text-2xl font-bold text-right mb-4">مراقبة النظام</h2>
            <ul class="space-y-4">
                <li class="flex justify-between"><span class="font-semibold">وقت الاستجابة:</span> <span class="text-xl text-gray-700">{{ number_format($responseTime, 4) }} ثانية</span></li>
                <li class="flex justify-between"><span class="font-semibold">استخدام الذاكرة:</span> <span class="text-xl text-gray-700">{{ $memoryUsageMb }} MB</span></li>
                <li class="flex justify-between"><span class="font-semibold">حالة قاعدة البيانات:</span> <span class="text-xl text-gray-700">{{ $dbStatus }}</span></li>
                <li class="flex justify-between"><span class="font-semibold">عدد الزيارات:</span> <span class="text-xl text-gray-700">{{ $visitCount }}</span></li>
                <li class="flex justify-between"><span class="font-semibold">استخدام القرص الصلب:</span> <span class="text-xl text-gray-700">{{ $diskUsedPercentage }}%</span></li>
            </ul>
        </div>

@endsection
