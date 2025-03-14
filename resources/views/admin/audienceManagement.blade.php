@extends('layouts.admin')

@section('content')
    <div class="mt-6">
        <div class="flex justify-center items-center px-3 py-2">
            <h2 class="text-2xl font-bold text-center">إدارة الحضور و الغياب</h2>
        </div>
    </div>

    <div class="flex justify-end mt-3 mb-5 px-8 gap-3">
        <form action="{{ route('admin.audienceManagement') }}" method="GET" class="flex items-center gap-2">
            <input type="text" name="search" class="form-control px-2 rounded border border-gray-300 py-2 h-10 w-25" placeholder="البحث باسم الشركة أو اسم الطالب" value="{{ request()->input('search') }}">
            <button type="submit" class="bg-blue-600 text-white rounded border px-4 py-2 h-10 hover:bg-blue-700">بحث</button>
        </form>

        <form action="{{ route('admin.attendance.export') }}" method="GET" class="flex items-center gap-2">
            <button type="submit" class="bg-blue-600 text-white rounded border px-4 py-2 h-10 w-32 hover:bg-blue-700">تصدير ملف اكسل</button>
        </form>
    </div>



    <div class="mt-5 mr-5 ml-8 mb- overflow-y-auto max-h-56">
        <table class="min-w-full border-collapse border border-gray-300">
            <thead>
            <tr>
                <th class="border border-gray-300 px-4 py-2 text-right">اسم الطالب</th>
                <th class="border border-gray-300 px-4 py-2 text-right">الشركة</th>
                <th class="border border-gray-300 px-4 py-2 text-right">عدد أيام الحضور</th>
                <th class="border border-gray-300 px-4 py-2 text-right">عدد أيام الغياب</th>
                <th class="border border-gray-300 px-4 py-2 text-right">ملاحظات</th>

            </tr>
            </thead>
            <tbody>
            @if(collect($attendanceDataPaginator)->isEmpty())
                <tr>
                    <td colspan="8" class="border border-gray-300 px-4 py-2 text-center text-gray-500">
                        لا توجد بيانات
                    </td>
                </tr>
            @else
                @foreach($attendanceDataPaginator as $attendance)
                    <tr class="hover:bg-gray-50">
                        <td class="border border-gray-300 px-4 py-2">
                            {{ $attendance['student']->full_name ?? 'غير موجود' }}
                        </td>
                        <td class="border border-gray-300 px-4 py-2">
                            @php
                                $acceptedApplication = $attendance['student']->applications->firstWhere(function ($application) {
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
                            {{ $attendance['present_days'] ?? 0 }}
                        </td>
                        <td class="border border-gray-300 px-4 py-2">
                            {{ $attendance['absent_days'] ?? 0 }}
                        </td>
                        <td class="border border-gray-300 px-4 py-2">
                            {{ $attendance['message'] ?? '' }}
                        </td>
                    </tr>
                @endforeach

            @endif
            </tbody>
        </table>
        <div class="mt-4 flex justify-end w-full">
            {{ $attendanceDataPaginator->links('vendor.pagination.simple-tailwind') }}
        </div>

    </div>
@endsection
