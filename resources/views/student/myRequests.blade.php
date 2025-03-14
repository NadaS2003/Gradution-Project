@extends('layouts.student')
@section('title', 'طلباتي')
@section('content')
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
        .badge {
            padding: 5px 10px;
            border-radius: 10px;
            color: white;
        }
        .bg-success {
            background-color: #28a745;
        }
        .bg-danger {
            background-color: #dc3545;
        }
        .bg-warning {
            background-color: #ffc107;
        }
    </style>
    <div class=" mt-6">
        <div class="flex justify-center items-center px-3 py-2">
            <h2 class="text-2xl font-bold text-center mb-6">متابعة حالة الطلبات</h2>
        </div>
    </div>

    <div class="mt-5 mr-5 ml-8 mb-6">
        @if($applications->isEmpty())
        <div class="text-center text-gray-500">
            <p>لا توجد بيانات لعرضها</p>
        </div>
        @else
            <table class="table table-bordered rounded">
                <thead class="thead-light">
                <tr>
                    <th class="text-left">الفرصة التدريبية</th>
                    <th class="text-left">الشركة</th>
                    <th class="text-left">حالة الطلب من الشركة</th>
                    <th class="text-left">تاريخ الطلب</th>
                    <th class="text-left">ملاحظة</th>
                </tr>
                </thead>
                <tbody>
                @foreach ($applications as $application)
                    <tr class="border-b hover:bg-gray-50">
                        <td class="px-4 py-2">{{ $application->internship->title ?? 'لا توجد بيانات' }}</td>
                        <td class="px-4 py-2">{{ $application->company->company_name ?? 'شركة غير معروفة' }}</td>
                        <td>
                            @if ($application->status == 'مقبول')
                                <span class="badge bg-success">مقبول</span>
                            @elseif ($application->status == 'مرفوض')
                                <span class="badge bg-danger">مرفوض</span>
                            @else
                                <span class="badge bg-warning">قيد المراجعة</span>
                            @endif
                        </td>
                        <td class="px-4 py-2">{{ $application->created_at ?? 'لا توجد بيانات' }}</td>
                        <td class="px-4 py-2">
                            @if($application->status == 'مقبول')
                                @if($application->admin_approval)
                                    <span class="text-green-500">تمت الموافقة من قبل الإدارة</span>
                                @else
                                    <span class="text-red-500">في انتظار موافقة الإدارة</span>
                                @endif
                            @else
                                <span class="text-gray-500">لا توجد ملاحظات</span>
                            @endif
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
            <div class="mt-4 flex justify-end w-full">

                {{ $applications->links('vendor.pagination.simple-tailwind') }}

            </div>
        @endif
    </div>
@endsection
