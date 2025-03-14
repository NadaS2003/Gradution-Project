<?php

namespace App\Exports;

use App\Models\Evaluation;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class EvaluationsExport implements FromCollection, WithHeadings, WithMapping
{
    protected $evaluations;

    public function __construct($evaluations)
    {
        $this->evaluations = $evaluations;
    }

    /**
     * جلب البيانات من قاعدة البيانات
     */
    public function collection()
    {
        return $this->evaluations;
    }

    /**
     * تحديد رؤوس الأعمدة في ملف الإكسل
     */
    public function headings(): array
    {
        return [
            'اسم الطالب',
            'التخصص',
            'التقييم النهائي',
            'تاريخ التقييم',
        ];
    }

    /**
     * تحديد القيم في كل صف
     */
    public function map($evaluation): array
    {
        return [
            $evaluation->student->full_name ?? 'غير معروف',
            $evaluation->student->major ?? 'غير معروف',
            $evaluation->final_evaluation ?? 'غير متوفر',
            $evaluation->created_at->format('Y-m-d'),
        ];
    }
}
