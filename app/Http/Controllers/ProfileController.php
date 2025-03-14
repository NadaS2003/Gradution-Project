<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\Student;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class ProfileController extends Controller
{
    public function showStudent()
    {
        $student = Auth::user()->student;
        if (!$student) {
            return redirect()->route('student.myProfile')->with('error', 'لم يتم العثور على بيانات الطالب.');
        }
        return view('student.myProfile', compact('student'));
    }

    public function updateStudent(Request $request)
    {

        $validator=Validator::make($request->all(),[
            'full_name' => 'required|string|max:255',
            'major' => 'required|string|max:255',
            'phone_number' => 'required|string|max:20',
            'gpa' => 'required|numeric|min:0|max:100',
            'university_id' => 'required|string|max:20',
            'email' => 'required|email|max:255',
            'academic_year' => 'required|integer|min:1|max:10',
            'password' => 'nullable|min:6',
            'cv_file' => 'nullable|mimes:pdf,doc,docx|max:2048',
        ], [
            'full_name.required' => 'الاسم الكامل مطلوب.',
            'full_name.string' => 'يجب أن يكون الاسم نصيًا.',
            'full_name.max' => 'يجب ألا يزيد الاسم عن 255 حرفًا.',

            'major.required' => 'التخصص مطلوب.',
            'major.string' => 'يجب أن يكون التخصص نصيًا.',
            'major.max' => 'يجب ألا يزيد التخصص عن 255 حرفًا.',

            'phone_number.required' => 'رقم الجوال مطلوب.',
            'phone_number.string' => 'يجب أن يكون رقم الجوال نصيًا.',
            'phone_number.max' => 'يجب ألا يزيد رقم الجوال عن 20 رقمًا.',

            'gpa.required' => 'المعدل التراكمي مطلوب.',
            'gpa.numeric' => 'يجب أن يكون المعدل التراكمي رقمًا.',
            'gpa.min' => 'أقل قيمة للمعدل التراكمي هي 0.',
            'gpa.max' => 'أعلى قيمة للمعدل التراكمي هي 100.',

            'university_id.required' => 'الرقم الجامعي مطلوب.',
            'university_id.string' => 'يجب أن يكون الرقم الجامعي نصيًا.',
            'university_id.max' => 'يجب ألا يزيد الرقم الجامعي عن 20 حرفًا.',

            'email.required' => 'البريد الإلكتروني مطلوب.',
            'email.email' => 'يجب إدخال بريد إلكتروني صالح.',
            'email.max' => 'يجب ألا يزيد البريد الإلكتروني عن 255 حرفًا.',

            'academic_year.required' => 'السنة الدراسية مطلوبة.',
            'academic_year.integer' => 'يجب أن تكون السنة الدراسية رقمًا صحيحًا.',
            'academic_year.min' => 'أقل سنة دراسية هي 1.',
            'academic_year.max' => 'أقصى سنة دراسية هي 10.',

            'password.min' => 'يجب أن تكون كلمة المرور على الأقل 6 أحرف.',

            'cv_file.mimes' => 'يجب أن يكون ملف السيرة الذاتية بصيغة PDF أو DOC أو DOCX.',
            'cv_file.max' => 'يجب ألا يزيد حجم ملف السيرة الذاتية عن 2 ميجابايت.',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $user = Auth::user();
        $student = Student::where('user_id', $user->id)->first();

        if (!$student) {
            return redirect()->route('student.myProfile')->with('error', 'لم يتم العثور على بيانات الطالب.');
        }

        $student->full_name = $request->full_name;
        $student->major = $request->major;
        $student->phone_number = $request->phone_number;
        $student->gpa = $request->gpa;
        $student->university_id = $request->university_id;
        $student->academic_year = $request->academic_year;

        $user->email = $request->email;
        $user->name = $request->full_name;
        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }


        if ($request->hasFile('cv_file')) {
            if ($student->cv_file) {
                Storage::disk('public')->delete($student->cv_file);
            }
            $cvPath = $request->file('cv_file')->store('cv_files', 'public');
            $student->cv_file = $cvPath;
        }

        $user->save();
        $student->save();

        return redirect()->route('student.Profile')->with('success', 'تم تحديث بيانات الملف الشخصي بنجاح.');
    }

    public function showCompany()
    {
        $company = Auth::user()->company;
        return view('company.profile', compact('company'));
    }

    public function updateCompany(Request $request)
    {

        $validator=Validator::make($request->all(),[
            'company_name' => 'required|string|max:255',
            'website' => 'required|string',
            'phone_number' => 'required|string|max:20',
            'description' => 'required|string',
            'location' => 'required|string',
            'email' => 'required|email|max:255',
            'password' => 'nullable|min:6',
        ], [
            'company_name.required' => 'اسم الشركة مطلوب.',
            'company_name.string' => 'يجب أن يكون الاسم نصيًا.',
            'company_name.max' => 'يجب ألا يزيد الاسم عن 255 حرفًا.',

            'website.required' => 'حقل الموقع الإلكتروني مطلوب.',
            'website.string' => 'يجب أن يكون الموقع الإلكتروني نصًا.',

            'phone_number.required' => 'رقم الجوال مطلوب.',
            'phone_number.string' => 'يجب أن يكون رقم الجوال نصيًا.',
            'phone_number.max' => 'يجب ألا يزيد رقم الجوال عن 20 رقمًا.',

            'description.required' => 'حقل الوصف مطلوب.',
            'description.string' => 'يجب أن يكون الوصف نصًا.',

            'location.required' => 'حقل الموقع مطلوب.',
            'location.string' => 'يجب أن يكون الموقع نصًا.',

            'email.required' => 'البريد الإلكتروني مطلوب.',
            'email.email' => 'يجب إدخال بريد إلكتروني صالح.',
            'email.max' => 'يجب ألا يزيد البريد الإلكتروني عن 255 حرفًا.',


            'password.min' => 'يجب أن تكون كلمة المرور على الأقل 6 أحرف.',

        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $company = Auth::user()->company;
        $company->company_name = $request->company_name;
        $company->website = $request->website;
        $company->phone_number = $request->phone_number;
        $company->description = $request->description;
        $company->location = $request->location;

        $user = Auth::user();
        $user->email = $request->email;
        $user->name = $request->company_name;
        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }


        $user->save();
        $company->save();

        return redirect()->route('company.profile')->with('success', 'تم تحديث البيانات بنجاح!');
    }
}
