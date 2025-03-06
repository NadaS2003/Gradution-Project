@extends('layouts.company')
@section('title', 'الفرص التدريبية')

@section('content')
    @if ($errors->any())
        <div class="bg-red-100 border border-red-400 text-red-700 px-2 py-2 mr-4 ml-4 mt-4 rounded relative mb-6" role="alert">
            <strong class="font-bold">هناك أخطاء في الإدخال:</strong>
            <ul class="mt-2 list-disc list-inside">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    @if (session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-2 py-2 mr-4 ml-4 mt-4 rounded relative mb-6" role="alert">
            <p class="mt-2">{{ session('success') }}</p>
        </div>
    @endif

    <style>
        .table{
            width: 100%;
        }
        .table th, .table td {
            padding: 10px;
            border: 1px solid #ddd ;
            border-radius: 10px;
        }
        .table th {
            text-align: right;
        }

    </style>

    <div class="mt-6">
        <div class="flex flex-col items-center px-3 py-2">
            <h2 class="text-2xl font-bold text-center mb-2">الفرص التدريبية</h2>
            <div class=" w-full flex justify-end ml-10">
                <button onclick="openModal('evaluationModal')" class="bg-blue-600 text-white rounded border px-4 py-2 h-10 hover:bg-blue-700">
                    إضافة فرصة تدريبية
                </button>
            </div>

        </div>
    </div>



    <div class="mt-5 mr-5 ml-8 mb-6">


        <table class="table table-bordered rounded">
            <thead class="thead-light">
            <tr>
                <th class="text-left">الاسم</th>
                <th class="text-left">الوصف</th>
                <th >المدة</th>
                <th>تاريخ بداية الفرصة</th>
                <th>تاريخ نهاية الفرصة</th>
                <th>الحالة</th>
                <th>الاجراءات</th>

            </tr>
            </thead>
            <tbody>
            @foreach ($internships as $internship)
                <tr class="hover:bg-gray-50">
                    <td>{{ $internship['title'] }}</td>
                    <td>{{ $internship['description'] }}</td>
                    <td>{{ $internship['duration'] }}</td>
                    <td>{{ $internship['start_date'] }}</td>
                    <td>{{ $internship['end_date'] }}</td>
                    <td @class([
                            'text-green-500' => $internship['status'] == 'مفتوحة',
                            'text-red-500' => $internship['status'] == 'مغلقة',
                            'text-yellow-500' => $internship['status'] == 'مكتملة',
                        ])>
                        {{ $internship['status'] }}
                    </td>

                    <td>
                        <div class="inline-flex space-x-2 gap-2">
                            <button
                                onclick="openEditModal({{ json_encode($internship) }})"
                                class="bg-yellow-500 text-white px-3 py-1 rounded hover:bg-yellow-600">
                                تعديل
                            </button>
                            <form action="{{ route('company.deleteInternship', $internship->id) }}" method="POST" onsubmit="return confirmDelete(event)">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="px-3 py-1 bg-red-600 text-white rounded hover:bg-red-700">
                                    حذف
                                </button>
                            </form>

                        </div>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>


        <div class="mt-4 flex justify-end w-full">
            {{ $internships->links('vendor.pagination.simple-tailwind') }}
        </div>





    </div>


    {{--*************             Models             *****************--}}



    <!-- add Opportunity Modal -->
    <div id="evaluationModal" class="fixed inset-0 flex items-center justify-center bg-gray-800 bg-opacity-50 hidden">
        <div class="bg-white p-6 rounded-lg shadow-lg w-96 relative" style="max-height: 80vh; overflow-y: auto;"> <!-- إضافة max-height و overflow-y -->
            <button onclick="closeModal('evaluationModal')" class="absolute top-5 left-5 text-gray-500 hover:text-gray-800 text-xl font-bold">
                ×
            </button>
            <form action="{{route('company.storeInternships')}}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-content">
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="block text-sm font-medium text-black-700 mb-1">اسم الفرصة:</label>
                            <input type="text" class="w-full px-3 py-2 border rounded mb-3" name="title" required>
                        </div>
                        <div class="mb-3">
                            <label class="block text-sm font-medium text-black-700 mb-1">الوصف:</label>
                            <textarea class="w-full px-3 py-2 border rounded mb-3" name="description" required></textarea>
                        </div>
                        <div class="mb-3">
                            <label class="block text-sm font-medium text-black-700 mb-1">المدة:</label>
                            <input type="text" class="w-full px-3 py-2 border rounded mb-3" name="duration" required>
                        </div>
                        <div class="mb-3">
                            <label class="block text-sm font-medium text-black-700 mb-1">رابط نموذج تقديم الطلب</label>
                            <input type="text" class="w-full px-3 py-2 border rounded mb-3" name="internship_link" required>
                        </div>
                        <div class="mb-3">
                            <label class="block text-sm font-medium text-black-700 mb-1">صورة:</label>
                            <input type="file" class="w-full px-3 py-2 border rounded mb-3" name="image">
                        </div>
                        <div class="mb-3">
                            <label class="block text-sm font-medium text-black-700 mb-1">تاريخ بداية الفرصة:</label>
                            <input type="date" class="w-full px-3 py-2 border rounded mb-3" name="start_date" required>
                        </div>
                        <div class="mb-3">
                            <label class="block text-sm font-medium text-black-700 mb-1">تاريخ نهاية الفرصة:</label>
                            <input type="date" class="w-full px-3 py-2 border rounded mb-3" name="end_date" required>
                        </div>
                        <div class="flex justify-end">
                            <button type="submit" class="bg-blue-500 text-white px-6 py-2 rounded hover:bg-blue-600">إضافة</button>
                        </div>


                    </div>
                </div>
            </form>
        </div>
    </div>
    <div id="editModal" class="fixed inset-0 flex items-center justify-center bg-gray-800 bg-opacity-50 hidden">
        <div class="bg-white p-6 rounded-lg shadow-lg w-96 relative" style="max-height: 80vh; overflow-y: auto;">
            <button onclick="closeEditModal()" class="absolute top-5 left-5 text-gray-500 hover:text-gray-800 text-xl font-bold">×</button>

            <form id="editForm" action=""  method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <input type="hidden" id="editInternshipId" name="internship_id">

                <div class="mb-3">
                    <label class="block text-sm font-medium text-black-700 mb-1">اسم الفرصة:</label>
                    <input type="text" class="w-full px-3 py-2 border rounded mb-3" name="title" id="editTitle" required>
                </div>
                <div class="mb-3">
                    <label class="block text-sm font-medium text-black-700 mb-1">الوصف:</label>
                    <textarea class="w-full px-3 py-2 border rounded mb-3" name="description" id="editDescription" required></textarea>
                </div>
                <div class="mb-3">
                    <label class="block text-sm font-medium text-black-700 mb-1">المدة:</label>
                    <input type="text" class="w-full px-3 py-2 border rounded mb-3" name="duration" id="editDuration" required>
                </div>
                <div class="mb-3">
                    <label class="block text-sm font-medium text-black-700 mb-1">حالة الفرصة:</label>
                    <select class="w-full px-3 py-2 border rounded mb-3" name="status" id="editStatus" required>
                        <option value="مفتوحة">مفتوحة</option>
                        <option value="مغلقة">مغلقة</option>
                        <option value="مكتملة">مكتملة</option>
                    </select>
                </div>

                <div class="mb-3">
                    <label class="block text-sm font-medium text-black-700 mb-1">الصورة الحالية:</label>
                    <img id="editPreviewImage" class="w-32 h-32 object-cover rounded border mb-3" src="" alt="صورة الفرصة">
                </div>
                <div class="mb-3">
                    <label class="block text-sm font-medium text-black-700 mb-1">تحديث الصورة:</label>
                    <input type="file" class="w-full px-3 py-2 border rounded mb-3" name="image">
                </div>
                <div class="mb-3">
                    <label class="block text-sm font-medium text-black-700 mb-1">رابط نموذج تقديم الطلب:</label>
                    <input type="text" class="w-full px-3 py-2 border rounded mb-3" name="internship_link" id="editInternshipLink" required>
                </div>
                <div class="mb-3">
                    <label class="block text-sm font-medium text-black-700 mb-1">تاريخ بداية الفرصة:</label>
                    <input type="date" class="w-full px-3 py-2 border rounded mb-3" name="start_date" id="editStartDate" required>
                </div>
                <div class="mb-3">
                    <label class="block text-sm font-medium text-black-700 mb-1">تاريخ نهاية الفرصة:</label>
                    <input type="date" class="w-full px-3 py-2 border rounded mb-3" name="end_date" id="editEndDate" required>
                </div>

                <div class="flex justify-end">
                    <button type="submit" class="bg-blue-500 text-white px-6 py-2 rounded hover:bg-blue-600">تحديث</button>
                </div>
            </form>
        </div>
    </div>


   <script>
       function openModal(modalId) {
           document.getElementById(modalId).classList.remove('hidden');
       }

       function closeModal(modalId) {
           document.getElementById(modalId).classList.add('hidden');
       }

       function openEditModal(internship) {
           const form = document.getElementById('editForm');
           if (form) {
               form.action = `/companyUpdateInternships/${internship.id}`;
           }

           const fields = {
               editInternshipId: internship.id,
               editTitle: internship.title,
               editDescription: internship.description,
               editDuration: internship.duration,
               editStatus: internship.status,
               editInternshipLink: internship.internship_link,
               editStartDate: internship.start_date,
               editEndDate: internship.end_date
           };

           Object.keys(fields).forEach(id => {
               const element = document.getElementById(id);
               if (element) {
                   element.value = fields[id];
               }
           });

           const imageElement = document.getElementById('editPreviewImage');
           if (imageElement) {
               imageElement.src = internship.image ? `/storage/internships/${internship.image}` : '';
           }

           const modal = document.getElementById('editModal');
           if (modal) {
               modal.classList.remove('hidden');
           }
       }

       function closeEditModal() {
           document.getElementById('editModal').classList.add('hidden');
       }

       function confirmDelete(event) {
           if (!confirm("هل أنت متأكد من أنك تريد حذف هذه الفرصة؟")) {
               event.preventDefault();
           }
       }
   </script>
@endsection
