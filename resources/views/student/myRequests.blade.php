@extends('layouts.student')
@section('title', 'طلباتي')
@section('content')
    <style>
        .table{
            width: 100%;
        }
        .table th, .table td {
            padding: 10px;
            border: 1px solid #ddd ; /* حدود الجدول */
            border-radius: 10px;
        }
        .table th {
            text-align: right; /* محاذاة النص إلى اليسار */
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
        <table class="table table-bordered rounded">
            <thead class="thead-light">
            <tr>
                <th class="text-left">الفرص التدريبية</th>
                <th class="text-left">الشركة</th>
                <th class="text-left">حالة الطلب</th>
                <th class="text-left">تاريخ الطلب</th>
            </tr>
            </thead>
            <tbody>
            <tr>
                <td>فرصة تدريبية 1</td>
                <td>شركة الفضاء</td>
                <td><span class="badge bg-success">مقبول</span></td>
                <td>2025-01-15</td>
            </tr>
            <tr>
                <td>فرصة تدريبية 2</td>
                <td>شركة التكنولوجيا</td>
                <td><span class="badge bg-danger">مرفوض</span></td>
                <td>2025-01-20</td>
            </tr>
            <tr>
                <td>فرصة تدريبية 3</td>
                <td>شركة البرمجيات</td>
                <td><span class="badge bg-warning">قيد المراجعة</span></td>
                <td>2025-01-25</td>
            </tr>
            </tbody>
        </table>
    </div>
@endsection


