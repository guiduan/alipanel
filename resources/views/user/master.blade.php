<!DOCTYPE html>
<html class="app" lang="en">
<head>
    <meta charset="utf-8">
    <title>@yield('title') -- 用户中心 -- {{$APP_NAME}}</title>
    <meta name="keywords" content="{{$KEY_WORDS}}">
    <meta name="description" content="{{$DESCRIPTION}}">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <link rel="stylesheet" href="/theme/default/css/bootstrap.css" type="text/css">
    <link rel="stylesheet" href="/theme/default/css/animate.css" type="text/css">
    <link rel="stylesheet" href="/theme/default/css/font-awesome.min.css" type="text/css">
    <link rel="stylesheet" href="/theme/default/css/font.css" type="text/css">
    <link rel="stylesheet" href="/theme/default/css/bootstrap_calendar.css" type="text/css">
    <link rel="stylesheet" href="/theme/default/css/app.css" type="text/css">
    <link rel="shortcut icon" href="/theme/default/images/favicon.ico">
    <!--[if lt IE 9]>
    <script src="/theme/default/js/ie/html5shiv.js"></script>
    <script src="/theme/default/js/ie/respond.min.js"></script>
    <script src="/theme/default/js/ie/excanvas.js"></script>
    <![endif]-->
</head>
<body>
<section class="vbox">
    <header class="bg-dark dk header navbar navbar-fixed-top-xs">
        <div class="navbar-header aside-md">
            <a class="btn btn-link visible-xs" data-toggle="class:nav-off-screen,open" data-target="#nav,html">
                <i class="fa fa-bars"></i>
            </a>
            <a href="/user" class="navbar-brand"><img src="/theme/default/images/logo.png"
                                                            class="m-r-sm">{{env('APP_NAME')}}</a>
            <a class="btn btn-link visible-xs" data-toggle="dropdown" data-target=".nav-user">
                <i class="fa fa-cog"></i>
            </a>
        </div>

        <ul class="nav navbar-nav navbar-right m-n hidden-xs nav-user">


            <li class="dropdown">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                            <span class="thumb-sm avatar pull-left">
                                <img src="/theme/default/images/avatar.jpg">
                            </span>
                    {{$user->name}} <b class="caret"></b>
                </a>
                <ul class="dropdown-menu animated fadeInRight">
                    <span class="arrow top"></span>
                    <li>
                        <a href="/user">用户概况</a>
                    </li>
                    <li>
                        <a href="/user/instance">实例列表</a>
                    </li>
                    <li>
                        <a href="/user/bindinstance">绑定实例
                        </a>
                    </li>
                    <li class="divider"></li>
                    <li>
                        <a href="/user/logout">退出登录</a>
                    </li>
                </ul>
            </li>
        </ul>
    </header>
    <section>
        <section class="hbox stretch">
            <!-- .aside -->
            <aside class="bg-dark lter aside-md hidden-print" id="nav">
                <section class="vbox">
                    <header class="header bg-primary lter text-center clearfix">
                        <div class="btn-group">
                            <button type="button" class="btn btn-sm btn-dark btn-icon" title="New project"><i
                                        class="fa fa-plus"></i></button>
                            <div class="btn-group hidden-nav-xs">
                                <button type="button" class="btn btn-sm btn-primary dropdown-toggle"
                                        data-toggle="dropdown">
                                    联系客服
                                    <span class="caret"></span>
                                </button>
                                <ul class="dropdown-menu text-left">
                                    <li><a href="#">QQ在线</a></li>
                                </ul>
                            </div>
                        </div>
                    </header>
                    <section class="w-f scrollable">
                        <div class="slim-scroll" data-height="auto" data-disable-fade-out="true" data-distance="0"
                             data-size="5px" data-color="#333333">

                            <!-- nav -->
                            <nav class="nav-primary hidden-xs">
                                <ul class="nav">
                                    <li class="">
                                        <a href="/user" class="">
                                            <i class="fa fa-th-large icon">
                                                <b class="bg-danger"></b>
                                            </i>
                                            <span>用户概况</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="/user/instance">
                                            <i class="fa fa-columns icon">
                                                <b class="bg-warning"></b>
                                            </i>

                                            <span>实例列表</span>
                                        </a>

                                    </li>
                                    <li>
                                        <a href="/user/bindinstance">
                                            <i class="fa fa-hand-o-right icon">
                                                <b class="bg-success"></b>
                                            </i>

                                            <span>绑定实例</span>
                                        </a>

                                    </li>
                                    @if($user->is_admin==1)
                                        <li>
                                            <a href="/admin">
                                                <i class="fa fa-hand-o-right icon">
                                                    <b class="bg-warning"></b>
                                                </i>
                                                <span>管理面板</span>
                                            </a>
                                        </li>
                                    @endif
                                </ul>
                            </nav>
                            <!-- / nav -->
                        </div>
                    </section>

                    <footer class="footer lt hidden-xs b-t b-dark">


                        <a href="#nav" data-toggle="class:nav-xs" class="pull-right btn btn-sm btn-dark btn-icon">
                            <i class="fa fa-angle-left text"></i>
                            <i class="fa fa-angle-right text-active"></i>
                        </a>

                    </footer>
                </section>
            </aside>
            <!-- /.aside -->
            <section id="content">
                @yield('content')
            </section>

        </section>
    </section>
</section>
<div aria-labelledby="waModalLable" role="dialog" id="waModal" class="modal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button aria-label="Close" data-dismiss="modal" class="close" type="button"><span aria-hidden="true">×</span></button>
                <h4 class="modal-title">Modal title</h4>
            </div>
            <div class="modal-body"></div>
            <div class="modal-footer">
                <button class="btn" data-dismiss="modal" aria-hidden="true">关闭</button>
            </div>
        </div>
    </div>
</div>
<div style="display:none;">
    @yield('ana')
</div>
</body>
<script src="/assets/public/js/jquery.min.js"></script>
<script src="/assets/public/js/jquery.qrcode.min.js"></script>
<script src="/assets/public/js/bootstrap.js"></script>
<script src="/assets/public/js/app.js"></script>
<script src="/assets/public/plugins/slimScroll/jquery.slimscroll.min.js"></script>
<script src="/assets/public/js/ZeroClipboard.min.js"></script>
@yield('my-js')
</html>