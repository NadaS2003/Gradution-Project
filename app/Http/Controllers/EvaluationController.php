<?php

namespace App\Http\Controllers;

use App\Exports\EvaluationExport;
use App\Models\Evaluation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Facades\Excel;

class EvaluationController extends Controller
{

    public function store(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'student_id' => 'required|exists:students,id',
            'training_book' => 'required|file|mimes:pdf,docx,doc|max:2048',
        ], [
            'student_id.required' => 'يجب اختيار الطالب.',
            'student_id.exists' => 'الطالب المحدد غير موجود في قاعدة البيانات.',
            'training_book.required' => 'يجب تحميل كتاب التدريب.',
            'training_book.file' => 'يجب أن يكون الملف المرفق من نوع ملف.',
            'training_book.mimes' => 'يجب أن يكون الملف من نوع PDF أو DOCX أو DOC.',
            'training_book.max' => 'حجم الملف يجب أن لا يتجاوز 2 ميجابايت.',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }


        $company_id = Auth::user()->company->id;


        $existingBook = Evaluation::where('student_id', $request->student_id)->first();
        if ($existingBook) {
            return back()->with('error', 'لقد قمت بالفعل برفع كتاب التدريب ولا يمكنك رفع آخر.');
        }

        $filename = $request->file('training_book')->store('public/training_books');
        $storedFilename = str_replace('public/', '', $filename);


        $trainingBook = new Evaluation();
        $trainingBook->student_id = $request->student_id;
        $trainingBook->company_id = $company_id;
        $trainingBook->evaluation_letter = $storedFilename;
        $trainingBook->save();

        return back()->with('success', 'تم رفع الكتاب بنجاح!');
    }


}
