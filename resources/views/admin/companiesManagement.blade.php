@extends('layouts.admin')

@section('content')
    <div class=" mt-6">
        <div class="flex justify-center items-center px-3 py-2">
            <h2 class="text-2xl font-bold  text-center">إدارة الشركات</h2>
        </div>
    </div>

    <div class="mt-3 mb-10 px-8" style="margin-right: 900px">
        <div class="flex items-center mb-4">
            <form method="GET" action="{{ route('admin.companiesManagement') }}" class="flex items-center mb-4">

                <input type="text" name="search" class="form-control px-2 rounded border border-gray-300 w-full py-2 h-10 w-25"
                       placeholder="البحث باسم الشركة"
                       value="{{ request()->get('search') }}">

                <button type="submit" class="bg-blue-600 text-white rounded border px-4 py-2 h-10 mx-2 hover:bg-blue-700">
                    بحث
                </button>

            </form>
        </div>
    </div>

    <div class="mt-5 mr-5 ml-8 mb-6">
        <table class="w-full border-collapse border border-gray-300">
            <thead>
            <tr>
                <th class="border border-gray-300 px-4 py-2 text-right">اسم الشركة</th>
                <th class="border border-gray-300 px-4 py-2 text-right">الموقع الإلكتروني</th>
                <th class="border border-gray-300 px-4 py-2 text-right">الوصف</th>
                <th class="border border-gray-300 px-4 py-2 text-right">العنوان</th>
                <th class="border border-gray-300 px-4 py-2 text-right">البريد الإلكتروني</th>
                <th class="border border-gray-300 px-4 py-2 text-right">رقم الجوال</th>
                <th class="border border-gray-300 px-4 py-2 text-right">الإجراءات</th>
            </tr>
            </thead>
            <tbody>
            @if($companies->isEmpty())
                <tr>
                    <td colspan="8" class="border border-gray-300 px-4 py-2 text-center text-gray-500">
                        لا توجد بيانات
                    </td>
                </tr>
            @else
                @foreach($companies as $company)
                <tr class="hover:bg-gray-50">
                    <td class="border border-gray-300 px-4 py-2">{{$company->company_name}}</td>
                    <td class="border border-gray-300 px-4 py-2">{{$company->website}}</td>
                    <td class="border border-gray-300 px-4 py-2">{{$company->description}}</td>
                    <td class="border border-gray-300 px-4 py-2">{{$company->location}}</td>
                    <td class="border border-gray-300 px-4 py-2">{{$company->user->email}}</td>
                    <td class="border border-gray-300 px-4 py-2">{{$company->phone_number}}</td>
                    <td class="border border-gray-300 px-4 py-2">
                        <div class="inline-flex space-x-2 gap-2">
                            <button onclick="openDeleteModal({{ $company->id }})"
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
            {{ $companies->links('vendor.pagination.simple-tailwind') }}
        </div>
    </div>
    <div id="deleteModal" class="fixed inset-0 flex items-center justify-center bg-gray-900 bg-opacity-50 hidden">
        <div class="bg-white p-6 rounded-lg w-1/3">
            <h2 class="text-xl font-bold mb-4 text-center">هل أنت متأكد من الحذف؟</h2>
            <p class="text-center mb-4">لن تتمكن من استعادة بيانات هذه الشركة بعد الحذف.</p>

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
            document.getElementById('deleteForm').action = `/companiesManagement/${id}`;
            document.getElementById('deleteModal').classList.remove('hidden');
        }

        function closeDeleteModal() {
            document.getElementById('deleteModal').classList.add('hidden');
        }
    </script>


@endsection
