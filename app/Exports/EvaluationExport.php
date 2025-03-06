<?php
namespace App\Exports;

use App\Models\Student;
use App\Models\WeeklyEvaluation;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Auth;

class EvaluationExport implements FromCollection, WithHeadings, WithMapping
{
    protected $evaluations;

    public function __construct($evaluations)
    {
        $this->evaluations = $evaluations;
    }

    public function headings(): array
    {
        $weekNames = $this->evaluations->pluck('week_name')->unique();
        $headings = ['اسم الطالب'];

        foreach ($weekNames as $weekName) {
            $headings[] = $weekName;
        }

        return $headings;
    }

    public function collection()
    {
        return Student::whereHas('weeklyEvaluations', function ($query) {
            $query->where('company_id', Auth::user()->company->id);
        })->get();
    }

    public function map($student): array
    {
        $data =[$student->full_name];

        $weekNames = $this->evaluations->pluck('week_name')->unique();

        foreach ($weekNames as $weekName) {
            $evaluation = $student->weeklyEvaluations->firstWhere('week_name', $weekName);
            $data[] = $evaluation ? $evaluation->evaluation : '';
        }

        return $data;
    }

    public function exportToExcel()
    {
        $companyId = Auth::user()->company->id;

        $evaluations = WeeklyEvaluation::where('company_id', $companyId)->get();

        return Excel::download(new EvaluationExport($evaluations), 'weekly_evaluations.xlsx');
    }
}
