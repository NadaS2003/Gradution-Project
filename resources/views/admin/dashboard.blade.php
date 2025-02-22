@extends('layouts.admin')
@section('content')
        <div class="my-4 mt-6 mr-10">
            <h3 class="text-xl font-bold">أهلاً وسهلاً بك في لوحة تحكم النظام</h3>
            <p class="text-gray-600">إدارة شاملة لكل العمليات والتحديثات في مكان واحد.</p>
        </div>
    <!-- البطاقات -->
    <div class="grid grid-cols-4 gap-4 mt-6 mr-10 ml-10">
        <div class="p-4 bg-yellow-400 text-white rounded text-right">عدد الطلبة المتدربين <br> <span class="text-xl">150 طالب</span></div>
        <div class="p-4 bg-blue-600 text-white rounded text-right">عدد الفرص المتاحة <br> <span class="text-xl">50 فرصة</span></div>
        <div class="p-4 bg-green-700 text-white rounded text-right">عدد المشرفين <br> <span class="text-xl">50 مشرف</span></div>
        <div class="p-4 bg-red-600 text-white rounded text-right">عدد الشركات <br> <span class="text-xl">60 شركة</span></div>
    </div>

    <!-- الأنشطة الأخيرة -->
        <div class="mt-10 mr-10 ml-10 mb-20">
            <div class="mt-6 bg-white p-4 rounded shadow border border-e-black border-opacity-15">
                <h2 class="text-xl  mr-4">آخر الأنشطة</h2>
                <ul class="mt-2  border border-black mr-4 ml-4">
                    <li class="p-2 border-b" style="background-color: rgb(217,217,217,30%);">قام الطالب <strong>أحمد علي</strong> بالتقديم على فرصة تدريب.</li>
                    <li class="p-2 border-b">تمت الموافقة على طلب <strong>سارة محمد</strong> من قبل شركة.</li>
                    <li class="p-2 border-b" style="background-color: rgb(217,217,217,30%);">قام المشرف بإضافة تقييم جديد للطالب <strong>خالد حسن</strong>.</li>
                </ul>
            </div>
        </div>
@endsection
