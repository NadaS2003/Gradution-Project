<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>@yield('title', 'بوابة التدريب الميداني')</title>
    <link rel="stylesheet" href="{{asset('assets/css/styles.css')}}">

</head>
<body>

<div class="header">
    بوابة التدريب الميداني
</div>

<div class="container">
    @yield('content')
</div>

<div class="footer">
    <p>© 2025 جميع الحقوق محفوظة</p>
</div>

</body>
</html>
