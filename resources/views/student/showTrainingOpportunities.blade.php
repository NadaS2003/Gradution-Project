@extends('layouts.student')

@section('title', 'عرض الفرص التدريبية')

@section('content')
    @php
        $activeApplications = \App\Models\Application::where('student_id', auth()->user()->student->id)
            ->whereIn('status', ['قيد المراجعة', 'مقبول'])
            ->count();
    @endphp
    <div id="alertBar" class="bg-blue-200 text-blue-700 text-center py-3 mb-6">
        <div class="flex justify-between items-center max-w-4xl mx-auto">
            <p class="text-lg font-semibold mx-auto">
                عدد الفرص المتاحة للتقديم: <span class="font-bold text-red-700">{{ 5 - $activeApplications }} فرص </span>
            </p>
            <button onclick="closeAlertBar()" class="text-black hover:text-blue-700 mr-2">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
        </div>
    </div>

    <div class="mt-6">
        <div class="flex justify-center items-center px-3 py-2">
            <h2 class="text-xl font-bold text-center">قائمة الفرص التدريبية</h2>
        </div>
    </div>

    <div class="mt-3 mb-10 px-8" style="margin-right: 800px">
        <div class="flex items-center mb-4">
            <form method="GET" action="{{ route('student.showTraining') }}" class="flex items-center mb-4">
                <input type="text" name="search" class="form-control px-2 rounded border border-gray-300 w-full py-2 h-10 w-25" placeholder="البحث" value="{{ request()->get('search') }}">
                <button type="submit" class="bg-blue-600 text-white rounded border px-4 py-2 h-10 mx-2 hover:bg-blue-700">بحث</button>
                <button type="button" class="bg-gray-400 hover:bg-gray-500 text-white rounded border px-2 py-2 h-10 flex justify-center items-center" id="filterButton">
                    <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7"></path>
                    </svg>
                </button>
            </form>
        </div>
    </div>

    <div id="filterMenu" class="hidden absolute bg-white border border-gray-300 rounded-md mt-2 left-20 top-40 p-4 mt-10 shadow-lg w-72 z-10">
        <form method="GET" action="{{ route('student.showTraining') }}">
            <div class="mb-4">
                <label for="duration" class="block text-sm">مدة التدريب</label>
                <select name="duration" id="duration" class="form-control w-full px-2 py-2 rounded border border-gray-300">
                    <option value="">اختر المدة</option>
                    <option value="1" {{ request()->get('duration') == '1' ? 'selected' : '' }}>شهر</option>
                    <option value="2" {{ request()->get('duration') == '2' ? 'selected' : '' }}>شهرين</option>
                    <option value="3" {{ request()->get('duration') == '3' ? 'selected' : '' }}>ثلاثة أشهر</option>
                    <option value="4" {{ request()->get('duration') == '4' ? 'selected' : '' }}>أربعة أشهر</option>
                    <option value="5" {{ request()->get('duration') == '5' ? 'selected' : '' }}>خمس أشهر</option>
                </select>
            </div>

            <div class="mb-4">
                <label for="company" class="block text-sm">الشركة</label>
                <select name="company" id="company" class="form-control w-full px-2 py-2 rounded border border-gray-300">
                    <option value="">اختر الشركة</option>
                    @foreach($companies as $company)
                        <option value="{{ $company->id }}" {{ request()->get('company') == $company->id ? 'selected' : '' }}>{{ $company->company_name }}</option>
                    @endforeach
                </select>
            </div>

            <button type="submit" class="bg-blue-600 text-white rounded border px-4 py-2 w-full hover:bg-blue-700">تطبيق الفلتر</button>
        </form>
    </div>

    <div class="mt-5 mr-5 ml-8 mb-6">
        @if($internships->isEmpty())
            <div class="text-center text-gray-500">لا توجد بيانات لعرضها</div>
        @else
            <div class="grid grid-cols-1 md:grid-cols-3 gap-10 mt-4">
                @foreach($internships as $internship)
                    <div class="bg-white rounded-lg shadow p-4 border border-e-black border-opacity-15 relative">
                        @if ($internship->image)
                            <img src="{{ asset('storage/internships/' . $internship->image) }}" class="w-full h-40 object-cover rounded-md" alt="{{$internship->title}}">
                        @else
                            <img src="{{ asset('assets/img/default.jfif') }}" class="w-full h-40 object-cover rounded-md" alt="Default Image">
                        @endif
                        <div class="mt-4">
                            <h5 class="text-lg font-bold">{{$internship->title}}</h5>
                            <p class="text-gray-700">{{$internship->company->company_name}}</p>
                            <p class="text-gray-500">{{$internship->duration}} أشهر </p>
                            <p class="text-gray-500">
                                @if($internship->status == 'مفتوحة')
                                    <span class="text-green-600">مفتوحة</span>
                                @elseif($internship->status == 'مكتملة')
                                    <span class="text-yellow-600">مكتملة</span>
                                @elseif($internship->status == 'مغلقة')
                                    <span class="text-red-600">مغلقة</span>
                                @else
                                    <span class="text-gray-600">غير محدد</span>
                                @endif
                            </p>
                        </div>
                        <a href="{{ route('student.opportunityDetails', $internship->id) }}" class="absolute bottom-4 left-4 bg-blue-600 text-white text-center rounded-md hover:bg-blue-700 w-24 h-7 flex justify-center items-center text-sm">تفاصيل</a>
                    </div>
                @endforeach

            </div>
        @endif
    </div>

    <script>
        const filterButton = document.getElementById('filterButton');
        const filterMenu = document.getElementById('filterMenu');

        filterButton.addEventListener('click', () => {
            filterMenu.classList.toggle('hidden');
        });

        window.addEventListener('click', (e) => {
            if (!filterMenu.contains(e.target) && !filterButton.contains(e.target)) {
                filterMenu.classList.add('hidden');
            }
        });

        function closeAlertBar() {
            document.getElementById('alertBar').style.display = 'none';
        }
    </script>

@endsection
