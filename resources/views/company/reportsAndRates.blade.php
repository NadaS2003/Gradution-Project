@extends('layouts.company')
@section('title', 'التقييمات والتقارير')

@section('content')
    @if (session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-2 py-2 mr-4 ml-4 mt-4 rounded relative mb-6" role="alert">
            <p class="mt-2">{{ session('success') }}</p>
        </div>
    @endif
    @if (session('error'))
        <div class="bg-red-100 border border-red-400 text-red-700 px-2 py-2 mr-4 ml-4 mt-4 rounded relative mb-6" role="alert">
            <p class="mt-2">{{ session('error') }}</p>
        </div>
    @endif
    @if ($errors->any())
        <div class="bg-red-100 border border-red-400 text-red-700 px-2 py-2 mr-4 ml-4 mt-4 rounded relative mb-6" role="alert">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="mt-6">
        <div class="flex flex-col items-center px-3 py-2">
            <h2 class="text-2xl font-bold text-center mb-6">التقييمات و التقارير</h2>
        </div>
    </div>
    <div class="mt-5 mr-5 ml-8 mb-20 border border-black border-opacity-20 rounded p-7">

        <div class="mb-6">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-xl font-bold mb-0">سجل الحضور والغياب</h3>
                <div class="flex gap-2">
                    <button onclick="openModal('attendanceModal')" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">تسجيل الحضور و الغياب</button>
                    <button onclick="openModal('uploadModal')" class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700">رفع كتاب التدريب</button>
                    <a href="{{ route('attendance.export')}}" class="bg-yellow-600 text-white px-4 py-2 rounded hover:bg-yellow-700">
                        تصدير الحضور
                    </a>

                </div>
            </div>

            <select id="attendanceFilter" class="border p-2 rounded w-full mb-5">
                <option value="all">الكل</option>
                @foreach ($students as $student)
                    <option value="{{ $student->id }}">{{ $student->full_name }}</option>
                @endforeach
            </select>
            <div class="border rounded-lg overflow-auto max-h-56">
                @if($attendanceData->isEmpty())

                    <div class="text-center text-gray-500">
                        لا توجد بيانات حضورو غياب  حاليا
                    </div>
                @else
                <table class="w-full table table-bordered rounded" id="attendanceTable">
                    <thead class="thead-light">
                    <tr>
                        <th class="px-4 py-2 border w-1/3 text-right">اسم الطالب</th>
                        <th class="px-4 py-2 border w-1/3 text-right">التاريخ</th>
                        <th class="px-4 py-2 border w-1/3 text-right">الحالة</th>
                        <th class="px-4 py-2 border w-1/3 text-right">الإجراءات</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($attendanceData as $attendanceData1)
                        <tr class="attendance-row" data-student-id="{{ $attendanceData1->student->id }}" data-attendance-id="{{ $attendanceData1->id }}">
                            <td class="px-4 py-2 border">{{ $attendanceData1->student->full_name }}</td>
                            <td class="px-4 py-2 border">{{ $attendanceData1->date }}</td>
                            <td class="px-4 py-2 border">
                <span class="px-2 py-1 rounded
                    @if($attendanceData1->status == 'حاضر') bg-green-700 @elseif($attendanceData1->status == 'غائب') bg-red-700 @endif text-white">
                    {{ $attendanceData1->status }}
                </span>
                            </td>
                            <td class="px-4 py-2 border">
                                <button type="button" class="bg-yellow-500 text-white px-4 py-1 rounded hover:bg-yellow-600" onclick="openModaledits({{ $attendanceData1->id }})">
                                    تعديل
                                </button>
                            </td>
                        </tr>

                        <div id="modal-{{ $attendanceData1->id }}" class="fixed inset-0 flex items-center justify-center bg-gray-800 bg-opacity-50 hidden">
                            <div class="bg-white p-6 rounded-lg shadow-lg w-96 relative">
                                <button type="button" onclick="closeModaledits({{ $attendanceData1->id }})" class="absolute top-5 left-5 text-gray-500 hover:text-gray-800 text-xl font-bold">×</button>

                                <form method="POST" action="{{ route('attendance.update', $attendanceData1->id) }}">
                                    @csrf
                                    @method('PUT')

                                    <h3 class="text-xl font-bold mb-5 text-center">تعديل الحالة</h3>
                                    <div class="mb-4">
                                        <label class="block text-sm font-medium text-gray-700">اختر الحالة:</label>
                                        <select name="status" class="border p-2 rounded w-full">
                                            <option value="حاضر" {{ $attendanceData1->status == 'حاضر' ? 'selected' : '' }}>حاضر</option>
                                            <option value="غائب" {{ $attendanceData1->status == 'غائب' ? 'selected' : '' }}>غائب</option>
                                        </select>
                                    </div>

                                    <div class="flex justify-center">
                                        <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded hover:bg-blue-700">تحديث</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    @endforeach
                    </tbody>
                </table>
                @endif
            </div>


        <div>
            <div class="flex items-center justify-between mb-4 mt-10">
                <h3 class="text-xl font-bold mb-0">التقييم الأسبوعي</h3>
                <div class="flex gap-2">
                    <button onclick="openModal('evaluationModal')" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                        إدخال التقييمات الأسبوعية
                    </button>
                    <a href="{{ route('export.evaluations') }}" class="bg-yellow-600 text-white px-4 py-2 rounded hover:bg-yellow-700 ml-2">
                        تصدير التقييمات
                    </a>
                </div>
            </div>

            <select id="evaluationFilter" class="border p-2 rounded w-full mb-5">
                <option value="all">الكل</option>
                @foreach ($students as $student)
                    <option value="{{ $student->id }}">{{ $student->full_name }}</option>
                @endforeach
            </select>

            <div class="border rounded-lg overflow-auto max-h-56">
                @if($evaluations->isEmpty())

                    <div class="text-center text-gray-500">
                        لا توجد تقييمات أسبوعية حاليا
                    </div>
                @else
                <table class="w-full table table-bordered rounded" id="evaluationTable">
                    <thead class="thead-light">
                    <tr>
                        <th class="px-4 py-2 border text-right">اسم الطالب</th>
                        @foreach($weeks as $week)
                            <th class="px-4 py-2 border text-right">{{ $week }}</th>
                        @endforeach
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($students as $student)
                        <tr class="border" data-student-id="{{ $student->id }}">
                            <td class="px-4 py-2 border">{{ $student->full_name }}</td>
                            @foreach($weeks as $week)
                                @php
                                    $evaluation = $evaluations->where('student_id', $student->id)->where('week_name', $week)->first();
                                @endphp
                                <td class="px-4 py-2 border cursor-pointer
                                    {{ $evaluation ? 'bg-gray-100 hover:bg-gray-200' : 'bg-gray-200 text-gray-500 cursor-not-allowed' }}"
                                    @if($evaluation)
                                        onclick="openEditModal({{ $student->id }}, '{{ $evaluation->week_name ?? '' }}', '{{ $evaluation->evaluation ?? '' }}', {{ $evaluation->id ?? 'null' }})"
                                    title="اضغط لتعديل التقييم"
                                    @endif>

                                    @if($evaluation)
                                        <span class="flex items-center space-x-2">
                                            <span class="text-gray-800 font-medium">{{ $evaluation->evaluation }}</span>
                                                   <svg class="w-4 h-4 text-blue-600 hover:text-blue-800 transition duration-200 ml-5"
                                                        xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                                        <path d="M17.414 2.586a2 2 0 00-2.828 0l-10 10A2 2 0 004 14v4h4a2 2 0 001.414-.586l10-10a2 2 0 000-2.828l-2-2z" />
                                                    </svg>

                                        </span>
                                    @else
                                        <span class="italic text-gray-500">إضافة تقييم</span>
                                    @endif
                                </td>



                            @endforeach
                        </tr>
                    @endforeach
                    </tbody>
                </table>
                @endif
            </div>

        </div>

            <div>
                <div class="flex items-center justify-between mb-4 mt-10">
                    <h3 class="text-xl font-bold mb-0">الكتب التدريبية</h3>
                </div>

                <div class="border rounded-lg overflow-auto max-h-56">
                    @if($trainingBooks->isEmpty())

                        <div class="text-center text-gray-500">
                            لا توجد كتب تدريبية حاليا
                        </div>
                    @else
                    <table class="w-full table table-bordered rounded" id="trainingBooksTable">
                        <thead class="thead-light">
                        <tr>
                            <th class="px-4 py-2 border text-right">اسم الطالب</th>
                            <th class="px-4 py-2 border text-right">كتاب التدريب</th>

                        </tr>
                        </thead>
                        <tbody>
                        @foreach($trainingBooks as $student)
                            <tr class="border" data-student-id="{{ $student->id }}">
                                <td class="px-4 py-2 border">{{ $student->full_name }}</td>
                                <td class="px-4 py-2 border cursor-pointer">
                                    @if($student->evaluation_letter)
                                        <a href="{{ asset('storage/'.$student->evaluation_letter) }}" target="_blank" class="text-blue-500 hover:text-blue-700">كتاب التدريب</a>
                                    @else
                                        <span class="italic text-gray-500">لم يتم رفع الكتاب بعد</span>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                        </tbody>


                    </table>
                    @endif
                </div>

            </div>
    </div>

    <!-- نوافذ منبثقة -->
    <div id="evaluationModal" class="fixed inset-0 flex items-center justify-center bg-gray-800 bg-opacity-50 hidden">
        <div class="bg-white p-6 rounded-lg shadow-lg w-96 relative">
            <button onclick="closeModal('evaluationModal')" class="absolute top-5 left-5 text-gray-500 hover:text-gray-800 text-xl font-bold">×</button>
            <form action="{{ route('weekly_evaluations.store') }}" method="POST" onsubmit="return validateWeekSelection()">
                @csrf
                <h3 class="text-xl font-bold mb-5 text-center">التقييم الأسبوعي</h3>
                <div class="modal-body ml-4 mr-4">
                    <div class="mb-4">
                        <label for="weekSelect" class="block text-sm font-medium text-gray-700">اختر الأسبوع:</label>
                        <select id="weekSelect" name="week_name" class="border p-2 rounded w-full" onchange="toggleWeekInput()">
                            <option value="">-- اختر الأسبوع --</option>
                            @foreach($weeks as $week)
                                <option value="{{ $week }}">{{ $week }}</option>
                            @endforeach
                            <option value="new">إضافة أسبوع جديد...</option>
                        </select>
                    </div>

                    <div id="newWeekDiv" class="mb-4 hidden">
                        <label for="newWeekInput" class="block text-sm font-medium text-gray-700">أدخل اسم الأسبوع الجديد:</label>
                        <input type="text" id="newWeekInput" name="new_week_name" class="border p-2 rounded w-full" placeholder="أدخل اسم الأسبوع">
                    </div>

                    <div class="mb-3">
                        <label class="block text-sm font-medium text-black-700 mb-1">اختر الطالب:</label>
                        <select class="w-full px-3 py-2 border rounded mb-3" name="student_id" required>
                            @foreach ($students as $student)
                                <option value="{{ $student->id }}">{{ $student->full_name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="block text-sm font-medium text-black-700 mb-1">التقييم:</label>
                        <input type="number" class="w-full px-3 py-2 border rounded mb-3" name="evaluation" required>
                    </div>

                    <div class="flex justify-center">
                        <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded hover:bg-blue-700">حفظ</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <div id="editEvaluationModal" class="fixed inset-0 bg-gray-500 bg-opacity-50 flex justify-center items-center hidden">
            <div class="bg-white p-6 rounded-lg shadow-lg w-96 relative">
                <button onclick="closeModal('editEvaluationModal')" class="absolute top-3 right-3 text-gray-500 hover:text-gray-800 text-xl font-bold">×</button>
                <h2 class="text-lg font-bold mb-4">تعديل التقييم</h2>

                <form id="editForm" action="" method="POST">
                    @csrf
                    @method('PUT')

                    <input type="hidden" id="editStudentId" name="student_id">
                    <input type="hidden" id="editWeek" name="week_name">
                    <input type="hidden" id="evaluationId" name="id">

                    <label for="editEvaluation" class="block text-sm font-medium text-gray-700 mb-2">التقييم:</label>
                    <input type="number" id="editEvaluation" name="evaluation" class="border p-2 w-full rounded mb-3" required>

                    <div class="flex justify-end mt-4">
                        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">حفظ</button>
                    </div>
                </form>

            </div>
        </div>
    <div id="attendanceModal" class="fixed inset-0 flex items-center justify-center bg-gray-800 bg-opacity-50 hidden">
        <div class="bg-white p-6 rounded-lg shadow-lg w-96 relative">
            <button onclick="closeModal('attendanceModal')" class="absolute top-5 left-5 text-gray-500 hover:text-gray-800 text-xl font-bold">×</button>
            <form action="{{ route('attendance.store') }}" method="POST">
                @csrf
                @method('POST')

                <div class="modal-content">
                    <h3 class="text-xl font-bold mb-5 text-center ">تسجيل الحضور والغياب</h3>

                    <div class="modal-body ml-4 mr-4">
                        <div class="mb-3">
                            <label class="block text-sm font-medium text-black-700 mb-1">اختر الطالب</label>
                            <select class="w-full px-3 py-2 border rounded mb-3" name="student_id" required>
                                @foreach ($students as $student)
                                    <option value="{{ $student->id }}">{{ $student->full_name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="block text-sm font-medium text-black-700 mb-1">تاريخ الحضور:</label>
                            <input type="date" class="w-full px-3 py-2 border rounded mb-3" name="attendance_date" required>
                        </div>
                        <div class="mb-3">
                            <label class="block text-sm font-medium text-black-700 mb-1">الحالة:</label>
                            <select class="w-full px-3 py-2 border rounded mb-3" name="attendance_status" required>
                                <option value="حاضر">حاضر</option>
                                <option value="غائب">غائب</option>
                            </select>
                        </div>
                        <div class="flex justify-center">
                            <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded hover:bg-blue-700">تسجيل الحضور</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <div id="uploadModal" class="fixed inset-0 flex items-center justify-center bg-gray-800 bg-opacity-50 hidden">
        <div class="bg-white p-6 rounded-lg shadow-lg w-96 relative">
            <button onclick="closeModal('uploadModal')" class="absolute top-5 left-5 text-gray-500 hover:text-gray-800 text-xl font-bold">×</button>
            <form action="{{ route('upload.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('POST')

                <div class="modal-content">
                    <h3 class="text-xl font-bold mb-5 text-center ">رفع كتاب التدريب</h3>
                    <div class="modal-body  ml-4 mr-4">
                        <div class="mb-3">
                            <label class="block text-sm font-medium text-black-700 mb-1">اسم الطالب:</label>
                            <select class="w-full px-3 py-2 border rounded mb-3" name="student_id" required>
                                @foreach ($students as $student)
                                    <option value="{{ $student->id }}">{{ $student->full_name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="block text-sm font-medium text-black-700 mb-1">كتاب التدريب:</label>
                            <input type="file" class="w-full px-3 py-2 border rounded mb-3" name="training_book" required>
                        </div>
                        <div class="flex justify-center">
                            <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded hover:bg-blue-700">حفظ</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <script>
        document.getElementById('attendanceFilter').addEventListener('change', function() {
            var selectedStudentId = this.value;
            var rows = document.querySelectorAll('#attendanceTable .attendance-row');

            rows.forEach(function(row) {
                var studentId = row.getAttribute('data-student-id');

                if (selectedStudentId === 'all' || studentId === selectedStudentId) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            });
        });

        document.getElementById('evaluationFilter').addEventListener('change', function() {
            var selectedStudentId = this.value;
            var rows = document.querySelectorAll('#evaluationTable tbody tr');

            rows.forEach(function(row) {
                var studentId = row.getAttribute('data-student-id');

                if (selectedStudentId === 'all' || studentId === selectedStudentId) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            });
        });

        function refreshEvaluations() {
            fetch('/companyReportsAndRates')
                .then(response => response.text())
                .then(html => {
                    document.getElementById('evaluationTable').innerHTML = html;
                })
                .catch(error => console.error('Error:', error));
        }

        function openModal(modalId) {
            document.getElementById(modalId).classList.remove('hidden');
        }

        function closeModal(modalId) {
            document.getElementById(modalId).classList.add('hidden');
        }

        function toggleWeekInput() {
            let weekSelect = document.getElementById('weekSelect');
            let newWeekDiv = document.getElementById('newWeekDiv');
            let newWeekInput = document.getElementById('newWeekInput');

            if (weekSelect.value === "new") {
                newWeekDiv.classList.remove("hidden");
                newWeekInput.setAttribute("required", "true");
            } else {
                newWeekDiv.classList.add("hidden");
                newWeekInput.removeAttribute("required");
            }
        }

        function validateWeekSelection() {
            let weekSelect = document.getElementById('weekSelect');
            let newWeekInput = document.getElementById('newWeekInput');

            if (weekSelect.value === "new" && newWeekInput.value.trim() === "") {
                alert("يرجى إدخال اسم الأسبوع الجديد.");
                return false;
            }
            return true;
        }
    </script>
        <script>
            function openEditModal(studentId, week, evaluation, evaluationId) {
                console.log("evaluationId:", evaluationId);

                document.getElementById('editStudentId').value = studentId;
                document.getElementById('editWeek').value = week;
                document.getElementById('editEvaluation').value = evaluation;
                document.getElementById('evaluationId').value = evaluationId;

                let formAction = "/update-weekly-evaluation/" + evaluationId;
                console.log("Form action:", formAction);

                document.getElementById('editForm').action = formAction;

                document.getElementById('editEvaluationModal').classList.remove('hidden');
            }

            function openModal(modalId) {
                document.getElementById(modalId).classList.remove('hidden');
            }

            function closeModal(modalId) {
                document.getElementById(modalId).classList.add('hidden');
            }

        </script>
        <script>
            function openModaledits(id) {
                document.getElementById('modal-' + id).classList.remove('hidden');
            }

            function closeModaledits(id) {
                document.getElementById('modal-' + id).classList.add('hidden');
            }
        </script>

@endsection
