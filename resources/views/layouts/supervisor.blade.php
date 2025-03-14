<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>لوحة تحكم المشرف</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@300;400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{asset('assets/css/supervisor.css')}}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <meta name="csrf-token" content="{{ csrf_token() }}">

</head>
<body>
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
                <div id="notifDropdown" class="absolute right-0 mt-3 w-72 bg-white text-black shadow-lg rounded-lg p-4 hidden z-10 transform translate-x-40">
                    <h4 class="font-semibold text-lg mb-3 text-gray-700">الإشعارات</h4>
                    <div class="notifications max-h-96 overflow-y-auto">
                        @forelse($notifications as $notification)
                            <div class="notification-item mb-3 p-3 border border-gray-200 rounded-lg hover:bg-gray-50 transition duration-300">
                                <p class="text-sm text-gray-800">{{ $notification->data['message'] ?? 'لا يوجد محتوى لهذا الإشعار' }}</p>

                                <span class="text-xs text-gray-500">{{ $notification->created_at->diffForHumans() }}</span>

                                @if(is_null($notification->read_at))
                                    <span class="text-xs text-red-500 font-semibold unread-notification">غير مقروء</span>
                                @else
                                    <span class="text-xs text-gray-500 font-semibold">مقروء</span>
                                @endif
                            </div>
                        @empty
                            <div class="text-center text-gray-600">
                                لا توجد إشعارات جديدة.
                            </div>
                        @endforelse
                    </div>

                    @if($notifications->whereNull('read_at')->count() > 0)
                        <button id="markAsRead" class="mt-3 text-blue-500 hover:text-blue-700">جعل الكل مقروء</button>
                    @endif
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

<div class="flex min-h-screen">
    <!-- الشريط الجانبي -->
    <aside class="w-64 bg-gray-800 text-white p-4">
        <nav>
            <ul class="space-y-4">
                <li>
                    <a href="{{route('supervisor.dashboard')}}" class="block px-4 py-2 flex items-center gap-3 {{ request()->routeIs('supervisor.dashboard') ? 'active' : 'hover:text-blue-400' }}">
                        <svg class="w-5 h-5 transition duration-300" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                            <path d="M3 12l9-9 9 9h-3v8h-12v-8h-3z"/>
                        </svg>
                        الصفحة الرئيسية
                    </a>
                </li>
                <li>
                    <a href="{{route('supervisor.studentsList')}}" class="block px-4 py-2 flex items-center gap-3 {{ request()->routeIs('supervisor.studentsList') ? 'active' : 'hover:text-blue-400' }}">
                        <svg class="w-5 h-5 transition duration-300" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                            <path d="M4 4h16v2H4V4zm0 4h16v2H4V8zm0 4h16v6H4v-6z"/>
                        </svg>
                        قائمة الطلبة
                    </a>
                </li>
                <li>
                    <a href="{{route('supervisor.companiesList')}}" class="block px-4 py-2 flex items-center gap-3 {{ request()->routeIs('supervisor.companiesList') ? 'active' : 'hover:text-blue-400' }}">
                        <svg class="w-5 h-5 transition duration-300" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                            <path d="M3 3h18v2H3V3zm0 4h18v2H3V7zm0 4h18v2H3v-2zm0 4h12v2H3v-2z"/>
                        </svg>
                        قائمة الشركات
                    </a>
                </li>
                <li>
                    <a href="{{route('supervisor.rates')}}" class="block px-4 py-2 flex items-center gap-3 {{ request()->routeIs('supervisor.rates') ? 'active' : 'hover:text-blue-400' }}">
                        <svg class="w-5 h-5 transition duration-300" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                            <path d="M12 2l3 6 6 1-4 5 1 7-6-3-6 3 1-7-4-5 6-1 3-6z"/>
                        </svg>
                        التقييمات
                    </a>
                </li>
            </ul>
        </nav>


    </aside>



    <!-- المحتوى الرئيسي -->
    <main class="flex-grow">
        @yield('content')
    </main>
</div>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        const notifButton = document.getElementById("notifButton");
        const notifDropdown = document.getElementById("notifDropdown");
        const userMenuButton = document.getElementById("userMenuButton");
        const userDropdown = document.getElementById("userDropdown");
        const notifBadge = document.getElementById("notifBadge");

        let unreadNotifications = @json($notifications->whereNull('read_at'));

        if (unreadNotifications.length > 0) {
            notifBadge.classList.remove("hidden");
        } else {
            notifBadge.classList.add("hidden");
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

        let markAsReadButton = document.getElementById('markAsRead');
        if (markAsReadButton) {
            markAsReadButton.addEventListener('click', function () {
                fetch('/mark-notifications-read', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    body: JSON.stringify({ notifications: unreadNotifications.map(n => n.id) })
                }).then(response => response.json())
                    .then(data => {
                        notifBadge.classList.add('hidden');

                        document.querySelectorAll('.unread-notification').forEach(item => {
                            item.textContent = 'مقروء';
                            item.classList.remove('text-red-500');
                            item.classList.add('text-gray-500');
                        });

                        unreadNotifications = [];
                    })
                    .catch(error => {
                        console.log(error);
                    });
            });
        }
    });

</script>



</body>

</html>

