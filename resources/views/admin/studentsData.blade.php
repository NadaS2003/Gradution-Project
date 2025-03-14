@extends('layouts.admin')

@section('content')
    @if (session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4 mt-2 mr-2 ml-2" role="alert">
            <span class="block sm:inline">{{ session('success') }}</span>
        </div>
    @endif

    @if (session('error'))
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4 mt-2 mr-2 ml-2 " role="alert">
            <span class="block sm:inline">{{ session('error') }}</span>
        </div>
    @endif

    <div class="mt-6">
        <div class="flex justify-center items-center px-3 py-2">
            <h2 class="text-2xl font-bold text-center">بيانات الطلاب المتدربين</h2>
        </div>
    </div>

    <div class="mt-3 mb-10 px-8 flex justify-end">
        <form id="search-form" action="{{ route('admin.studentsData') }}" method="GET" class="flex items-center gap-3">
            <input type="text" name="student_name" class="form-control px-2 rounded border border-gray-300 py-2 h-10 w-60" placeholder="ابحث باسم الطالب">
            <button type="submit" class="bg-blue-600 text-white rounded border px-4 py-2 h-10 hover:bg-blue-700">بحث</button>
            <button type="button" class="bg-gray-400 hover:bg-gray-500 text-white rounded border px-2 py-2 h-10 flex justify-center items-center" id="filterButton">
                <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7"></path>
                </svg>
            </button>
        </form>
        <button onclick="openModal()" class="bg-blue-600 text-white rounded border px-4 py-2 h-10 hover:bg-blue-700">
            إضافة مشرف لطالب
        </button>
    </div>



    <div id="filterMenu" class="hidden absolute bg-white border border-gray-300 rounded-md mt-2 left-20 top-40 p-4 shadow-lg w-72 z-10">
        <form method="GET" action="{{ route('admin.studentsData') }}">
            <div class="mb-4">
                <label for="company_id" class="block text-sm">الشركة</label>
                <select name="company_id" id="company_id" class="form-control w-full px-2 py-2 mb-5 rounded border border-gray-300">
                    <option value="">اختر الشركة</option>
                    @foreach($companies as $company)
                        <option value="{{ $company->id }}">{{ $company->company_name }}</option>
                    @endforeach
                </select>
                <label for="supervisor_id" class="block text-sm">المشرف</label>
                <select name="supervisor_id" class="form-control w-full px-2 py-2 rounded border border-gray-300">
                    <option value="">اختر المشرف</option>
                    @foreach($supervisors as $supervisor)
                        <option value="{{ $supervisor->id }}">{{ $supervisor->full_name }}</option>
                    @endforeach
                </select>
            </div>
            <button type="submit" class="bg-blue-600 text-white rounded border px-4 py-2 w-full hover:bg-blue-700">تطبيق الفلتر</button>
        </form>
    </div>
    <div class="mt-5 mr-5 ml-8 mb-6">
        <table class="w-full border-collapse border border-gray-300" id="students-list">
            <thead>
            <tr>
                <th class="border border-gray-300 px-4 py-2 text-right">اسم الطالب</th>
                <th class="border border-gray-300 px-4 py-2 text-right">الشركة</th>
                <th class="border border-gray-300 px-4 py-2 text-right">الفرصة التدريبية</th>
                <th class="border border-gray-300 px-4 py-2 text-right">المشرف</th>
            </tr>
            </thead>
            <tbody>
            @if($studentsData->isEmpty())
                <tr>
                    <td colspan="8" class="border border-gray-300 px-4 py-2 text-center text-gray-500">
                        لا توجد بيانات
                    </td>
                </tr>
            @else
            @foreach($studentsData as $student)
                <tr class="hover:bg-gray-50">
                    <td class="border border-gray-300 px-4 py-2">{{ $student->student_name }}</td>
                    <td class="border border-gray-300 px-4 py-2">{{ $student->company_name }}</td>
                    <td class="border border-gray-300 px-4 py-2">{{ $student->internship_title }}</td>
                    <td class="border border-gray-300 px-4 py-2">{{ $student->supervisor_name ?? 'لم يتم التعيين' }}</td>
                </tr>
            @endforeach
            @endif
            </tbody>
        </table>
        <div class="mt-4 flex justify-end w-full">

            {{ $studentsData->links('vendor.pagination.simple-tailwind') }}

        </div>
    </div>

    <div id="evaluationModal" class="fixed inset-0 flex items-center justify-center bg-gray-800 bg-opacity-50 hidden">
        <div class="bg-white p-12 rounded-lg shadow-lg w-96 relative">
            <button onclick="closeModal()" class="absolute top-5 left-5 text-gray-500 hover:text-gray-800 text-xl font-bold">
                ×
            </button>

            <h3 class="text-xl font-semibold mb-4 text-center">اختيار مشرف</h3>

            <form action="{{ route('assign-supervisor') }}" method="POST" id="assign-supervisor-form">
                @csrf

                <label class="block text-sm font-medium text-gray-700 mb-1">اختر الطالب:</label>
                <select name="student_id" class="w-full px-3 py-2 border rounded mb-3">
                    @foreach($students as $student)
                        <option value="{{ $student->id }}">{{ $student->full_name }}</option>
                    @endforeach
                </select>

                <label class="block text-sm font-medium text-gray-700 mb-1">اختر المشرف:</label>
                <select name="supervisor_id" class="w-full px-3 py-2 border rounded mb-4">
                    @foreach($supervisors as $supervisor)
                        <option value="{{ $supervisor->id }}">{{ $supervisor->full_name }}</option>
                    @endforeach
                </select>

                <div class="flex justify-center">
                    <button type="submit" class="bg-blue-500 text-white px-6 py-2 rounded hover:bg-blue-600">
                        حفظ
                    </button>
                </div>
            </form>
        </div>
    </div>


    <script>
        function openModal() {
            document.getElementById("evaluationModal").classList.remove("hidden");
        }

        function closeModal() {
            document.getElementById("evaluationModal").classList.add("hidden");
        }
    </script>
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
