@extends('layouts.supervisor')

@section('content')
    <style>
        .company-container {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 15px;
        }

        .company-card {
            background: #ffffff;
            padding: 15px;
            border-radius: 8px;
            border: 1px solid #ddd;
            transition: box-shadow 0.3s;
            position: relative;
            min-height: 250px;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }

        .company-card:hover {
            box-shadow: 0px 6px 18px rgba(0, 0, 0, 0.15);
        }

        .company-card h3 {
            text-align: center;
            color: #2c3e50;
            font-size: 18px;
            margin-bottom: 10px;
        }

        .company-card p {
            font-size: 14px;
            margin: 5px 0;
            color: #34495e;
        }

        .show-students-btn {
            background-color: rgb(37, 99, 235);
            color: white;
            padding: 6px 12px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 14px;
            width: auto;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            margin-top: 10px;
        }

        .show-students-btn:hover {
            background-color: rgb(29, 78, 216);
        }

        .students-dropdown {
            display: none;
        }

        .student-item {
            background: #ecf0f1;
            padding: 8px;
            margin-bottom: 8px;
            border-radius: 5px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .student-item a:hover {
            color: #3498db;
        }

        .no-training-book {
            font-size: 14px;
            color: #e74c3c;
            font-style: italic;
        }
    </style>
    <div class="mt-4 ml-6 mr-6">
        <div class="mt-2">
            <div class="flex justify-center items-center px-3 py-2">
                <h2 class="text-2xl font-bold text-center">قائمة الشركات</h2>
            </div>
        </div>

        <div class="company-container">
            @foreach($companies as $company)
                <div class="company-card">
                    <div id="companyInfo{{$company->id}}" class="company-info">
                        <h3 class="text-lg font-bold mb-2">{{ $company->company_name }}</h3>
                        <p><strong>رقم الهاتف:</strong> {{ $company->phone_number }}</p>
                        <p><strong>البريد الإلكتروني:</strong> {{ $company->user->email }}</p>
                        <p><strong>الموقع الإلكتروني:</strong> <a href="{{ $company->website }}" target="_blank">{{ $company->website }}</a></p>
                        <p><strong>العنوان:</strong> {{ $company->location }}</p>
                    </div>

                    <div class="students-dropdown" id="studentsDropdown{{$company->id}}">
                        @if(isset($companyStudents[$company->id]) && $companyStudents[$company->id]->isNotEmpty())
                            @foreach($companyStudents[$company->id] as $studentWithStatus)
                                @if($studentWithStatus['status'] == 'مقبول')  <!-- فقط الطلاب المقبولين -->
                                <div class="student-item">
                                    <span>{{ $studentWithStatus['student']->full_name }}</span>

                                    @php
                                        $studentEvaluations = $studentWithStatus['student']->evaluations->where('company_id', $company->id);
                                    @endphp

                                    @if($studentEvaluations->isNotEmpty())
                                        @foreach($studentEvaluations as $evaluation)
                                            <div class="evaluation-item">
                                                @if($evaluation->evaluation_letter)
                                                    <a href="{{ asset('storage/' . $evaluation->evaluation_letter) }}" class="text-blue-500 italic hover:text-white" target="_blank">تحميل كتاب التدريب</a>
                                                @else
                                                    <span class="no-training-book">لم يتم رفع كتاب التدريب بعد</span>
                                                @endif
                                            </div>
                                        @endforeach
                                    @else
                                        <span class="no-training-book">لم يتم رفع كتاب التدريب بعد</span>
                                    @endif

                                </div>
                                @endif
                            @endforeach
                        @else
                            <p>لا يوجد طلاب لهذه الشركة.</p>
                        @endif
                    </div>


                    <button class="show-students-btn" id="toggleButton{{ $company->id }}" onclick="toggleInfo({{ $company->id }})">عرض الطلاب وكتب التدريب</button>
                </div>
            @endforeach
        </div>



    @if($companies->isEmpty())
            <p class="text-center text-gray-500 mt-4">لا توجد شركات متاحة حاليًا.</p>
        @endif

    </div>
    <script>
        function toggleInfo(companyId) {
            var companyInfo = document.getElementById("companyInfo" + companyId);
            var studentsDropdown = document.getElementById("studentsDropdown" + companyId);
            var button = document.getElementById("toggleButton" + companyId);

            if (companyInfo.style.display === "none") {
                companyInfo.style.display = "block";
                studentsDropdown.style.display = "none";
                button.textContent = "عرض الطلاب وكتب التدريب";
            } else {
                companyInfo.style.display = "none";
                studentsDropdown.style.display = "block";
                button.textContent = "عرض معلومات الشركة";
            }
        }
    </script>
@endsection
