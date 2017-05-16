<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>@yield('title')  -- {{env('APP_NAME')}}</title>
    <meta name="keywords" content="@yield('keyword')">
    <meta name="description" content="@yield('description')">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <link rel="stylesheet" href="/theme/default/css/bootstrap.css" type="text/css">
    <link rel="stylesheet" href="/theme/default/css/animate.css" type="text/css">
    <link rel="stylesheet" href="/theme/default/css/font-awesome.min.css" type="text/css">
    <link rel="stylesheet" href="/theme/default/css/font.css" type="text/css">
    <link rel="stylesheet" href="/theme/default/css/app.css" type="text/css">
    <link rel="shortcut icon" href="/theme/default/images/favicon.ico">

    <!--[if lt IE 9]>
    <script src="/theme/default/js/ie/html5shiv.js"></script>
    <script src="/theme/default/js/ie/respond.min.js"></script>
    <script src="/theme/default/js/ie/excanvas.js"></script>
    <![endif]-->
</head>
<body>
<!-- header -->
<header id="header" class="navbar navbar-fixed-top bg-white box-shadow b-b b-light affix-top" data-spy="affix"
        data-offset-top="1">
    @yield('header')
</header>
<!-- / header -->
<section id="content">
    @yield('content')
</section>
<footer id="footer">
    @yield('footer')
</footer>
<div id='ana' style="display:none;">
    @yield('ana')
</div>
</body>
<script src="/theme/default/js/jquery.min.js"></script>
<script src="/theme/default/js/bootstrap.js"></script>
<script src="/theme/default/js/app.js"></script>
@yield('my-js')
</html>