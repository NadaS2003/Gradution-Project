<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>بوابة التدريب الميداني</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #FFFFFF;
            text-align: center;
        }

        header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 20px 40px;
            background-color: #FFFFFF;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        header a {
            text-decoration: none;
            color: #000;
            font-size: 16px;
            margin-left: 20px;
        }

        header a:hover {
            color: #007bff;
        }

        .main-content {
            margin-top: 50px;
        }

        .main-content img {
            max-width: 30%;
            height: auto;
        }

        .welcome-text {
            font-size: 32px;
            font-weight: bold;
            color: #0056b3;
            margin-top: 20px;
        }
    </style>
</head>
<body>
<header>
    <div>بوابة التدريب الميداني</div>
    <div>
        <a href="{{url('login')}}">تسجيل الدخول</a>
        <a href="{{url('register')}}">انشاء حساب</a>
    </div>
</header>

<div class="main-content">
    <img src="{{asset('assets/img/welcome.jpg')}}" alt="Illustration">
    <div class="welcome-text">اهلا بكم في بوابة التدريب الميداني</div>
</div>
</body>
</html>
