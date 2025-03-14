<?php

namespace App\Http\Controllers;

use App\Models\Application;
use App\Models\Company;
use App\Models\Internship;
use App\Models\User;
use App\Notifications\ApplicationAccepted;
use App\Notifications\ApplicationRejected;
use App\Notifications\InternshipApplicationNotification;
use App\Notifications\InternshipApprovalNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class ApplicationController extends Controller
{

    public function store(Request $request)
    {
        if (!$request->has('internship_id') || !$request->has('company_id')) {
            return response()->json(['success' => false, 'message' => 'البيانات غير مكتملة']);
        }


        try {
            $student = Auth::user()->student;
            if (!$student) {
                return response()->json(['success' => false, 'message' => 'لم يتم العثور على بيانات الطالب.']);
            }

            $internship = Internship::find($request->internship_id);

            if (!$internship) {
                return response()->json(['success' => false, 'message' => 'الفرصة التدريبية غير موجودة']);
            }

            $activeApplications = Application::where('student_id', $student->id)
                ->whereNotIn('status', ['مرفوض'])
                ->count();

            if ($activeApplications >= 5) {
                return response()->json([
                    'success' => false,
                    'message' => 'لقد وصلت إلى الحد الأقصى (5 فرص)، لا يمكنك التقديم على فرص إضافية إلا بعد رفض إحداها.'
                ]);
            }

            $existingApplication = Application::where('student_id', $student->id)
                ->where('internship_id', $request->internship_id)
                ->first();

            if ($existingApplication) {
                return response()->json(['success' => false, 'message' => 'لقد قدمت طلبك لهذه الفرصة التدريبية بالفعل.']);
            }

             Application::create([
                'student_id' => $student->id,
                'internship_id' => $request->internship_id,
                'company_id' => $request->company_id,
                'status' => 'قيد المراجعة',
                 'admin_approval' => false,
            ]);

            $company = Company::find($request->company_id);
            if ($company) {
                $company->notify(new InternshipApplicationNotification());
            }

            return response()->json([
                'success' => true,
                'form_url' => $internship->internship_link,
            ]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'حدث خطأ أثناء تقديم الطلب: ' . $e->getMessage()]);
        }
    }


    public function updateStatus(Request $request, $id)
    {
        try {
            $application = Application::findOrFail($id);
            $application->status = $request->status;
            $application->admin_approval = false;
            $application->save();

            $student = $application->student;
            $company = $application->internship->company;

            $status = $request->status;
            if ($status == 'مقبول') {
                $application->student->notify(new ApplicationAccepted($application->internship->title));
                $admin = User::where('role', 'admin')->first();

                if ($admin) {
                    $admin->notify(new InternshipApprovalNotification($student, $company, $application));
                    Log::info("تم إرسال إشعار للمشرف {$admin->name} بالموافقة على التدريب للطالب: {$student->first_name} {$student->last_name}");
                } else {
                    Log::warning("لم يتم العثور على مشرف لإرسال الإشعار.");
                }
            } else {
                $application->student->notify(new ApplicationRejected($application->internship->title));
            }
            return response()->json([
                'success' => true,
                'new_status' => $application->status
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'حدث خطأ: ' . $e->getMessage()
            ]);
        }
    }

}
