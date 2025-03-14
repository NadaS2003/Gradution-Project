<?php

namespace App\Exports;

use App\Models\Attendance;
use App\Models\Student;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class AttendancesExport implements FromCollection,WithHeadings
{
    /**
     * جمع البيانات التي سيتم تصديرها
     *
     * @return \Illuminate\Support\Collection
     */

    public function collection()
    {
        // جلب جميع الطلاب مع شركاتهم
        $students = Student::with('applications.company')->get();

        // جلب بيانات الحضور مع الطلاب
        $attendances = Attendance::with('student', 'company')->get();

        // تجميع الحضور حسب الطالب
        $attendancesGrouped = $attendances->groupBy('student_id');

        // إضافة بيانات الحضور والغياب لكل طالب
        $attendanceData = [];
        foreach ($students as $student) {
            // الحصول على مجموعة الحضور الخاصة بالطالب
            $attendanceGroup = $attendancesGrouped->get($student->id, collect());

            // حساب عدد أيام الحضور والغياب
            $presentDays = $attendanceGroup->where('status', 'حاضر')->count();
            $absentDays = $attendanceGroup->where('status', 'غائب')->count();

            $acceptedApplication = $student->applications->firstWhere(function ($application) {
                return $application->status == 'مقبول' && $application->admin_approval == 1;
            });

            $attendanceData[] = [
                'اسم الطالب' => $student->full_name ?? 'غير موجود',
                'اسم الشركة' => optional($acceptedApplication)->company->company_name ?? 'غير موجود',
                'عدد أيام الحضور' => $presentDays,
                'عدد أيام الغياب' => $absentDays,
                'message' => $attendanceGroup->isEmpty() ? 'لا يوجد سجل حضور أو غياب' : null
            ];

        }

        return collect($attendanceData); // إرجاع البيانات كـ Collection
    }



    /**
     * رؤوس الأعمدة
     *
     * @return array
     */
    public function headings(): array
    {
        return [
            'اسم الطالب',
            'اسم الشركة',
            'عدد أيام الحضور',
            'عدد أيام الغياب',
            'الرسالة'
        ];
    }
}
