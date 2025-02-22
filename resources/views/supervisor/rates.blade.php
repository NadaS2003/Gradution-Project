@extends('layouts.supervisor')

@section('content')
    <div class="mt-6 px-6 flex flex-col w-full">
        <h2 class="text-2xl font-bold text-center mb-2">التقييمات</h2>
        <div class="flex justify-end gap-3">

        <button onclick="openModal()" class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700">
                التقييم النهائي
            </button>
            <button class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                تصدير ملف إكسيل
            </button>
        </div>
    </div>

    <div class="mt-5 mr-20 ml-8 mb-6">
        <table class="border-collapse border border-gray-300 mr-20" style="width: 900px">
            <thead>
            <tr>
                <th class="border border-gray-300 px-4 py-2 text-right">الاسم</th>
                <th class="border border-gray-300 px-4 py-2 text-right">التقييم النهائي</th>
            </tr>
            </thead>
            <tbody>
            <tr class="hover:bg-gray-50">
                <td class="border border-gray-300 px-4 py-2">هلا محمد</td>
                <td class="border border-gray-300 px-4 py-2">
                    <span class="text-white  py-1 rounded bg-green-700 w-10 text-center inline-block">ناجح</span>
                </td>
            </tr>
            <tr class="hover:bg-gray-50">
                <td class="border border-gray-300 px-4 py-2">أحمد وليد</td>
                <td class="border border-gray-300 px-4 py-2">
                    <span class="text-white py-1 rounded bg-red-500 w-10 text-center inline-block">راسب</span>
                </td>
            </tr>
            </tbody>
        </table>
    </div>

    <!-- نافذة منبثقة (Modal) -->
    <div id="evaluationModal" class="fixed inset-0 flex items-center justify-center bg-gray-800 bg-opacity-50 hidden">
        <div class="bg-white p-12 rounded-lg shadow-lg w-96 relative">
            <!-- زر (X) لإغلاق النافذة -->
            <button onclick="closeModal()" class="absolute top-5 left-5 text-gray-500 hover:text-gray-800 text-xl font-bold">
                ×
            </button>

            <h3 class="text-xl font-semibold mb-4 text-center">إضافة تقييم</h3>

            <!-- اختيار الطالب -->
            <label class="block text-sm font-medium text-gray-700 mb-1">اختر الطالب:</label>
            <select class="w-full px-3 py-2 border rounded mb-3">
                <option value="هلا محمد">هلا محمد</option>
                <option value="أحمد وليد">أحمد وليد</option>
            </select>

            <!-- اختيار التقييم -->
            <label class="block text-sm font-medium text-gray-700 mb-1">اختر التقييم:</label>
            <select class="w-full px-3 py-2 border rounded mb-4">
                <option value="ناجح">ناجح</option>
                <option value="راسب">راسب</option>
            </select>

            <!-- زر "حفظ" في المنتصف -->
            <div class="flex justify-center">
                <button class="bg-blue-600 text-white px-6 py-2 rounded hover:bg-blue-700">
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

