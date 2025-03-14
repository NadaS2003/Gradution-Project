@extends('layouts.supervisor')

@section('content')
    @if (session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-2 py-2 mr-4 ml-4 mt-4 rounded relative mb-6" role="alert">
            <p class="mt-2">{{ session('success') }}</p>
        </div>
    @endif

    <div class="mt-6 px-6 flex flex-col w-full">
        <h2 class="text-2xl font-bold text-center mb-2">التقييمات</h2>
        <div class="flex justify-end gap-3">
            <button onclick="openModal()" class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700">
                التقييم النهائي
            </button>
            <button onclick="window.location='{{ route('supervisor.export.evaluations') }}'" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                تصدير تقييمات الطلاب إلى Excel
            </button>
        </div>
    </div>

    <div class="mt-5 mr-20 ml-8 mb-6">
        @if($students->isEmpty())
            <div class="text-center text-gray-500 text-lg mt-4">
                لا يوجد طلاب  حاليًا.
            </div>
        @else
            <table class="border-collapse border border-gray-300 mr-20" style="width: 900px">
                <thead>
                <tr>
                    <th class="border border-gray-300 px-4 py-2 text-right">الاسم</th>
                    <th class="border border-gray-300 px-4 py-2 text-right">التقييم النهائي</th>
                </tr>
                </thead>
                <tbody>
                @foreach($students as $student)
                    <tr class="hover:bg-gray-50">
                        <td class="border border-gray-300 px-4 py-2">{{ $student->full_name }}</td>
                        <td class="border border-gray-300 px-4 py-2">
            <span class="text-white py-1 rounded
                @if($student->evaluations->isNotEmpty() && $student->evaluations->first()->final_evaluation == 'pass') bg-green-700
                @elseif($student->evaluations->isNotEmpty() && $student->evaluations->first()->final_evaluation == 'fail') bg-red-500
                @else bg-gray-500 @endif
                w-20 text-center inline-block">
                @if($student->evaluations->isNotEmpty() && $student->evaluations->first()->final_evaluation)
                    @if($student->evaluations->first()->final_evaluation == 'pass')
                        ناجح
                    @elseif($student->evaluations->first()->final_evaluation == 'fail')
                        راسب
                    @else
                        لم يتم التقييم
                    @endif
                @else
                    لم يتم التقييم
                @endif
            </span>
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

    <div id="evaluationModal" class="fixed inset-0 flex items-center justify-center bg-gray-800 bg-opacity-50 hidden">
        <div class="bg-white p-12 rounded-lg shadow-lg w-96 relative">
            <button onclick="closeModal()" class="absolute top-5 left-5 text-gray-500 hover:text-gray-800 text-xl font-bold">
                ×
            </button>

            <h3 class="text-xl font-semibold mb-4 text-center">إضافة تقييم</h3>

            <form action="{{ route('supervisor.rates.store') }}" method="POST">
                @csrf
                <label class="block text-sm font-medium text-gray-700 mb-1">اختر الطالب:</label>
                <select name="student_id" class="w-full px-3 py-2 border rounded mb-3">
                    @foreach($students as $student)
                        <option value="{{ $student->id }}">{{ $student->full_name }}</option>
                    @endforeach
                </select>

                <label class="block text-sm font-medium text-gray-700 mb-1">اختر التقييم:</label>
                <select name="final_evaluation" class="w-full px-3 py-2 border rounded mb-4">
                    <option value="pass">ناجح</option>
                    <option value="fail">راسب</option>
                </select>

                <div class="flex justify-center">
                    <button class="bg-blue-600 text-white px-6 py-2 rounded hover:bg-blue-700">
                        حفظ
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function openModal() {
            document.getElementById('evaluationModal').classList.remove('hidden');
        }

        function closeModal() {
            document.getElementById('evaluationModal').classList.add('hidden');
        }
    </script>
@endsection
