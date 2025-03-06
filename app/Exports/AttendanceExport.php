<?php
namespace App\Exports;

use App\Models\Attendance;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class AttendanceExport implements FromCollection, WithHeadings, WithMapping
{
    protected $company_id;
    protected $dates;

    public function __construct($company_id)
    {
        $this->company_id = $company_id;

        $this->dates = Attendance::where('company_id', $this->company_id)
            ->orderBy('date', 'asc')
            ->pluck('date')
            ->unique();
    }

    public function collection()
    {
        return Attendance::where('company_id', $this->company_id)
            ->with('student')
            ->get()
            ->groupBy('student_id')
            ->map(function ($attendances) {
                return [
                    'student' => $attendances->first()->student,
                    'attendances' => $attendances,
                ];
            })
            ->values();
    }

    public function headings(): array
    {
        return array_merge(
            ['اسم الطالب'],
            $this->dates->toArray(),
            ['عدد أيام الحضور', 'عدد أيام الغياب']
        );
    }

    public function map($row): array
    {
        $student = $row['student'];
        $attendances = $row['attendances'];

        $data = [$student->full_name];
        $presentDays = 0;
        $absentDays = 0;

        foreach ($this->dates as $date) {
            $attendance = $attendances->firstWhere('date', $date);
            $status = $attendance ? $attendance->status : '';

            if ($status === 'حاضر') {
                $presentDays++;
            } elseif ($status === 'غائب') {
                $absentDays++;
            }

            $data[] = $status;
        }

        $data[] = $presentDays;
        $data[] = $absentDays;

        return $data;
    }
}
