<?php

namespace App\Http\Controllers;

use App\Exports\StudentsEvaluationsExport;
use App\Models\Attendance;
use App\Models\Company;
use App\Models\Evaluation;
use App\Models\Student;
use App\Models\WeeklyEvaluation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class SupervisorController extends Controller
{
    public function dashboard()
    {

        $notifications = auth()->user()->supervisor->notifications()->whereNull('read_at')->get();

        return view('supervisor.dashboard', compact('notifications'));
    }
    public function index()
    {
        $supervisor_id = Auth::user()->supervisor->id;
        $studentsCount = Student::query()->where('supervisor_id',$supervisor_id)->get()->count();
        $studentsStartedCount = Student::query()->where('supervisor_id',$supervisor_id)
                                                ->where('training_status','started')->get()->count();
        $weeksCount = Student::where('supervisor_id', $supervisor_id)
            ->whereHas('weeklyEvaluations')
            ->with('weeklyEvaluations')
            ->get()
            ->pluck('weeklyEvaluations')
            ->flatten()
            ->pluck('week_name')
            ->unique()
            ->count();

        $trainingBooks = Student::where('supervisor_id', $supervisor_id)
            ->whereHas('evaluations')
            ->with('evaluations')
            ->get()
            ->pluck('evaluations')
            ->flatten()
            ->pluck('evaluation_letter')
            ->unique()
            ->count();

        $completedCount = Student::where('supervisor_id', $supervisor_id)
            ->where('training_status', 'completed')
            ->count();

        $startedCount = Student::where('supervisor_id', $supervisor_id)
            ->where('training_status', 'started')
            ->count();

        $notStartedCount = Student::where('supervisor_id', $supervisor_id)
            ->where('training_status', 'Not started')
            ->count();

        $weeklyEvaluations = Student::where('supervisor_id', $supervisor_id)
            ->whereHas('weeklyEvaluations')
            ->with('weeklyEvaluations')
            ->get()
            ->flatMap(function($student) {
                return $student->weeklyEvaluations->map(function($evaluation) {
                    return [
                        'week' => $evaluation->week_name,
                        'evaluation' => $evaluation->evaluation,
                    ];
                });
            });

        $weekGroups = $weeklyEvaluations->groupBy('week');

        $averageScores = [];
        foreach ($weekGroups as $week => $evaluations) {
            $averageScores[$week] = $evaluations->avg('evaluation');
        }

        $weeks = array_keys($averageScores);
        $average = array_values($averageScores);


        return view('supervisor.dashboard',compact('studentsCount','studentsStartedCount' ,'weeksCount'
            ,'trainingBooks','completedCount','startedCount','notStartedCount','weeklyEvaluations','averageScores','weeks','average'));
    }

    public function studentsList(){
        $supervisor_id = Auth::user()->supervisor->id;
        $students = Student::where('supervisor_id', $supervisor_id)
            ->whereHas('applications', function ($query) {
                $query->where('status', 'مقبول')
                    ->where('admin_approval', 1);
            })
            ->with(['applications.company'])
            ->paginate(10);

        return view('supervisor.studentsList',compact('students'));
    }

    public function studentDetails($id)
    {
        $student = Student::with(['applications.company'])->findOrFail($id);
        $studentAttendance = Attendance::where('student_id', $id)->get();

        $attendanceCount = $studentAttendance->count();
        $presentCount = $studentAttendance->where('status', 'حاضر')->count();
        $absentCount = $attendanceCount - $presentCount;

        $weeklyEvaluations = WeeklyEvaluation::where('student_id', $id)->get();

        return view('supervisor.studentDetails', compact('student', 'studentAttendance', 'weeklyEvaluations', 'presentCount', 'absentCount'));
    }


    public function companiesList()
    {
        $supervisor_id = Auth::user()->supervisor->id;

        $students = Student::where('supervisor_id', $supervisor_id)
            ->with(['applications.company'])
            ->get();

        $companies = Company::join('applications', 'companies.id', '=', 'applications.company_id')
            ->join('students', 'applications.student_id', '=', 'students.id')
            ->where('students.supervisor_id', $supervisor_id)
            ->select('companies.*')
            ->distinct()
            ->get();

        $companyStudents = $companies->mapWithKeys(function ($company) use ($students) {
            $studentsInCompany = $students->filter(function ($student) use ($company) {
                return $student->applications->where('company_id', $company->id)->isNotEmpty();
            });

            $studentsWithStatus = $studentsInCompany->map(function ($student) use ($company) {
                $application = $student->applications->firstWhere('company_id', $company->id);
                return [
                    'student' => $student,
                    'status' => $application ? $application->status : 'لم يتم التقديم'
                ];
            });

            return [$company->id => $studentsWithStatus];
        });

        return view('supervisor.companiesList', compact('companies', 'companyStudents'));
    }


    public function showEvaluation()
    {
        $supervisor_id = Auth::user()->supervisor->id;

        $students = Student::where('supervisor_id', $supervisor_id)
            ->with('evaluations')
            ->paginate(10);
     //   $students = collect([]);
        return view('supervisor.rates', compact('students'));
    }

    public function storeEvaluation(Request $request)
    {
        $request->validate([
            'student_id' => 'required|exists:students,id',
            'final_evaluation' => 'required|in:pass,fail',
        ]);

        $student = Student::findOrFail($request->student_id);

        $application = $student->applications()->where('status', 'مقبول')->first();

        if (!$application) {
            return back()->with('error', 'لا يوجد طلب مقبول لهذا الطالب لتحديد الشركة.');
        }

        $evaluation = Evaluation::where('student_id', $request->student_id)->first();

        if ($evaluation) {
            $evaluation->final_evaluation = $request->final_evaluation;
            $evaluation->save();
        } else {
            $evaluation = Evaluation::create([
                'student_id' => $request->student_id,
                'company_id' => $application->company_id,
                'evaluation_letter'=> Null,
                'final_evaluation' => $request->final_evaluation,
            ]);
        }

        $student->training_status = 'completed';
        $student->save();

        return back()->with('success', 'تم حفظ التقييم النهائي بنجاح، وتم تحديث حالة التدريب إلى مكتمل.');
    }




    public function exportEvaluations()
    {
        return Excel::download(new StudentsEvaluationsExport(auth()->user()->supervisor->id), 'evaluations.xlsx');
    }

}
