@extends('layouts.company')
@section('title', 'الملف الشخصي')

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
        <h2 class="text-3xl font-bold text-center mb-6">الملف الشخصي</h2>

        <div class="bg-white p-8 pb-16 rounded-lg shadow-md max-w-4xl mx-auto border border-gray-200 mb-10">
            <form action="{{ route('company.profile.update') }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8 items-start">
                    <!-- العمود الأول -->
                    <div class="space-y-6 mt-7">
                        <div>
                            <label class="block text-gray-700">اسم الشركة</label>
                            <input type="text" name="company_name" value="{{ $company->company_name ?? '' }}"
                                   class="w-full mt-2 p-3 border rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-400">
                        </div>

                        <div>
                            <label class="block text-gray-700">الوصف</label>
                            <input type="text" name="description" value="{{ $company->description ?? '' }}"
                                   class="w-full mt-2 p-3 border rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-400">
                        </div>

                        <div>
                            <label class="block text-gray-700">العنوان</label>
                            <input type="text" name="location" value="{{ $company->location ?? '' }}"
                                   class="w-full mt-2 p-3 border rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-400">
                        </div>

                        <div>
                            <label class="block text-gray-700">الموقع الإلكتروني</label>
                            <input type="text" name="website" value="{{ $company->website ?? '' }}"
                                   class="w-full mt-2 p-3 border rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-400">
                        </div>

                        <div>
                            <label class="block text-gray-700">رقم الجوال</label>
                            <input type="number" name="phone_number" value="{{ $company->phone_number ?? '' }}"
                                   class="w-full mt-2 p-3 border rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-400">
                        </div>
                    </div>

                    <div class="space-y-6 mt-7">
                        <div class="flex justify-center">
                            <img src="{{ asset('assets/img/profile-user.png') }}" alt="Profile Image"
                                 class="w-40 h-40 rounded-full shadow-md">
                        </div>

                        <div>
                            <label class="block text-gray-700">البريد الإلكتروني</label>
                            <input type="email" name="email" value="{{ $company->user->email ?? '' }}"
                                   class="w-full mt-2 p-3 border rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-400">
                        </div>

                        <div>
                            <label class="block text-gray-700">كلمة المرور</label>
                            <input type="password" name="password" placeholder="********"
                                   class="w-full mt-2 p-3 border rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-400">
                        </div>
                        <div class="mt-8 flex justify-center">
                            <button type="submit"
                                    class="bg-blue-600 text-white w-28 px-10 py-2 rounded-lg shadow-md hover:bg-blue-700 transition">
                                تعديل
                            </button>
                        </div>
                    </div>
                </div>


            </form>
        </div>
    </div>
@endsection
