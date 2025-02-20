@extends('layouts.student')
@section('title', 'ملفي الشخصي')

@section('content')
    <div class="mx-auto p-6">
        <h2 class="text-3xl font-bold text-center mb-6">ملفي الشخصي</h2>

        <div class="bg-white p-8 rounded-lg shadow-md max-w-4xl mx-auto border border-gray-200 mb-10">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8 items-start">
                <!-- العمود الأول -->
                <div class="space-y-6 mt-7">
                    <div>
                        <label class="block text-gray-700">الاسم رباعي</label>
                        <input type="text" name="full_name" value="هلا محمد"
                               class="w-full mt-2 p-3 border rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-400">
                    </div>

                    <div>
                        <label class="block text-gray-700">التخصص</label>
                        <input type="text" name="major" value="علم حاسوب"
                               class="w-full mt-2 p-3 border rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-400">
                    </div>

                    <div>
                        <label class="block text-gray-700">رقم الجوال</label>
                        <input type="text" name="phone" value="0596321789"
                               class="w-full mt-2 p-3 border rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-400">
                    </div>

                    <div>
                        <label class="block text-gray-700">المعدل التراكمي</label>
                        <input type="text" name="gpa" value="77"
                               class="w-full mt-2 p-3 border rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-400">
                    </div>
                    <div>
                        <label class="block text-gray-700">ملف السيرة الذاتية</label>
                        <input type="file" name="cv"
                               class="w-full mt-2 p-3 border rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-400">
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
                        <input type="text" name="university_id" value="220182286"
                               class="w-full mt-2 p-3 border rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-400">
                    </div>

                    <div>
                        <label class="block text-gray-700">البريد الإلكتروني</label>
                        <input type="email" name="email" value="company224@gmail.com"
                               class="w-full mt-2 p-3 border rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-400">
                    </div>

                    <div>
                        <label class="block text-gray-700">السنة الدراسية</label>
                        <input type="number" name="study_year" value="3"
                               class="w-full mt-2 p-3 border rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-400">
                    </div>

                    <div>
                        <label class="block text-gray-700">كلمة المرور</label>
                        <input type="password" name="password" value="220114lbb"
                               class="w-full mt-2 p-3 border rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-400">
                    </div>
                </div>
            </div>

            <!-- زر تعديل البيانات في المنتصف -->
            <div class="mt-8 flex justify-center">
                <button type="submit"
                        class="bg-blue-600 text-white px-6 py-3 rounded-lg shadow-md hover:bg-blue-700 transition">
                    تعديل
                </button>
            </div>
        </div>
    </div>
@endsection
