<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Models\Company;
use App\Models\Evaluation;
use App\Models\Internship;
use App\Models\WeeklyEvaluation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class InternshipController extends Controller
{
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'duration' => 'required|string|max:100',
            'internship_link' => 'required|url',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
        ], [
            'title.required' => 'يرجى إدخال العنوان.',
            'title.string' => 'يجب أن يكون العنوان نصًا.',
            'title.max' => 'يجب ألا يزيد العنوان عن 255 حرفًا.',
            'description.required' => 'يرجى إدخال الوصف.',
            'description.string' => 'يجب أن يكون الوصف نصًا.',
            'duration.required' => 'يرجى إدخال مدة التدريب.',
            'duration.string' => 'يجب أن تكون المدة نصًا.',
            'duration.max' => 'يجب ألا تزيد المدة عن 100 حرف.',
            'internship_link.required' => 'يرجى إدخال رابط التدريب.',
            'internship_link.url' => 'يجب أن يكون رابط التدريب صحيحًا.',
            'image.image' => 'يجب أن تكون الصورة واحدة من الأنواع التالية: jpeg، png، jpg، gif، svg.',
            'image.mimes' => 'يجب أن تكون الصورة واحدة من الأنواع التالية: jpeg، png، jpg، gif، svg.',
            'image.max' => 'يجب ألا تزيد حجم الصورة عن 2048 كيلوبايت.',
            'start_date.required' => 'يرجى إدخال تاريخ البدء.',
            'start_date.date' => 'يجب أن يكون تاريخ البدء تاريخًا صحيحًا.',
            'end_date.required' => 'يرجى إدخال تاريخ الانتهاء.',
            'end_date.date' => 'يجب أن يكون تاريخ الانتهاء تاريخًا صحيحًا.',
            'end_date.after_or_equal' => 'يجب أن يكون تاريخ الانتهاء بعد أو يساوي تاريخ البدء.',
        ]);
        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }
        $internship = new Internship();
        $internship->company_id = Auth::user()->company->id;
        $internship->title = $request->title;
        $internship->description = $request->description;
        $internship->duration = $request->duration;
        $internship->internship_link = $request->internship_link;
        $internship->start_date = $request->start_date;
        $internship->end_date = $request->end_date;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('public/internships');
            $imageName = basename($imagePath);
            $internship->image = $imageName;
        }
        $internship->save();
        return redirect()->back()->with('success', 'تمت إضافة الفرصة التدريبية بنجاح!');
    }


    public function show(Request $request)
    {
        $search = $request->input('search');
        $duration = $request->input('duration');
        $company = $request->input('company');

        $internships = Internship::query();

        if ($search) {
            $internships = $internships->where('title', 'like', '%' . $search . '%')
                ->orWhereHas('company', function($query) use ($search) {
                    $query->where('company_name', 'like', '%' . $search . '%');
                });
        }

        if ($duration) {
            $internships = $internships->whereRaw("duration REGEXP ?", ["(^| )$duration"]);
        }

        if ($company) {
            $internships = $internships->where('company_id', $company);
        }

        $internships = $internships->get();

        $companies = Company::all();

        return view('student.showTrainingOpportunities', compact('internships', 'companies'));
    }




    public function opportunityDetails($id)
    {
        $internship = Internship::findOrFail($id);
        return view('student.opportunityDetails', compact('internship'));
    }


    public function update(Request $request, $id)
    {

        $internship = Internship::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'duration' => 'required|string|max:100',
            'internship_link' => 'required|url',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
        ], [
            'title.required' => 'يرجى إدخال العنوان.',
            'title.string' => 'يجب أن يكون العنوان نصًا.',
            'title.max' => 'يجب ألا يزيد العنوان عن 255 حرفًا.',
            'description.required' => 'يرجى إدخال الوصف.',
            'description.string' => 'يجب أن يكون الوصف نصًا.',
            'duration.required' => 'يرجى إدخال مدة التدريب.',
            'duration.string' => 'يجب أن تكون المدة نصًا.',
            'duration.max' => 'يجب ألا تزيد المدة عن 100 حرف.',
            'internship_link.required' => 'يرجى إدخال رابط التدريب.',
            'internship_link.url' => 'يجب أن يكون رابط التدريب صحيحًا.',
            'image.image' => 'يجب أن تكون الصورة واحدة من الأنواع التالية: jpeg، png، jpg، gif، svg.',
            'image.mimes' => 'يجب أن تكون الصورة واحدة من الأنواع التالية: jpeg، png، jpg، gif، svg.',
            'image.max' => 'يجب ألا تزيد حجم الصورة عن 2048 كيلوبايت.',
            'start_date.required' => 'يرجى إدخال تاريخ البدء.',
            'start_date.date' => 'يجب أن يكون تاريخ البدء تاريخًا صحيحًا.',
            'end_date.required' => 'يرجى إدخال تاريخ الانتهاء.',
            'end_date.date' => 'يجب أن يكون تاريخ الانتهاء تاريخًا صحيحًا.',
            'end_date.after_or_equal' => 'يجب أن يكون تاريخ الانتهاء بعد أو يساوي تاريخ البدء.',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }


        $internship->update([
            'title' => $request->title,
            'description' => $request->description,
            'duration' => $request->duration,
            'internship_link' => $request->internship_link,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'status' => $request->status,
        ]);

        if ($request->hasFile('image')) {
            if ($internship->image) {
                Storage::delete('public/internships/' . $internship->image);
            }

            $imagePath = $request->file('image')->store('public/internships');

            $imageName = basename($imagePath);

            $internship->update([
                'image' => $imageName,
            ]);
        }

        return redirect()->back()->with('success', 'تم تحديث الفرصة التدريبية بنجاح.');
    }



    public function destroy($id)
    {
        $internship = Internship::findOrFail($id);
        $internship->weeklyEvaluations()->delete();

        $companyId = $internship->company_id;

        WeeklyEvaluation::where('company_id', $companyId)->delete();

        Attendance::where('company_id', $companyId)->delete();

        Evaluation::where('company_id', $companyId)->delete();

        $internship->delete();

        return redirect()->back()->with('success', 'تم حذف الفرصة بنجاح!');
    }
}
