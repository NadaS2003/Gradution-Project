<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>لوحة تحكم الطالب</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@300;400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{asset('assets/css/student.css')}}">
</head>
<body class="bg-100">
<header class="bg-blue-600 text-white py-7 shadow-md relative">
    <div class="container mx-auto flex justify-between items-center px-4">
        <h1 class="text-xl font-bold absolute right-7 top-1/2 transform -translate-y-1/2">لوحة التحكم</h1>
        <div class="flex items-center absolute left-5 top-1/2 transform -translate-y-1/2">
            <!-- زر الإشعارات -->
            <div class="relative mr-4">
                <button id="notifButton" class="relative focus:outline-none">
                    <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path d="M12 24a2 2 0 002-2h-4a2 2 0 002 2zm6-6V11a6 6 0 10-12 0v7l-2 2v1h16v-1l-2-2z"></path>
                    </svg>
                    <span id="notifBadge" class="absolute -top-1 -right-1 bg-red-500 text-white rounded-full w-3 h-3 hidden"></span>
                </button>
                <div id="notifDropdown" class="absolute right-0 mt-3 w-60 bg-white text-black shadow-lg rounded-lg p-3 hidden">
                    <h4 class="font-semibold text-lg mb-2">الإشعارات</h4>
                    <ul>
                        <li class="border-b py-2 text-sm">تمت الموافقة على تقريرك</li>
                        <li class="border-b py-2 text-sm">تم إضافة طالب جديد</li>
                        <li class="py-2 text-sm">موعد اجتماع غدًا</li>
                    </ul>
                </div>
            </div>

            <!-- اسم المشرف وقائمة منسدلة -->
            <div class="relative">
                <button id="userMenuButton" class="flex items-center gap-4 px-4 py-2 rounded-lg focus:outline-none">
                    <span class="font-semibold">{{ \Illuminate\Support\Facades\Auth::user()->name }}</span>
                    <svg class="w-4 h-4" fill="currentColor" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"></path>
                    </svg>
                </button>
                <div id="userDropdown" class="absolute right-0 mt-2 w-40 bg-white text-black shadow-lg rounded-lg p-2 hidden">
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="block w-full text-right px-4 py-2 hover:bg-gray-100 text-sm">تسجيل الخروج</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</header>


<!-- الشريط الجانبي والمحتوى الرئيسي -->
<div class="flex min-h-screen">
    <!-- الشريط الجانبي -->
    <aside class="w-64 bg-gray-800 text-white p-4">
        <nav>
            <ul class="space-y-4">
                <li>
                    <a href="{{route('student.dashboard')}}" class="block px-4 py-2 flex items-center gap-3 hover:text-blue-400 {{ request()->routeIs('student.dashboard') ? 'active' : '' }}">
                        <svg class="w-5 h-5 transition duration-300" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                            <path d="M3 12l9-9 9 9h-3v8h-12v-8h-3z"/>
                        </svg>
                        الصفحة الرئيسية
                    </a>
                </li>
                <li>
                    <a href="{{route('student.showTraining')}}" class="block px-4 py-2 flex items-center gap-3 hover:text-blue-400 {{ request()->routeIs('student.showTraining') ? 'active' : '' }}">
                        <svg class="w-5 h-5 transition duration-300" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                            <path d="M4 4h16v2H4V4zm0 4h16v2H4V8zm0 4h16v6H4v-6z"/>
                        </svg>
                        عرض الفرص التدريبية
                    </a>
                </li>
                <li>
                    <a href="{{route('student.myRequests')}}" class="block px-4 py-2 flex items-center gap-3 hover:text-blue-400 {{ request()->routeIs('student.myRequests') ? 'active' : '' }}">
                        <svg class="w-5 h-5 transition duration-300" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                            <path d="M3 3h18v2H3V3zm0 4h18v2H3V7zm0 4h18v2H3v-2zm0 4h12v2H3v-2z"/>
                        </svg>
                        طلباتي
                    </a>
                </li>
                <li>
                    <a href="{{route('student.myProfile')}}" class="block px-4 py-2 flex items-center gap-3 hover:text-blue-400 {{ request()->routeIs('student.myProfile') ? 'active' : '' }}">
                        <svg class="w-5 h-5 transition duration-300" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                            <path d="M12 12c2.21 0 4-1.79 4-4S14.21 4 12 4 8 5.79 8 8s1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/>
                        </svg>
                        ملفي الشخصي
                    </a>
                </li>
                <li>
                    <a href="{{route('student.companyRate')}}" class="block px-4 py-2 flex items-center gap-3 hover:text-blue-400 {{ request()->routeIs('student.companyRate') ? 'active' : '' }}">
                        <svg class="w-5 h-5 transition duration-300" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                            <path d="M12 2l3 6 6 1-4 5 1 7-6-3-6 3 1-7-4-5 6-1 3-6z"/>
                        </svg>
                        تقييم الشركات
                    </a>
                </li>
            </ul>
        </nav>
    </aside>



    <!-- المحتوى الرئيسي -->
    <main class="flex-grow">
        @yield('content')
        <div class="footer">
            <p>© 2025 جميع الحقوق محفوظة</p>
        </div>
    </main>
</div>
<script>
    document.addEventListener("DOMContentLoaded", function () {
        const notifButton = document.getElementById("notifButton");
        const notifDropdown = document.getElementById("notifDropdown");
        const userMenuButton = document.getElementById("userMenuButton");
        const userDropdown = document.getElementById("userDropdown");
        const notifBadge = document.getElementById("notifBadge");

        // لتوضيح وجود إشعارات غير مقروءة
        let unreadNotifications = true; // يمكنك تغيير هذا بناءً على حالة الإشعارات

        if (unreadNotifications) {
            notifBadge.classList.remove("hidden");
        }

        notifButton.addEventListener("click", function (event) {
            event.stopPropagation();
            notifDropdown.classList.toggle("hidden");
            userDropdown.classList.add("hidden");
        });

        userMenuButton.addEventListener("click", function (event) {
            event.stopPropagation();
            userDropdown.classList.toggle("hidden");
            notifDropdown.classList.add("hidden");
        });

        document.addEventListener("click", function () {
            notifDropdown.classList.add("hidden");
            userDropdown.classList.add("hidden");
        });


    });
</script>




</body>

</html>

