<?php

namespace App\Http\Controllers;

use App\Models\Application;
use App\Models\Internship;
use App\Models\Supervisor;
use App\Models\SupervisorAssignment;
use Illuminate\Http\Request;

class StudentController extends Controller
{

    public function dashboard()
    {

        $notifications = auth()->user()->student->notifications()->whereNull('read_at')->get();

        return view('student.dashboard', compact('notifications'));
    }


    public function index()
    {
        $student = auth()->user()->student;

        if (!$student) {
            return redirect()->back()->with('error', 'يجب أن تكون لديك بيانات طالب للوصول إلى هذه الصفحة.');
        }

        $acceptedApplications = Application::where('student_id', $student->id)
            ->where('status', 'مقبول')
            ->get();

        $pendingApplication = Application::where('student_id', $student->id)
            ->where('status', 'قيد المراجعة')
            ->exists();

        $rejectedApplication = Application::where('student_id', $student->id)
            ->where('status', 'مرفوض')
            ->exists();

        $internship = null;
        $statusMessage = null;
        $supervisor = null;
        $supervisormassege = null;

        if ($acceptedApplications->isNotEmpty()) {
            $approvedInternship = $acceptedApplications->firstWhere('admin_approval', 1);

            if ($approvedInternship) {
                $internship = $approvedInternship->internship;
            } elseif ($acceptedApplications->count() > 1) {
                $statusMessage = 'لديك أكثر من فرصة تدريب مقبولة من الشركات، ولكن لم يتم الموافقة عليها من الإدارة بعد. يرجى الانتظار حتى يتم تحديد التدريب المناسب لك.';
            } else {
                $statusMessage = 'تم قبولك من قبل الشركة، ولكنك في انتظار موافقة الإدارة.';
            }
        } elseif ($pendingApplication) {
            $statusMessage = 'طلبك قيد المراجعة. يرجى الانتظار حتى يتم اتخاذ القرار.';
        } elseif ($rejectedApplication) {
            $statusMessage = 'تم رفض طلبك. يمكنك التقديم على فرص أخرى.';
        } else {
            $statusMessage = 'أنت غير مقدم على طلب بعد.';
        }

        $internships = Internship::where('status', 'مفتوحة')->latest()->take(3)->get();


        $supervisorAssign = SupervisorAssignment::query()->where('student_id', '=', $student->id)->get();



        if ($supervisorAssign->isNotEmpty()) {
            $supervisor_id = $supervisorAssign->first()->supervisor_id;
            $supervisor = Supervisor::find($supervisor_id);

        }else{
            $supervisormassege = 'لم يتم تعيين مشرف بعد.';
        }


        return view('student.dashboard', compact('internship','internships','statusMessage','supervisor','supervisormassege'));
    }
    public function showApplications()
    {

        $applications = Application::query()->where('student_id','=',auth()->user()->student->id)->paginate(10);

        return view('student.myRequests',compact('applications'));
    }


}
