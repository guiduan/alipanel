@extends('user.master')
@section('title','用户概况')
@section('content')
    <section class="vbox">
        <section class="scrollable wrapper">
            <div class="row">
                <div class="col-lg-12">
                    <!-- .breadcrumb -->
                    <ul class="breadcrumb">
                        <li><a href="/"><i class="fa fa-home"></i> Home</a></li>
                        <li class="active">用户概况</li>
                    </ul>
                    <!-- / .breadcrumb -->
                </div>
            </div>


            <div class="row">
                <div class="col-lg-12">
                    <div class="row">
                        <div class="col-sm-12">
                            <section class="panel panel-default">
                                <header class="panel-heading bg-success lt no-border">
                                    <div class="clearfix">
                                        <a class="pull-left thumb avatar b-3x m-r">
                                            <img src="{{$user->getGravatarAttribute()}}" class="img-circle">
                                        </a>
                                        <div class="clear">
                                            <div class="h3 m-t-xs m-b-xs text-white">
                                                {{$user->name}}
                                                <i class="fa fa-circle text-white pull-right text-xs m-t-sm"></i>
                                            </div>
                                            <small class="text-muted">{{$user->email}}</small>
                                            &nbsp;
                                            @if($user->verified)
                                                <span class="badge bg-info">邮箱已验证</span>
                                            @else
                                                <a id="verify_email" class="badge bg-danger" title="点击发送邮箱验证码">邮箱未验证</a>
                                            @endif
                                        </div>
                                    </div>
                                </header>

                                <div class="list-group no-radius alt">
                                    <a class="list-group-item">
                                        <span class="badge bg-success">
                                            @if($user->enable)
                                                正常
                                            @else
                                                异常
                                            @endif
                                        </span>
                                        <i class="fa fa-comment icon-muted"></i>
                                        账号状态：
                                    </a>
                                    <a class="list-group-item">
                                        <span class="badge bg-success">{{$user->money}}</span>
                                        <i class="fa fa-comment icon-muted"></i>
                                        账号余额：
                                    </a>
                                    <a class="list-group-item">
                                        <span class="badge bg-warning">{{$user->getInstanceNum()}}</span>
                                        <i class="fa fa-eye icon-muted"></i>
                                        实例数量
                                    </a>
                                    <a class="list-group-item">
                                        <span class="badge bg-dark">{{$user->created_at}}</span>
                                        <i class="fa fa-rocket icon-muted"></i>
                                        注册时间
                                    </a>

                                </div>
                            </section>
                        </div>
                    </div>
                </div>
            </div>

        </section>
    </section>
    <a href="#" class="hide nav-off-screen-block" data-toggle="class:nav-off-screen" data-target="#nav"></a>
@endsection