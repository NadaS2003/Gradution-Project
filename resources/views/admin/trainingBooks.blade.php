@extends('layouts.admin')

@section('content')
    <div class="mt-6">
        <div class="flex justify-center items-center px-3 py-2">
            <h2 class="text-2xl font-bold text-center">إدارة الكتب التدريبية</h2>
        </div>
    </div>

    <div class="mt-3 mb-10 px-8" style="margin-right: 850px">
        <div class="flex items-center mb-4">
            <form method="GET" action="{{ route('admin.trainingBooks') }}" class="flex items-center mb-4">
                <input type="text" name="search" class="form-control px-2 rounded border border-gray-300 w-full py-2 h-10 w-25" placeholder="البحث باسم الطالب" value="{{ request()->get('search') }}">
                <button type="submit" class="bg-blue-600 text-white rounded border px-4 py-2 h-10 mx-2 hover:bg-blue-700">بحث</button>
                <button type="button" class="bg-gray-400 hover:bg-gray-500 text-white rounded border px-2 mx-1 py-2 h-10 flex justify-center items-center" id="filterButton">
                    <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7"></path>
                    </svg>
                </button>
            </form>
        </div>
    </div>
    <div id="filterMenu" class="hidden absolute bg-white border border-gray-300 rounded-md mt-2 left-20 top-40 p-4 shadow-lg w-72 z-10">
        <form method="GET" action="{{ route('admin.trainingBooks') }}">
            <div class="mb-4">
                <label for="company" class="block text-sm">الشركة</label>
                @if(isset($companies))
                    <select name="company" id="company" class="form-control w-full px-2 py-2 rounded border border-gray-300">
                        <option value="">كل الشركات</option>
                        @foreach($companies as $company)
                            <option value="{{ $company->company_name }}" {{ request()->get('company') == $company->company_name ? 'selected' : '' }}>
                                {{ $company->company_name}}
                            </option>
                        @endforeach
                    </select>
                @endif
            </div>

            <button type="submit" class="bg-blue-600 text-white rounded border px-4 py-2 w-full hover:bg-blue-700">تطبيق الفلتر</button>
        </form>
    </div>


    <div class="mt-5 mr-5 ml-8 mb-6">
        <table class="w-full border-collapse border border-gray-300">
            <thead>
            <tr>
                <th class="border border-gray-300 px-4 py-2 text-right">اسم الطالب</th>
                <th class="border border-gray-300 px-4 py-2 text-right">اسم الشركة</th>
                <th class="border border-gray-300 px-4 py-2 text-right">كتاب التدريب</th>
            </tr>
            </thead>
            <tbody>
            @if($students->isEmpty())
                <tr>
                    <td colspan="8" class="border border-gray-300 px-4 py-2 text-center text-gray-500">
                        لا توجد بيانات
                    </td>
                </tr>
            @else
                @foreach($students as $evaluation)
                    <tr class="hover:bg-gray-50">
                        <td class="border border-gray-300 px-4 py-2">{{ $evaluation->full_name }}</td>
                        <td class="border border-gray-300 px-4 py-2">
                            @php
                                $acceptedApplication = $evaluation->applications->firstWhere(function ($application) {
                                    return $application->status == 'مقبول' && $application->admin_approval == 1;
                                });
                            @endphp
                            @if ($acceptedApplication && $acceptedApplication->company)
                                {{ $acceptedApplication->company->company_name }}
                            @else
                                لا توجد شركة
                            @endif
                        </td>
                        <td class="border border-gray-300 px-4 py-2">
                            @if ($evaluation->evaluations->isNotEmpty() && $evaluation->evaluations->first()->evaluation_letter)
                                <a href="{{ asset('storage/' . $evaluation->evaluations->first()->evaluation_letter) }}" target="_blank" class="text-blue-700 text-decoration-line">عرض الكتاب</a>
                            @else
                                لم يتم رفع الكتاب بعد
                            @endif
                        </td>
                    </tr>
                @endforeach

            @endif
            </tbody>
        </table>
        <div class="mt-4 flex justify-end w-full">
            {{ $students->links('vendor.pagination.simple-tailwind') }}
        </div>
    </div>
    <script>
        document.getElementById('filterButton').addEventListener('click', function () {
            let filterMenu = document.getElementById('filterMenu');
            filterMenu.classList.toggle('hidden');
        });

        document.addEventListener('click', function (event) {
            let filterMenu = document.getElementById('filterMenu');
            let filterButton = document.getElementById('filterButton');

            if (!filterMenu.contains(event.target) && !filterButton.contains(event.target)) {
                filterMenu.classList.add('hidden');
            }
        });
    </script>
@endsection
