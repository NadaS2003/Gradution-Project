@extends('layouts.admin')

@section('content')
    <div class=" mt-6">
        <div class="flex justify-center items-center px-3 py-2">
            <h2 class="text-2xl font-bold  text-center">بيانات الطلاب المتدربين</h2>
        </div>
    </div>

    <div class="mt-3 mb-5 px-8 flex flex-col items-end gap-3">
        <div class="flex items-center gap-3 mb-4">
            <input type="text" class="form-control px-2 rounded border border-gray-300 w-96 py-2 h-10" placeholder="البحث">
            <button class="bg-blue-600 text-white rounded border px-4 py-2 h-10 hover:bg-blue-700">بحث</button>
            <button class="bg-gray-400 hover:bg-gray-500 text-white rounded border px-2 py-2 h-10 flex justify-center items-center">
                <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7"></path>
                </svg>
            </button>
            <button onclick="openModal()" class="bg-blue-600 text-white rounded border px-4 py-2 h-10 w-30 hover:bg-blue-700">إضافة مشرف لطالب</button>
        </div>
    </div>


    <div class="mt-5 mr-5 ml-8 mb-6">
        <table class="w-full border-collapse border border-gray-300">
            <thead>
            <tr>
                <th class="border border-gray-300 px-4 py-2 text-right">اسم الطالب</th>
                <th class="border border-gray-300 px-4 py-2 text-right">الشركة</th>
                <th class="border border-gray-300 px-4 py-2 text-right">الفرصة التدريبية</th>
                <th class="border border-gray-300 px-4 py-2 text-right">المشرف</th>

            </tr>
            </thead>
            <tbody>
            <tr class="hover:bg-gray-50">
                <td class="border border-gray-300 px-4 py-2">محمد علي</td>
                <td class="border border-gray-300 px-4 py-2">البرمجيات المتقدمة</td>
                <td class="border border-gray-300 px-4 py-2">react js</td>
                <td class="border border-gray-300 px-4 py-2">محمد محمود</td>
            </tr>
            <tr class="hover:bg-gray-50">
                <td class="border border-gray-300 px-4 py-2">سارة محمود</td>
                <td class="border border-gray-300 px-4 py-2">أوبيرا</td>
                <td class="border border-gray-300 px-4 py-2">laravel</td>
                <td class="border border-gray-300 px-4 py-2 text-red-600">غير محدد</td>
            </tr>
            </tbody>
        </table>
    </div>

    <div id="evaluationModal" class="fixed inset-0 flex items-center justify-center bg-gray-800 bg-opacity-50 hidden">
        <div class="bg-white p-12 rounded-lg shadow-lg w-96 relative">
            <!-- زر (X) لإغلاق النافذة -->
            <button onclick="closeModal()" class="absolute top-5 left-5 text-gray-500 hover:text-gray-800 text-xl font-bold">
                ×
            </button>

            <h3 class="text-xl font-semibold mb-4 text-center">اختيار مشرف</h3>

            <!-- اختيار الطالب -->
            <label class="block text-sm font-medium text-gray-700 mb-1">اختر الطالب:</label>
            <select class="w-full px-3 py-2 border rounded mb-3">
                <option value="هلا محمد">هلا محمد</option>
                <option value="أحمد وليد">أحمد وليد</option>
            </select>

            <!-- اختيار التقييم -->
            <label class="block text-sm font-medium text-gray-700 mb-1">اختر المشرف:</label>
            <select class="w-full px-3 py-2 border rounded mb-4">
                <option value="ناجح">أحمد سمير</option>
                <option value="راسب">محمد محمود</option>
            </select>

            <!-- زر "حفظ" في المنتصف -->
            <div class="flex justify-center">
                <button class="bg-blue-500 text-white px-6 py-2 rounded hover:bg-blue-600">
                    حفظ
                </button>
            </div>
        </div>
    </div>
    <!-- JavaScript للتحكم في عرض النافذة -->
    <script>
        function openModal() {
            document.getElementById('evaluationModal').classList.remove('hidden');
        }

        function closeModal() {
            document.getElementById('evaluationModal').classList.add('hidden');
        }
    </script>

@endsection
