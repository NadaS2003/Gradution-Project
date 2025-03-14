<?php

namespace App\Http\Controllers;

use App\Exports\AttendancesExport;
use App\Exports\EvaluationsExport;
use App\Models\Application;
use App\Models\Attendance;
use App\Models\Company;
use App\Models\Evaluation;
use App\Models\Internship;
use App\Models\Student;
use App\Models\Supervisor;
use App\Models\SupervisorAssignment;
use App\Notifications\AdminApprovalNotification;
use App\Notifications\StudentAssignedToSupervisor;
use App\Notifications\StudentChangedSupervisor;
use App\Notifications\SupervisorAssignedToStudent;
use App\Notifications\SupervisorChanged;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Facades\Excel;


class AdminController extends Controller
{
    public function index()
    {
        $studentsCount = Student::count();
        $opportunitiesCount = Internship::count();
        $supervisorsCount = Supervisor::count();
        $companiesCount = Company::count();


        $startTime = microtime(true);

        $memoryUsage = memory_get_usage(true);
        $memoryUsageMb = round($memoryUsage / 1024 / 1024, 2);

        try {
            DB::connection()->getPdo();
            $dbStatus = 'اتصال ناجح بقاعدة البيانات';
        } catch (\Exception $e) {
            $dbStatus = 'فشل في الاتصال بقاعدة البيانات';
        }

        $visitCount = Cache::get('visit_count', 0);
        Cache::put('visit_count', $visitCount + 1, now()->addMinutes(60));

        $responseTime = microtime(true) - $startTime;



        $diskTotal = disk_total_space("/");
        $diskFree = disk_free_space("/");
        $diskUsedPercentage = round((($diskTotal - $diskFree) / $diskTotal) * 100, 2);

        return view('admin.dashboard', compact('studentsCount','diskUsedPercentage','opportunitiesCount', 'supervisorsCount', 'companiesCount','responseTime', 'memoryUsageMb', 'dbStatus', 'visitCount'));

    }

    public function assignSupervisorToStudent(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'student_id' => 'required|exists:students,id',
            'supervisor_id' => 'required|exists:supervisors,id',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $admin_id = Auth::user()->id;

        $student = Student::findOrFail($request->student_id);
        $supervisor = Supervisor::findOrFail($request->supervisor_id);

        $oldSupervisorId = $student->supervisor_id;

        SupervisorAssignment::updateOrCreate(
            ['student_id' => $student->id],
            [
                'supervisor_id' => $supervisor->id,
                'assigned_by' => $admin_id,
            ]
        );

        $student->update(['supervisor_id' => $supervisor->id]);

        Evaluation::updateOrCreate(
            ['student_id' => $student->id],
            [
                'supervisor_id' => $supervisor->id,
            ]
        );

        $student->notify(new SupervisorAssignedToStudent($supervisor->full_name));
        $supervisor->notify(new StudentAssignedToSupervisor($student->full_name));

        if ($oldSupervisorId && $oldSupervisorId != $supervisor->id) {
            $oldSupervisor = Supervisor::find($oldSupervisorId);
            if ($oldSupervisor) {

                $student->notify(new SupervisorChanged($oldSupervisor->full_name));

                $oldSupervisor->notify(new StudentChangedSupervisor($student->full_name));
                dd('Notification sent to old supervisor');
            }
        }

        return redirect()->back()->with('success', 'تم تعيين المشرف للطالب بنجاح.');
    }


    public function showStudent(Request $request)
    {
        $query = Student::query();

        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('full_name', 'like', '%' . $request->search . '%')
                    ->orWhere('university_id', 'like', '%' . $request->search . '%');
            });
        }

        if ($request->filled('major')) {
            $query->where('major', $request->major);
        }

        $students =$query->paginate(10);
//
        $majors = Student::distinct()->pluck('major');

        return view('admin.studentsManagement', compact('students', 'majors'));
    }

    public function showCompanies(Request $request)
    {
        $companies = Company::query();

        if ($request->filled('search')) {
            $companies->where('company_name', 'like', '%' . $request->search . '%');
        }

        $companies = $companies->paginate(10);

        return view('admin.companiesManagement', compact('companies'));
    }


    public function showSupervisors(Request $request)
    {
        $supervisors = Supervisor::query();

        if ($request->filled('search')) {
            $supervisors->where('full_name', 'like', '%' . $request->search . '%');
        }

        $supervisors = $supervisors->paginate(10);

        return view('admin.supervisorsManagement', compact('supervisors'));
    }


    public function showOpportunities(Request $request)
    {
        $query = Internship::query();

        if ($request->filled('search')) {
            $query->where('title', 'like', '%' . $request->search . '%');
        }

        if ($request->filled('duration')) {
            $query->where('duration', $request->duration);
        }

        if ($request->filled('company')) {
            $query->where('company_id', $request->company);
        }

        $opportunities = $query->paginate(10);

        $companies = Company::all();
        $durations = Internship::distinct()->pluck('duration');

        return view('admin.opportunitiesManagement', compact('opportunities', 'companies', 'durations'));
    }


    public function destroyStudent($id)
    {
        $student = Student::findOrFail($id);
        if ($student->user) {
            $student->user->delete();
        }

        $student->delete();

        return redirect()->back()->with('success', 'تم حذف الطالب بنجاح');
    }

    public function destroyCompany($id)
    {
        $company = Company::findOrFail($id);

        if ($company->user) {
            $company->user->delete();
        }
        $company->delete();

        return redirect()->back()->with('success', 'تم حذف الطالب بنجاح');
    }

    public function destroySupervisor($id)
    {
        $supervisor = Supervisor::findOrFail($id);

        if ($supervisor->user) {
            $supervisor->user->delete();
        }

        $supervisor->delete();

        return redirect()->back()->with('success', 'تم حذف المشرف والمستخدم بنجاح');
    }




    public function showAttendance(Request $request)
    {
        $search = $request->input('search');

        $query = Student::with(['applications.company', 'attendances'])
            ->whereHas('applications', function ($q) {
                $q->where('status', 'مقبول')
                    ->where('admin_approval', 1);
            });

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('full_name', 'like', "%$search%")
                    ->orWhereHas('applications.company', function ($q) use ($search) {
                        $q->where('company_name', 'like', "%$search%");
                    });
            });
        }

        $students = $query->paginate(10);

        $attendances = Attendance::whereIn('student_id', $students->pluck('id')->toArray())
            ->get()
            ->groupBy('student_id');

        $attendanceData = $students->map(function ($student) use ($attendances) {
            $attendanceGroup = $attendances->get($student->id, collect());

            return [
                'student' => $student,
                'company' => optional($student->applications->first())->company,
                'present_days' => $attendanceGroup->where('status', 'حاضر')->count(),
                'absent_days' => $attendanceGroup->where('status', 'غائب')->count(),
                'message' => $attendanceGroup->isEmpty() ? 'لا يوجد سجل حضور أو غياب' : null
            ];
        });

        $attendanceDataPaginator = new LengthAwarePaginator(
            $attendanceData,
            $students->total(),
            $students->perPage(),
            $students->currentPage(),
            ['path' => url()->current()]
        );

        return view('admin.audienceManagement', compact('attendanceDataPaginator', 'students'));
    }




    public function exportAttendance()
    {
        $attendances = Attendance::with(['student', 'company'])->get();

        return Excel::download(new AttendancesExport($attendances), 'attendance.xlsx');
    }

    public function showStudentsRates(Request $request)
    {
        $query = Student::with(['applications.company', 'evaluations'])
        ->whereHas('applications', function ($q) {
            $q->where('status', 'مقبول')
            ->where('admin_approval', 1);
        });

        if ($request->filled('search')) {
            $query->where('full_name', 'like', '%' . $request->search . '%');
        }

        if ($request->filled('major')) {
            $query->where('major', $request->major);
        }

        $students = $query->paginate(10);

        $majors = Student::distinct()->pluck('major');

        return view('admin.studentsRate', compact('majors', 'students'));
    }



    public function exportRates()
    {
        $evaluations = Evaluation::with(['student'])->get();

        return Excel::download(new EvaluationsExport($evaluations), 'evaluations.xlsx');
    }

    public function showTrainingBooks(Request $request)
    {
        $query = Student::with(['applications.company', 'evaluations'])
        ->whereHas('applications', function ($q) {
            $q->where('status', 'مقبول')
            ->where('admin_approval', 1);
        });

        if ($request->filled('search')) {
            $query->where('full_name', 'like', '%' . $request->search . '%');
        }

        if ($request->filled('company')) {
            $query->whereHas('applications', function($q) use ($request) {
                $q->where('status', 'مقبول')->where('admin_approval', 1)
                ->whereHas('company', function($q) use ($request) {
                    $q->where('company_name', '=', $request->company);
                });
            });
        }

        $students = $query->paginate(10);
        $companies = Company::all();

        return view('admin.trainingBooks', compact('students', 'companies'));
    }



    public function getStudentsAndSupervisors(Request $request)
    {
        $students = Student::all();
        $supervisors = Supervisor::all();
        $companies = Company::all();
        $internships = Internship::all();

        $studentsData = Application::join('students', 'applications.student_id', '=', 'students.id')
            ->join('companies', 'applications.company_id', '=', 'companies.id')
            ->join('internships', 'applications.internship_id', '=', 'internships.id')
            ->leftJoin('supervisor_assignments', 'students.id', '=', 'supervisor_assignments.student_id')
            ->leftJoin('supervisors', 'supervisor_assignments.supervisor_id', '=', 'supervisors.id')
            ->select(
                'students.full_name as student_name',
                'companies.company_name as company_name',
                'internships.title as internship_title',
                'supervisors.full_name as supervisor_name'
            )
            ->where('applications.admin_approval', 1)
            ->where('applications.status', 'مقبول');

        if ($request->filled('student_name')) {
            $studentsData->where('students.full_name', 'LIKE', '%' . $request->student_name . '%');
        }

        if ($request->filled('company_id')) {
            $studentsData->where('applications.company_id', $request->company_id);
        }

        if ($request->filled('supervisor_id')) {
            $studentsData->where('supervisor_assignments.supervisor_id', $request->supervisor_id);
        }

        $studentsData = $studentsData->distinct()->paginate(10);

        return view('admin.studentsData', compact('students', 'supervisors', 'studentsData', 'companies', 'internships'));
    }

    public function trainingRequests(Request $request)
    {
        $searchTerm = $request->get('search');

        if ($searchTerm) {
            $trainingRequests = Application::whereHas('student', function($query) use ($searchTerm) {
                $query->where('full_name', 'LIKE', '%' . $searchTerm . '%');
            })->paginate(10);
        } else {
            $trainingRequests = Application::paginate(10);
        }

        return view('admin.trainingRequests', compact('trainingRequests'));
    }



    public function updateApproval(Request $request, $id)
    {
        $trainingRequest = Application::findOrFail($id);

        if (in_array($request->admin_approval, [1, -1])) {
            $trainingRequest->admin_approval = $request->admin_approval;
            $trainingRequest->save();

            $student = $trainingRequest->student;
            $internshipTitle = $trainingRequest->internship->title;

            if ($request->admin_approval == 1) {
                $student->training_status = 'started';
                $student->save();

                $student->notify(new AdminApprovalNotification($internshipTitle, 1));
            } elseif ($request->admin_approval == -1) {
                $student->notify(new AdminApprovalNotification($internshipTitle, -1));
            }
        }

        return response()->json(['success' => true]);
    }



}
