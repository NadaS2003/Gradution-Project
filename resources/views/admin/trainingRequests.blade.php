@extends('layouts.admin')

@section('content')
    <div class=" mt-6">
        <div class="flex justify-center items-center px-3 py-2">
            <h2 class="text-2xl font-bold  text-center">إدارة الطلبات التدريبية</h2>
        </div>
    </div>

    <div class="mt-3 mb-2 px-8 flex justify-end">
        <div class="flex items-center mb-4">
            <form action="{{ route('admin.trainingRequests') }}" method="GET" class="flex w-50">
                <input type="text" name="search" class="form-control px-2 rounded border border-gray-300 w-25 py-2 h-10" placeholder="البحث باسم الطالب" value="{{ request()->get('search') }}">
                <button class="bg-blue-600 text-white rounded border px-4 py-2 h-10 mx-2 hover:bg-blue-700" type="submit">بحث</button>
            </form>
        </div>
    </div>


    <div class="mt-5 mr-5 ml-8 mb-6">
        <table class="w-full border-collapse border border-gray-300">
            <thead>
            <tr>
                <th class="border border-gray-300 px-4 py-2 text-right">اسم الطالب</th>
                <th class="border border-gray-300 px-4 py-2 text-right">الشركة</th>
                <th class="border border-gray-300 px-4 py-2 text-right">الفرصة التدريبية</th>
                <th class="border border-gray-300 px-4 py-2 text-right">حالة الطلب عند الشركة</th>
                <th class="border border-gray-300 px-4 py-2 text-right">الإجراءات</th>
            </tr>
            </thead>
            <tbody>
            @if($trainingRequests->isEmpty())
                <tr>
                    <td colspan="8" class="border border-gray-300 px-4 py-2 text-center text-gray-500">
                        لا توجد بيانات
                    </td>
                </tr>
            @else
            @foreach($trainingRequests as $trainingRequest)
                <tr class="hover:bg-gray-50">
                    <td class="border border-gray-300 px-4 py-2">{{$trainingRequest->student->full_name}}</td>
                    <td class="border border-gray-300 px-4 py-2">{{$trainingRequest->company->company_name}}</td>
                    <td class="border border-gray-300 px-4 py-2">{{$trainingRequest->internship->title}}</td>

                    <td class="border border-gray-300 px-4 py-2 font-bold rounded
                        @if($trainingRequest->status == 'مقبول') text-green-500
                        @elseif($trainingRequest->status == 'قيد المراجعة') text-yellow-400
                        @elseif($trainingRequest->status == 'مرفوض') text-red-500
                        @endif">
                        {{$trainingRequest->status}}
                    </td>

                    <td class="border border-gray-300 px-4 py-2">
                        @if($trainingRequest->status == 'مقبول' && $trainingRequest->admin_approval == 1)
                            <span class="text-black-500 font-bold">تمت الموافقة على الطلب</span>
                        @elseif($trainingRequest->status == 'مقبول' && $trainingRequest->admin_approval == -1)
                            <span class="text-black-500 font-bold">تم رفض الطلب</span>
                        @elseif($trainingRequest->status == 'مقبول' && $trainingRequest->admin_approval == 0)
                            <div class="inline-flex space-x-2 gap-2">
                                <button onclick="updateApproval({{ $trainingRequest->id }}, 1)" class="bg-green-500 text-white px-3 py-1 rounded hover:bg-green-600">قبول</button>
                                <button onclick="updateApproval({{ $trainingRequest->id }}, -1)" class="bg-red-500 text-white px-3 py-1 rounded hover:bg-red-600">رفض</button>
                            </div>
                        @elseif($trainingRequest->status == 'قيد المراجعة')
                            <span class="text-black-500 font-bold">بانتظار موافقة الشركة</span>
                        @elseif($trainingRequest->status == 'مرفوض')
                            <span class="text-black-500 font-bold">تم رفض الطلب من قبل الشركة</span>
                        @endif
                    </td>


                </tr>
            @endforeach
            @endif
            </tbody>
        </table>
        <div class="mt-4 flex justify-end w-full">
            {{ $trainingRequests->links('vendor.pagination.simple-tailwind') }}
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        function updateApproval(requestId, approvalStatus) {
            $.ajax({
                url: "{{ route('admin.updateApproval', ':id') }}".replace(':id', requestId),
                type: "POST",
                data: {
                    _token: "{{ csrf_token() }}",
                    admin_approval: approvalStatus // إما 1 للقبول أو -1 للرفض
                },
                success: function (response) {
                    if (response.success) {
                        console.log("تم التحديث بنجاح");
                        location.reload();
                    } else {
                        alert("حدث خطأ أثناء التحديث");
                    }
                },
                error: function (xhr, status, error) {
                    console.log("AJAX Error:", error);
                }
            });
        }
    </script>


@endsection
