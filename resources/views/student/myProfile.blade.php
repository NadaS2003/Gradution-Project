@extends('layouts.student')
@section('title', 'ملفي الشخصي')

@section('content')
    @if ($errors->any())
        <div class="bg-red-100 border border-red-400 text-red-700 px-2 py-2 mr-4 ml-4 mt-4 rounded relative mb-6" role="alert">
            <strong class="font-bold">هناك أخطاء في الإدخال:</strong>
            <ul class="mt-2 list-disc list-inside">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    @if (session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-2 py-2 mr-4 ml-4 mt-4 rounded relative mb-6" role="alert">
            <p class="mt-2">{{ session('success') }}</p>
        </div>
    @endif

    <div class="mx-auto p-6">
        <h2 class="text-3xl font-bold text-center mb-6">ملفي الشخصي</h2>

        <div class="bg-white p-8 rounded-lg shadow-md max-w-4xl mx-auto border border-gray-200 mb-10">
            <form action="{{ route('student.Profile.update') }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8 items-start">
                    <!-- العمود الأول -->
                    <div class="space-y-6 mt-7">
                        <div>
                            <label class="block text-gray-700">الاسم رباعي</label>
                            <input type="text" name="full_name" value="{{ $student->full_name ?? '' }}"
                                   class="w-full mt-2 p-3 border rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-400">
                        </div>

                        <div>
                            <label class="block text-gray-700">التخصص</label>
                            <input type="text" name="major" value="{{ $student->major ?? '' }}"
                                   class="w-full mt-2 p-3 border rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-400">
                        </div>

                        <div>
                            <label class="block text-gray-700">رقم الجوال</label>
                            <input type="text" name="phone_number" value="{{ $student->phone_number ?? '' }}"
                                   class="w-full mt-2 p-3 border rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-400">
                        </div>

                        <div>
                            <label class="block text-gray-700">المعدل التراكمي</label>
                            <input type="text" name="gpa" value="{{ $student->gpa ?? '' }}"
                                   class="w-full mt-2 p-3 border rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-400">
                        </div>

                        <div>
                            <label class="block text-gray-700">ملف السيرة الذاتية</label>

                            <!-- حقل رفع الملف -->
                            <input type="file" name="cv_file"
                                   class="w-full mt-2 p-3 border rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-400">

                            <!-- عرض اسم الملف القديم إن وجد -->
                            @if($student->cv_file)
                                <div class="mt-2 text-gray-600">
                                    <span>الملف الحالي:</span>
                                    <a href="{{ asset('storage/' . $student->cv_file) }}" target="_blank"
                                       class="text-blue-500 hover:underline">
                                        {{ basename($student->cv_file) }}
                                    </a>
                                </div>
                            @endif
                        </div>

                    </div>

                    <!-- العمود الثاني -->
                    <div class="space-y-6">
                        <!-- صورة البروفايل -->
                        <div class="flex justify-center">
                            <img src="{{ asset('assets/img/profile-user.png') }}" alt="Profile Image"
                                 class="w-28 h-28 rounded-full shadow-md">
                        </div>

                        <div>
                            <label class="block text-gray-700">الرقم الجامعي</label>
                            <input type="text" name="university_id" value="{{ $student->university_id ?? '' }}"
                                   class="w-full mt-2 p-3 border rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-400">
                        </div>

                        <div>
                            <label class="block text-gray-700">البريد الإلكتروني</label>
                            <input type="email" name="email" value="{{ $student->user->email ?? '' }}"
                                   class="w-full mt-2 p-3 border rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-400">
                        </div>

                        <div>
                            <label class="block text-gray-700">السنة الدراسية</label>
                            <input type="number" name="academic_year" value="{{ $student->academic_year ?? '' }}"
                                   class="w-full mt-2 p-3 border rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-400">
                        </div>

                        <div>
                            <label class="block text-gray-700">كلمة المرور</label>
                            <input type="password" name="password" placeholder="تغيير كلمة المرور"
                                   class="w-full mt-2 p-3 border rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-400">
                        </div>

                    </div>
                </div>

                <div class="mt-8 flex justify-center">
                    <button type="submit"
                            class="bg-blue-600 text-white px-6 py-3 rounded-lg shadow-md hover:bg-blue-700 transition">
                        تعديل
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
