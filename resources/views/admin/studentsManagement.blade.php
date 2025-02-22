@extends('layouts.admin')

@section('content')
    <div class=" mt-6">
        <div class="flex justify-center items-center px-3 py-2">
            <h2 class="text-2xl font-bold  text-center">إدارة الطلاب</h2>
        </div>
    </div>

    <div class="mt-3 mb-10 px-8" style="margin-right: 800px">
        <div class="flex items-center mb-4">

            <input type="text" class="form-control px-2 rounded border border-gray-300 w-full py-2 h-10 w-25" placeholder="البحث">

            <button class="bg-blue-600 text-white rounded border px-4 py-2 h-10 mx-2 hover:bg-blue-700">بحث</button>

            <button class="bg-gray-400 hover:bg-gray-500 text-white rounded border px-2 py-2 h-10 flex justify-center items-center">
                <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7"></path>
                </svg>
            </button>
        </div>
    </div>
    <div class="mt-5 mr-5 ml-8 mb-6">
        <table class="w-full border-collapse border border-gray-300">
            <thead>
            <tr>
                <th class="border border-gray-300 px-4 py-2 text-right">اسم الطالب</th>
                <th class="border border-gray-300 px-4 py-2 text-right">الرقم الجامعي</th>
                <th class="border border-gray-300 px-4 py-2 text-right">التخصص</th>
                <th class="border border-gray-300 px-4 py-2 text-right">السنة الدراسية</th>
                <th class="border border-gray-300 px-4 py-2 text-right">المعدل التراكمي</th>
                <th class="border border-gray-300 px-4 py-2 text-right">البريد الإلكتروني</th>
                <th class="border border-gray-300 px-4 py-2 text-right">رقم الجوال</th>
                <th class="border border-gray-300 px-4 py-2 text-right">الإجراءات</th>
            </tr>
            </thead>
            <tbody>
            <tr class="hover:bg-gray-50">
                <td class="border border-gray-300 px-4 py-2">ليال إياد روحي الشبراوي</td>
                <td class="border border-gray-300 px-4 py-2">220178633</td>
                <td class="border border-gray-300 px-4 py-2">علم حاسوب</td>
                <td class="border border-gray-300 px-4 py-2">3</td>
                <td class="border border-gray-300 px-4 py-2">85.3</td>
                <td class="border border-gray-300 px-4 py-2">layal@gmail.com</td>
                <td class="border border-gray-300 px-4 py-2">0596321478</td>
                <td class="border border-gray-300 px-4 py-2">
                    <div class="inline-flex space-x-2 gap-2">
                        <button class="bg-yellow-500 text-white px-3 py-1 rounded hover:bg-yellow-600">تعديل</button>
                        <button class="bg-red-500 text-white px-3 py-1 rounded hover:bg-red-600">حذف</button>
                    </div>
                </td>
            </tr>
            </tbody>
        </table>
    </div>
@endsection
