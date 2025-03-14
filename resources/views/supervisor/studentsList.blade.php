@extends('layouts.supervisor')

@section('content')
    <div class="mt-6">
        <div class="flex justify-center items-center px-3 py-2">
            <h2 class="text-2xl font-bold text-center mb-6">قائمة الطلبة</h2>
        </div>
    </div>

    <div class="mt-5 mr-5 ml-8 mb-6">
        @if($students->isEmpty())
            <div class="text-center text-gray-500 text-lg font-semibold bg-gray-100 py-4 rounded">
                لا يوجد طلاب حتى الآن.
            </div>
        @else
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
                @foreach($students as $student)
                    <tr class="hover:bg-gray-50">
                        <td class="border border-gray-300 px-4 py-2">{{$student->full_name}}</td>
                        <td class="border border-gray-300 px-4 py-2">
                            {{ optional($student->applications->where('status', 'مقبول')->where('admin_approval', 1)->first()->company)->company_name ?? 'غير متوفر' }}
                        </td>
                        <td class="border border-gray-300 px-4 py-2">
                            @php
                                $status = $student->training_status;
                                $bgColor = '';
                                $statusText = '';

                                if ($status === 'started') {
                                    $bgColor = 'bg-yellow-400';
                                    $statusText = 'بدأ';
                                } elseif ($status === 'Not started') {
                                    $bgColor = 'bg-red-500';
                                    $statusText = 'لم يبدأ';
                                } elseif ($status === 'completed') {
                                    $bgColor = 'bg-green-500';
                                    $statusText = 'مكتمل';
                                }
                            @endphp

                            <span class="text-white px-2 py-1 rounded {{ $bgColor }}">
                                {{ $statusText }}
                            </span>
                        </td>
                        <td class="border border-gray-300 px-4 py-2">
                            <a href="{{ route('supervisor.studentDetails', ['id' => $student->id]) }}"
                               class="bg-blue-600 text-white px-3 py-1 rounded hover:bg-blue-700">
                                تفاصيل
                            </a>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>

            <div class="mt-4 flex justify-end w-full">
                {{ $students->links('vendor.pagination.simple-tailwind') }}
            </div>
        @endif
    </div>
@endsection
