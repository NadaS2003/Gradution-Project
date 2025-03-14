<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>لوحة تحكم المسؤول</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@300;400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{asset('assets/css/supervisor.css')}}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <style>
        .rotate-180 {
            transform: rotate(180deg);
        }

    </style>
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

                                @if(isset($notification->data['application_id']))
                                    <a href="{{ route('admin.trainingRequests', $notification->data['application_id']) }}" class="text-sm text-blue-700 block">اذهب</a>
                                @endif

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
                    <a href="{{ route('admin.dashboard') }}" class="block px-4 py-2 flex items-center gap-3 hover:text-blue-400 {{ Route::currentRouteName() == 'admin.dashboard' ? 'active' : '' }}">
                        <i class="fas fa-home"></i> الصفحة الرئيسية
                    </a>
                </li>
                <li>
                    <button id="sidebarUserButton" class="w-full flex justify-between px-4 py-2 items-center hover:text-blue-400">
                    <span class="flex items-center gap-3">
                        <i class="fas fa-users"></i> إدارة المستخدمين
                    </span>
                        <i id="sidebarArrowIcon" class="fas fa-chevron-down transition-transform duration-300"></i>
                    </button>
                    <ul id="sidebarUserDropdown" class="hidden space-y-2 ml-6 mt-2 pl-2">
                        <li>
                            <a href="{{ route('admin.studentsManagement') }}" class="block px-4 py-2 flex items-center gap-3 hover:text-blue-400 {{ Route::currentRouteName() == 'admin.studentsManagement' ? 'active' : '' }}">
                                <i class="fas fa-user-graduate"></i> إدارة الطلاب
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('admin.companiesManagement') }}" class="block px-4 py-2 flex items-center gap-3 hover:text-blue-400 {{ Route::currentRouteName() == 'admin.companiesManagement' ? 'active' : '' }}">
                                <i class="fas fa-building"></i> إدارة الشركات
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('admin.supervisorsManagement') }}" class="block px-4 py-2 flex items-center gap-3 hover:text-blue-400 {{ Route::currentRouteName() == 'admin.supervisorsManagement' ? 'active' : '' }}">
                                <i class="fas fa-chalkboard-teacher"></i> إدارة المشرفين
                            </a>
                        </li>
                    </ul>
                </li>
                <li>
                    <a href="{{ route('admin.opportunitiesManagement') }}" class="block px-4 py-2 flex items-center gap-3 hover:text-blue-400 {{ Route::currentRouteName() == 'admin.opportunitiesManagement' ? 'active' : '' }}">
                        <i class="fas fa-briefcase"></i> إدارة الفرص التدريبية
                    </a>
                </li>
                <li>
                    <a href="{{ route('admin.audienceManagement') }}" class="block px-4 py-2 flex items-center gap-3 hover:text-blue-400 {{ Route::currentRouteName() == 'admin.audienceManagement' ? 'active' : '' }}">
                        <i class="fas fa-user-check"></i> إدارة الحضور والغياب
                    </a>
                </li>
                <li>
                    <a href="{{ route('admin.studentsRate') }}" class="block px-4 py-2 flex items-center gap-3 hover:text-blue-400 {{ Route::currentRouteName() == 'admin.studentsRate' ? 'active' : '' }}">
                        <i class="fas fa-star"></i> إدارة تقييم الطلاب
                    </a>
                </li>
                <li>
                    <a href="{{ route('admin.trainingRequests') }}" class="block px-4 py-2 flex items-center gap-3 hover:text-blue-400 {{ Route::currentRouteName() == 'admin.trainingRequests' ? 'active' : '' }}">
                        <i class="fas fa-file-alt"></i> إدارة الطلبات التدريبية
                    </a>
                </li>
                <li>
                    <a href="{{ route('admin.trainingBooks') }}" class="block px-4 py-2 flex items-center gap-3 hover:text-blue-400 {{ Route::currentRouteName() == 'admin.trainingBooks' ? 'active' : '' }}">
                        <i class="fas fa-book"></i> إدارة الكتب التدريبية
                    </a>
                </li>
                <li>
                    <a href="{{ route('admin.studentsData') }}" class="block px-4 py-2 flex items-center gap-3 hover:text-blue-400 {{ Route::currentRouteName() == 'admin.studentsData' ? 'active' : '' }}">
                        <i class="fas fa-database"></i> بيانات الطلاب المتدربين
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

    const currentUrl = window.location.href;
    const menuLinks = document.querySelectorAll("aside nav a");
    const sidebarUserDropdown = document.getElementById("sidebarUserDropdown");
    const sidebarArrowIcon = document.getElementById("sidebarArrowIcon");
    const sidebarUserButton = document.getElementById("sidebarUserButton");

    let isInsideUserManagement = false;

    menuLinks.forEach(link => {
        if (link.href === currentUrl) {
            link.classList.add("text-blue-400", "font-bold");
            link.closest("li").classList.add("bg-gray-700", "rounded-lg");

            if (link.closest("#sidebarUserDropdown")) {
                isInsideUserManagement = true;
            }
        }

        link.addEventListener("click", function () {
            menuLinks.forEach(l => l.classList.remove("bg-gray-700"));
            this.classList.add("bg-gray-700");
        });
    });

    if (isInsideUserManagement) {
        sidebarUserDropdown.classList.remove("hidden");
        sidebarArrowIcon.classList.add("rotate-180");
    }

    sidebarUserButton.addEventListener("click", function () {
        const isOpen = !sidebarUserDropdown.classList.contains("hidden");

        sidebarUserDropdown.classList.toggle("hidden");
        sidebarArrowIcon.classList.toggle("rotate-180");

        if (isOpen) {
            sidebarUserDropdown.classList.add("hidden");
        } else {
            sidebarUserDropdown.classList.remove("hidden");
        }
    });

</script>

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

