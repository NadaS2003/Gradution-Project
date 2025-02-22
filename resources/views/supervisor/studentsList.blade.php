@extends('layouts.supervisor')

@section('content')
    <div class=" mt-6">
        <div class="flex justify-center items-center px-3 py-2">
            <h2 class="text-2xl font-bold text-center mb-6">قائمة الطلبة</h2>
        </div>
    </div>
    <div class="mt-5 mr-5 ml-8 mb-6">
            <table class="w-full border-collapse border border-gray-300">
                <thead>
                <tr>
                    <th class="border border-gray-300 px-4 py-2 text-right">الاسم</th>
                    <th class="border border-gray-300 px-4 py-2 text-right">الشركة</th>
                    <th class="border border-gray-300 px-4 py-2 text-right">حالة التدريب</th>
                    <th class="border border-gray-300 px-4 py-2 text-right">الإجراءات</th>
                </tr>
                </thead>
                <tbody>
                <tr class="hover:bg-gray-50">
                    <td class="border border-gray-300 px-4 py-2">هلا محمد</td>
                    <td class="border border-gray-300 px-4 py-2">التكنولوجية</td>
                    <td class="border border-gray-300 px-4 py-2">
                        <span class="text-white px-2 py-1 rounded" style="background-color: #FFC107;">بدأ</span>
                    </td>
                    <td class="border border-gray-300 px-4 py-2">
                        <a href="{{route('supervisor.studentDetails')}}" class="bg-blue-600 text-white px-3 py-1 rounded hover:bg-blue-700">تفاصيل</a>
                    </td>
                </tr>
                <tr class="hover:bg-gray-50">
                    <td class="border border-gray-300 px-4 py-2">أحمد وليد</td>
                    <td class="border border-gray-300 px-4 py-2">مينا</td>
                    <td class="border border-gray-300 px-4 py-2">
                        <span class="bg-red-500 text-white px-2 py-1 rounded" style="background-color: #DC3545;">لم يبدأ</span>
                    </td>
                    <td class="border border-gray-300 px-4 py-2">
                        <a href="{{route('supervisor.studentDetails')}}" class="bg-blue-600 text-white px-3 py-1 rounded hover:bg-blue-700">تفاصيل</a>
                    </td>
                </tr>
                <tr class="hover:bg-gray-50">
                    <td class="border border-gray-300 px-4 py-2">سمير جميل</td>
                    <td class="border border-gray-300 px-4 py-2">Gate Way</td>
                    <td class="border border-gray-300 px-4 py-2">
                        <span class="bg-green-500 text-white px-2 py-1 rounded" style="background-color: #25CE07;">مكتمل</span>
                    </td>
                    <td class="border border-gray-300 px-4 py-2">
                        <a href="{{route('supervisor.studentDetails')}}" class="bg-blue-600 text-white px-3 py-1 rounded hover:bg-blue-700">تفاصيل</a>
                    </td>
                </tr>
                </tbody>
            </table>
        </div>

@endsection
