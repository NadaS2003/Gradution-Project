<?php

namespace App\Http\Controllers;

use App\Exports\EvaluationExport;
use App\Models\Evaluation;
use App\Models\WeeklyEvaluation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Facades\Excel;

class WeeklyEvaluationController extends Controller
{

    public function create()
    {
        return view('weekly_evaluations.create');
    }
    public function store(Request $request)
    {

        $request->validate([
            'student_id' => 'required|exists:students,id',
            'week_name' => 'nullable|string',
            'new_week_name' => 'nullable|string',
            'evaluation' => 'required|numeric|min:0|max:100'
        ]);

        $company_id = Auth::user()->company->id;

        if ($request->week_name === "new") {
            $week_name = $request->new_week_name;
        } else {
            $week_name = $request->week_name;
        }

        if (!$week_name || trim($week_name) === '') {
            return back()->with('error', 'يجب اختيار أسبوع من القائمة أو إدخال اسم أسبوع جديد.');
        }

        WeeklyEvaluation::updateOrCreate(
            [
                'student_id' => $request->student_id,
                'week_name' => $week_name
            ],
            [
                'company_id' => $company_id,
                'evaluation' => $request->evaluation
            ]
        );

        return back()->with('success', 'تم حفظ التقييم بنجاح.');
    }

    public function update(Request $request, $id)
    {

        $evaluation = WeeklyEvaluation::find($id);
        if (!$evaluation) {
            return redirect()->back()->with('error', 'التقييم غير موجود');
        }

        $evaluation->student_id = $request->student_id;
        $evaluation->week_name = $request->week_name;
        $evaluation->evaluation = $request->evaluation;

        $evaluation->save();

        return back()->with('success', 'تم تعديل التقييم بنجاح');
    }

    public function exportToExcel()
    {
        $companyId = Auth::user()->company->id;

        $evaluations = WeeklyEvaluation::where('company_id', $companyId)->get();

        return Excel::download(new EvaluationExport($evaluations), 'weekly_evaluations.xlsx');
    }



}
