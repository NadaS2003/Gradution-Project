@extends('layouts.company')

@section('content')
    <div class="mt-6">
        <div class="flex flex-col items-center px-3 py-2">
             <h2 class="text-xl font-bold mb-4">الطلاب المقبولون في الشركة والمعتمدون من الإدارة</h2>
        </div>
    </div>

    <div class="mt-5 mr-5 ml-8 mb-6">
        <table class="w-full table table-bordered rounded">
            <thead>
            <tr >
                <th class="px-4 py-2 border w-1/3 text-right">اسم الطالب</th>
                <th class="px-4 py-2 border w-1/4 text-right">الفرصة التدريبية</th>
                <th class="px-4 py-2 border w-1/4 text-right">تاريخ القبول</th>
            </tr>
            </thead>
            <tbody>
            @forelse($approvedStudents as $student)
                <tr>
                    <td class="px-4 py-2 border text-right">{{ $student->student->full_name}}</td>
                    <td class="px-4 py-2 border text-right">{{ $student->internship->title }}</td>
                    <td class="px-4 py-2 border text-right">{{ $student->updated_at->format('Y-m-d') }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="3" class="px-4 py-2 border text-center text-gray-500">
                        لا يوجد طلاب مقبولون حتى الآن.
                    </td>
                </tr>
            @endforelse
            </tbody>
        </table>
    </div>
@endsection
