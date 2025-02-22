@extends('layouts.supervisor')
@section('content')
    <main class="flex-1 p-6">
        <h2 class="text-2xl font-bold text-center mb-6">تفاصيل الطالب</h2>

        <!-- Student Info -->
        <div class="bg-white p-6 rounded-lg shadow mb-6 border border-gray-200">
            <h2 class="text-2xl font-bold mb-4">معلومات الطالب</h2>
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <p class="mb-1"><strong>الاسم الكامل:</strong> هلا محمد</p>
                    <p class="mb-1"><strong>الرقم الجامعي:</strong> 220203741</p>
                    <p class="mb-1"><strong>البريد الإلكتروني:</strong> hala@gmail.com</p>
                    <p class="mb-1"><strong>رقم الهاتف:</strong> 0596321475</p>
                    <p class="mb-1"><strong>التخصص:</strong> تطوير برمجيات</p>
                    <p class="mb-1"><strong>السنة الدراسية:</strong> 3</p>
                    <p class="mb-1"><strong>المعدل التراكمي:</strong> 77</p>
                </div>
                <div>
                    <p class="mb-1"><strong>الشركة:</strong> التكنولوجيا</p>
                    <p class="mb-1"><strong>تاريخ بدء التدريب:</strong> 15/4/2020</p>
                    <p class="mb-1"><strong>تاريخ انتهاء التدريب:</strong> 15/7/2020</p>
                    <p class="mb-1"><strong>مدة التدريب:</strong> 3 أشهر</p>
                    <p class="mb-1"><strong>حالة التدريب:</strong> بدأ</p>
                </div>
            </div>
        </div>

        <!-- Attendance Table -->
        <div class="bg-white p-6 rounded-lg shadow border border-gray-200">
            <h2 class="text-lg font-bold mb-4">الحضور والغياب</h2>
            <table class="w-full border-collapse border border-gray-300">
                <thead>
                <tr>
                    <th class="border border-gray-300 p-2 text-right">التاريخ</th>
                    <th class="border border-gray-300 p-2 text-right">الحالة</th>
                </tr>
                </thead>
                <tbody>
                <tr>
                    <td class="border border-gray-300 p-2">10-2-2020</td>
                    <td class="border border-gray-300 p-2"><span class="bg-green-700 text-white px-3 py-1 rounded">حاضر</span></td>
                </tr>
                <tr>
                    <td class="border border-gray-300 p-2">5-2-2020</td>
                    <td class="border border-gray-300 p-2"><span class="bg-red-500 text-white px-3 py-1 rounded">غائب</span></td>
                </tr>
                </tbody>
            </table>
        </div>

    </main>
@endsection
