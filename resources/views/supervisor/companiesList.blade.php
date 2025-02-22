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
            min-height: 250px; /* ضمان بقاء الحجم ثابت */
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
            width: auto; /* عرض الزر بحجم النص فقط */
            display: inline-flex; /* جعله يتكيف مع المحتوى */
            align-items: center; /* توسيط النص */
            justify-content: center;
            margin-top: 10px;
        }

        .show-students-btn:hover {
            background-color: rgb(29, 78, 216);
        }
        .company-info {
            display: block;
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

        .student-item a {
            text-decoration: none;
            color: #2c3e50;
            font-size: 14px;
        }

        .student-item a:hover {
            color: #3498db;
        }

        .student-item .download-link {
            font-size: 14px;
            color: rgb(37, 99, 235);
            text-decoration: none;
        }

        .student-item .download-link:hover {
            color: rgb(29, 78, 216);
        }

        .no-training-book {
            font-size: 14px;
            color: #e74c3c;
            font-style: italic;
        }
    </style>

    <div class="mt-6">
        <div class="flex justify-center items-center px-3 py-2">
            <h2 class="text-2xl font-bold text-center">قائمة الشركات</h2>
        </div>
    </div>

    <div class="company-container">
        @foreach([1, 2, 3] as $id)
            <div class="company-card">
                <div id="companyInfo{{ $id }}" class="company-info">
                    <h3 class="text-lg font-bold mb-2">شركة {{ $id === 1 ? 'ABC' : ($id === 2 ? 'XYZ' : 'DEF') }}</h3>
                    <p><strong>رقم الهاتف:</strong> {{ $id === 1 ? '123456789' : ($id === 2 ? '987654321' : '112233445') }}</p>
                    <p><strong>البريد الإلكتروني:</strong> {{ $id === 1 ? 'abc@example.com' : ($id === 2 ? 'xyz@example.com' : 'def@example.com') }}</p>
                    <p><strong>الموقع الإلكتروني:</strong> <a href="#">www.{{ $id === 1 ? 'abc' : ($id === 2 ? 'xyz' : 'def') }}.com</a></p>
                    <p><strong>العنوان:</strong> {{ $id === 1 ? 'غزة، فلسطين' : ($id === 2 ? 'رام الله، فلسطين' : 'نابلس، فلسطين') }}</p>
                </div>

                <div class="students-dropdown" id="studentsDropdown{{ $id }}">
                    @if($id === 1)
                        <div class="student-item">
                            <span>أحمد محمد</span>
                            <a href="#" class="download-link">تحميل كتاب التدريب</a>
                        </div>
                        <div class="student-item">
                            <span>خالد يوسف</span>
                            <span class="no-training-book">لم يتم رفع كتاب التدريب بعد</span>
                        </div>
                    @elseif($id === 2)
                        <div class="student-item">
                            <span>سالم محمود</span>
                            <a href="#" class="download-link">تحميل كتاب التدريب</a>
                        </div>
                    @else
                        <div class="student-item">
                            <span>يوسف سامي</span>
                            <a href="#" class="download-link">تحميل كتاب التدريب</a>
                        </div>
                        <div class="student-item">
                            <span>منى خالد</span>
                            <a href="#" class="download-link">تحميل كتاب التدريب</a>
                        </div>
                    @endif
                </div>

                <button class="show-students-btn" style="width: auto;" id="toggleButton{{ $id }}" onclick="toggleInfo({{ $id }})">عرض الطلاب وكتب التدريب</button>
            </div>
        @endforeach
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
