<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('title', 'laravel test')</title>  <!--페이지 title 설정, default 설정-->
</head>
<body>
    @yield('content')
    <ul>
        <li><a href="/">Home</a></li>
        <li><a href="/contact">Contact</a> us to learn more.</li>
        <li><a href="/about">About Us</a></li>
    </ul>
</body>
</html>
