@extends('layouts.admin')

@section('content')
    <div class=" mt-6">
        <div class="flex justify-center items-center px-3 py-2">
            <h2 class="text-2xl font-bold  text-center">إدارة الحضور و الغياب</h2>
        </div>
    </div>

    <div class="mt-3 mb-5 px-8 flex flex-col items-end gap-3">
        <div class="flex items-center gap-3 mb-4">
            <input type="text" class="form-control px-2 rounded border border-gray-300 w-96 py-2 h-10" placeholder="البحث">
            <button class="bg-blue-600 text-white rounded border px-4 py-2 h-10 hover:bg-blue-700">بحث</button>
            <button class="bg-gray-400 hover:bg-gray-500 text-white rounded border px-2 py-2 h-10 flex justify-center items-center">
                <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7"></path>
                </svg>
            </button>
            <button class="bg-blue-600 text-white rounded border px-4 py-2 h-10 w-30 hover:bg-blue-700">تصدير ملف اكسل</button>
        </div>
    </div>


    <div class="mt-5 mr-5 ml-8 mb-6">
        <table class="w-full border-collapse border border-gray-300">
            <thead>
            <tr>
                <th class="border border-gray-300 px-4 py-2 text-right">اسم الطالب</th>
                <th class="border border-gray-300 px-4 py-2 text-right">الشركة</th>
                <th class="border border-gray-300 px-4 py-2 text-right">عدد أيام الحضور</th>
                <th class="border border-gray-300 px-4 py-2 text-right">عدد أيام الغياب</th>
                <th class="border border-gray-300 px-4 py-2 text-right">الإجراءات</th>
            </tr>
            </thead>
            <tbody>
            <tr class="hover:bg-gray-50">
                <td class="border border-gray-300 px-4 py-2">محمد علي</td>
                <td class="border border-gray-300 px-4 py-2">البرمجيات المتقدمة</td>
                <td class="border border-gray-300 px-4 py-2">20</td>
                <td class="border border-gray-300 px-4 py-2">10</td>
                <td class="border border-gray-300 px-4 py-2"><button class="bg-yellow-500 text-white px-3 py-1 rounded hover:bg-yellow-600">تعديل</button></td>
            </tr>
            <tr class="hover:bg-gray-50">
                <td class="border border-gray-300 px-4 py-2">سارة محمود</td>
                <td class="border border-gray-300 px-4 py-2">أوبيرا</td>
                <td class="border border-gray-300 px-4 py-2">16</td>
                <td class="border border-gray-300 px-4 py-2">1</td>
                <td class="border border-gray-300 px-4 py-2"><button class="bg-yellow-500 text-white px-3 py-1 rounded hover:bg-yellow-600">تعديل</button></td>
            </tr>
            </tbody>
        </table>
    </div>
@endsection
