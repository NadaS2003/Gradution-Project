<?php
namespace App\Exports;

use App\Models\Evaluation;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class StudentsEvaluationsExport implements FromCollection, WithHeadings
{
    protected $supervisorId;

    public function __construct($supervisorId)
    {
        $this->supervisorId = $supervisorId;
    }

    public function headings(): array
    {
        return ["اسم الطالب", "التقييم النهائي"];
    }

    public function collection()
    {
        $evaluations = Evaluation::whereHas('student', function ($query) {
            $query->where('supervisor_id', $this->supervisorId);
        })
            ->whereHas('student.applications', function ($query) {
                $query->where('status', 'مقبول')
                    ->where('admin_approval', 1);
            })
            ->with('student')
            ->get();

        return $evaluations->map(function ($evaluation) {
            return [
                'student_name' => $evaluation->student->full_name,
                'final_evaluation' => $evaluation->final_evaluation,
            ];
        });
    }
}
