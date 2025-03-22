@extends('layouts.admin')

@section('content')
    @if (session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-2 py-2 mr-4 ml-4 mt-4 rounded relative mb-6" role="alert">
            <p class="mt-2">{{ session('success') }}</p>
        </div>
    @endif
    <div class=" mt-6">
        <div class="flex justify-center items-center px-3 py-2">
            <h2 class="text-2xl font-bold  text-center">إدارة الطلاب</h2>
        </div>
    </div>

    <div class="mt-3 mb-10 px-8" style="margin-right: 850px">
        <div class="flex items-center mb-4">
            <form method="GET" action="{{ route('admin.studentsManagement') }}" class="flex items-center mb-4">

                <input type="text" name="search" class="form-control px-1 rounded border border-gray-300 w-full py-2 h-10 w-70"
                       placeholder="البحث باسم الطالب أو الرقم الجامعي"
                       value="{{ request()->get('search') }}">


                <button type="submit" class="bg-blue-600 text-white rounded border px-4 py-2 h-10 mx-2 hover:bg-blue-700">
                    بحث
                </button>

                <button type="button" class="bg-gray-400 hover:bg-gray-500 text-white rounded border px-2 py-2 h-10 flex justify-center items-center" id="filterButton">
                    <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7"></path>
                    </svg>
                </button>

            </form>
        </div>
    </div>
    <div id="filterMenu" class="hidden absolute bg-white border border-gray-300 rounded-md mt-2 left-20 top-40 p-4 shadow-lg w-72 z-10">
        <form method="GET" action="{{ route('admin.studentsManagement') }}">
            <div class="mb-4">
                <label for="major" class="block text-sm">التخصص</label>
                <select name="major" id="major" class="form-control w-full px-2 py-2 rounded border border-gray-300">
                    <option value="">كل التخصصات</option>
                    @foreach($majors as $major)
                        <option value="{{ $major }}" {{ request()->get('major') == $major ? 'selected' : '' }}>{{ $major }}</option>
                    @endforeach
                </select>
            </div>

            <button type="submit" class="bg-blue-600 text-white rounded border px-4 py-2 w-full hover:bg-blue-700">تطبيق الفلتر</button>
        </form>
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
            <tbody id="studentsTableBody">
            @if($students->isEmpty())
                <tr>
                    <td colspan="8" class="border border-gray-300 px-4 py-2 text-center text-gray-500">
                        لا توجد بيانات
                    </td>
                </tr>
            @else
                @foreach($students as $student)
                    <tr class="hover:bg-gray-50">
                        <td class="border border-gray-300 px-4 py-2">{{$student->full_name}}</td>
                        <td class="border border-gray-300 px-4 py-2">{{$student->university_id}}</td>
                        <td class="border border-gray-300 px-4 py-2">{{$student->major}}</td>
                        <td class="border border-gray-300 px-4 py-2">{{$student->academic_year}}</td>
                        <td class="border border-gray-300 px-4 py-2">{{$student->gpa}}</td>
                        <td class="border border-gray-300 px-4 py-2">{{$student->user->email}}</td>
                        <td class="border border-gray-300 px-4 py-2">{{$student->phone_number}}</td>
                        <td class="border border-gray-300 px-4 py-2">
                            <div class="inline-flex space-x-2 gap-2">
                                <button onclick="openDeleteModal({{ $student->id }})"
                                        class="bg-red-500 text-white px-3 py-1 rounded hover:bg-red-600">
                                    حذف
                                </button>
                            </div>
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
    <div id="deleteModal" class="fixed inset-0 flex items-center justify-center bg-gray-900 bg-opacity-50 hidden">
        <div class="bg-white p-6 rounded-lg w-1/3">
            <h2 class="text-xl font-bold mb-4 text-center">هل أنت متأكد من الحذف؟</h2>
            <p class="text-center mb-4">لن تتمكن من استعادة بيانات هذا الطالب بعد الحذف.</p>

            <form id="deleteForm" method="POST">
                @csrf
                @method('DELETE')

                <div class="flex justify-center">
                    <button type="submit" class="bg-red-600 text-white px-6 py-2 rounded">
                        تأكيد الحذف
                    </button>
                    <button type="button" onclick="closeDeleteModal()" class="bg-gray-200 px-6 py-2 rounded mr-2 ml-5">
                        إلغاء
                    </button>
                </div>
            </form>
        </div>
    </div>
    <script>
        function openDeleteModal(id) {
            document.getElementById('deleteForm').action = `/studentsManagement/${id}`;
            document.getElementById('deleteModal').classList.remove('hidden');
        }

        function closeDeleteModal() {
            document.getElementById('deleteModal').classList.add('hidden');
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
