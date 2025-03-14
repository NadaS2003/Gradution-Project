@extends('layouts.supervisor')

@section('content')
    <main class="flex-1 p-6">
        <h2 class="text-2xl font-bold text-center mb-6">تفاصيل الطالب</h2>

        <div class="bg-white p-6 rounded-lg shadow mb-6 border border-gray-200">
            <h2 class="text-2xl font-bold mb-4">معلومات الطالب</h2>
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <p class="mb-1"><strong>الاسم الكامل:</strong> {{$student->full_name}} </p>
                    <p class="mb-1"><strong>الرقم الجامعي:</strong> {{$student->university_id}} </p>
                    <p class="mb-1"><strong>البريد الإلكتروني:</strong> {{$student->user->email}} </p>
                    <p class="mb-1"><strong>رقم الهاتف:</strong> {{$student->phone_number}} </p>
                    <p class="mb-1"><strong>التخصص:</strong> {{$student->major}} </p>
                    <p class="mb-1"><strong>السنة الدراسية:</strong> {{$student->academic_year}} </p>
                    <p class="mb-1"><strong>المعدل التراكمي:</strong> {{$student->gpa}} </p>
                </div>
                <div>
                    <p class="mb-1"><strong>الشركة:</strong> {{$student->applications->first()->company->company_name}}</p>
                    <p class="mb-1"><strong>تاريخ بدء التدريب:</strong> {{$student->applications->first()->internship->start_date}}</p>
                    <p class="mb-1"><strong>تاريخ انتهاء التدريب:</strong> {{$student->applications->first()->internship->end_date}}</p>
                    <p class="mb-1"><strong>مدة التدريب:</strong> {{$student->applications->first()->internship->duration}}</p>
                    @php
                        $statusText = match($student->training_status) {
                            'started' => 'بدأ',
                            'Not started' => 'لم يبدأ',
                            'completed' => 'مكتمل',
                            default => $student->training_status
                        };
                    @endphp
                    <p class="mb-1"><strong>حالة التدريب:</strong> {{ $statusText }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white p-6 rounded-lg shadow border border-gray-200 mb-5">
            <h2 class="text-lg font-bold mb-4">الحضور والغياب</h2>

            @if($studentAttendance->isNotEmpty())
                <div class="mb-4">
                    <p>عدد أيام الحضور: {{ $presentCount }}</p>
                    <p>عدد أيام الغياب: {{ $absentCount }}</p>
                </div>

                <div class="overflow-y-auto max-h-44">
                    <table class="w-full border-collapse border border-gray-300">
                        <thead>
                        <tr>
                            <th class="border border-gray-300 p-2 text-right">التاريخ</th>
                            <th class="border border-gray-300 p-2 text-right">الحالة</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($studentAttendance as $studentAttendance1)
                            <tr>
                                <td class="border border-gray-300 p-2">{{$studentAttendance1->date}}</td>
                                @php
                                    $attendanceStatus = $studentAttendance1->status;
                                    $bgColor = $attendanceStatus === 'حاضر' ? 'bg-green-700' : 'bg-red-700';
                                @endphp
                                <td class="border border-gray-300 p-2">
                            <span class="{{ $bgColor }} text-white px-3 py-1 rounded">
                                {{ $attendanceStatus }}
                            </span>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <p class="text-center text-gray-500">لا توجد بيانات حضور وغياب متاحة.</p>
            @endif
        </div>


        <div class="bg-white p-6 rounded-lg shadow border border-gray-200">
            <h2 class="text-lg font-bold mb-4">التقييمات الأسبوعية للطالب</h2>

            @if($weeklyEvaluations->isNotEmpty())
                <div class="overflow-y-auto max-h-64">
                    <table class="w-full border-collapse border border-gray-300">
                        <thead>
                        <tr>
                            <th class="border border-gray-300 p-2 text-right">اسم الأسبوع</th>
                            <th class="border border-gray-300 p-2 text-right">التقييم</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($weeklyEvaluations as $evaluation)
                            <tr>
                                <td class="border border-gray-300 p-2">{{ $evaluation->week_name }}</td>
                                <td class="border border-gray-300 p-2">
                                    <span class="text-black px-3 py-1 rounded">
                                        {{ $evaluation->evaluation }}
                                    </span>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <p class="text-center text-gray-500">لا توجد تقييمات أسبوعية متاحة.</p>
            @endif
        </div>

    </main>
@endsection
