@extends('layouts.admin')

@section('content')
    <div class=" mt-6">
        <div class="flex justify-center items-center px-3 py-2">
            <h2 class="text-2xl font-bold  text-center">إدارة تقييم الطلاب</h2>
        </div>
    </div>

    <div class="mt-3 mb-10 px-8" style="margin-right: 800px">
        <div class="flex items-center mb-4">
            <form method="GET" action="{{ route('admin.studentsRate') }}" class="flex items-center mb-4">

                <input type="text" name="search" class="form-control px-1 rounded border border-gray-300 w-full py-2 h-10 w-70"
                       placeholder="البحث باسم الطالب"
                       value="{{ request()->get('search') }}">


                <button type="submit" class="bg-blue-600 text-white rounded border px-4 py-2 h-10 mx-1 hover:bg-blue-700">
                    بحث
                </button>

                <button type="button" class="bg-gray-400 hover:bg-gray-500 text-white rounded border px-2 mx-1 py-2 h-10 flex justify-center items-center" id="filterButton">
                    <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7"></path>
                    </svg>
                </button>
                <a href="{{ route('admin.exportRates') }}"
                   class="bg-blue-600 text-white rounded border px-4 py-2 hover:bg-blue-700 w-full text-center">
                    تصدير إلى إكسل
                </a>

            </form>
        </div>
    </div>
    <div id="filterMenu" class="hidden absolute bg-white border border-gray-300 rounded-md mt-2 left-20 top-40 p-4 shadow-lg w-72 z-10">
        <form method="GET" action="{{ route('admin.studentsRate') }}">
            <div class="mb-4">
                <label for="major" class="block text-sm">التخصص</label>
                @if(isset($majors))
                <select name="major" id="major" class="form-control w-full px-2 py-2 rounded border border-gray-300">
                    <option value="">كل التخصصات</option>
                    @foreach($majors as $major)
                        <option value="{{ $major }}" {{ request()->get('major') == $major ? 'selected' : '' }}>{{ $major }}</option>
                    @endforeach
                </select>
                @endif
            </div>

            <button type="submit" class="bg-blue-600 text-white rounded border px-4 py-2 w-full hover:bg-blue-700">تطبيق الفلتر</button>
        </form>
    </div>

    <div class="mt-5 mr-5 ml-8 mb-6">
        <table class="w-full border-collapse border border-gray-300">
            <thead>
            <tr>
                <th class="border border-gray-300 px-4 py-2 text-right">اسم الطالب</th>
                <th class="border border-gray-300 px-4 py-2 text-right">التخصص</th>
                <th class="border border-gray-300 px-4 py-2 text-right">التقييم</th>
            </tr>
            </thead>
            <tbody>
            @if($students->isEmpty())
                <tr>
                    <td colspan="8" class="border border-gray-300 px-4 py-2 text-center text-gray-500">
                        لا توجد بيانات
                    </td>
                </tr>
            @else
                @foreach($students as $rate)
                    <tr class="hover:bg-gray-50">
                        <td class="border border-gray-300 px-4 py-2">{{$rate->full_name}}</td>
                        <td class="border border-gray-300 px-4 py-2">{{$rate->major}}</td>
                        <td class="border border-gray-300 px-4 py-2">
                            @if (is_null($rate->supervisor_id))
                                <button class="bg-yellow-500 text-white px-3 py-1 rounded">لا يوجد مشرف لتقييم الطالب</button>
                            @elseif ($rate->evaluations->isNotEmpty() && $rate->evaluations->first()->final_evaluation === 'pass')
                                <button class="bg-green-700 text-white px-3 py-1 rounded">ناجح</button>
                            @elseif ($rate->evaluations->isNotEmpty() && $rate->evaluations->first()->final_evaluation === 'fail')
                                <button class="bg-red-700 text-white px-3 py-1 rounded">راسب</button>
                            @elseif ($rate->evaluations->isNotEmpty() && is_null($rate->evaluations->first()->final_evaluation))
                                <button class="bg-gray-400 text-white px-3 py-1 rounded">لم يتم التقييم بعد</button>
                            @else
                                <button class="bg-yellow-500 text-white px-3 py-1 rounded">{{$rate->evaluations->first()->final_evaluation}}</button>
                            @endif
                        </td>
                    </tr>
                @endforeach





            @endif
            </tbody>
        </table>
        <div class="mt-4 flex justify-end w-full">
            {{ $students->links('vendor.pagination.simple-tailwind') }}
        </div>
    </div>
    <script>
        document.getElementById('filterButton').addEventListener('click', function () {
            let filterMenu = document.getElementById('filterMenu');
            filterMenu.classList.toggle('hidden');
        });

        document.addEventListener('click', function (event) {
            let filterMenu = document.getElementById('filterMenu');
            let filterButton = document.getElementById('filterButton');

            if (!filterMenu.contains(event.target) && !filterButton.contains(event.target)) {
                filterMenu.classList.add('hidden');
            }
        });
    </script>
@endsection
