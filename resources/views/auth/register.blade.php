@extends('auth.master')
@section('title','用户注册')
@section('keyword','aliyun,ECS,控制面板')
@section('description','一个简单的 Aliyun ECS 控制面板')
@section('content')
    <div class="container aside-xxl">
        <a class="navbar-brand block" href="/">{{env('APP_NAME')}}</a>
        <section class="panel panel-default m-t-lg bg-white">
            <header class="panel-heading text-center">
                <strong>注册会员</strong>
            </header>
            <div class="panel-body wrapper-lg">
                <div class="form-group">
                    <input name="_method" type="hidden" value="POST">
                </div>

                <div class="form-group">
                    <label class="control-label">Name</label>
                    <input name="name" id="name" placeholder="昵称" class="form-control input-lg" type="text">
                </div>
                <div class="form-group">
                    <label class="control-label">Email</label>
                    <input name="email" id="email" placeholder="邮箱" class="form-control input-lg" type="text">
                </div>
                <div class="form-group">
                    <label class="control-label">Password</label>
                    <input name="password" id="password" placeholder="密码(至少8位)" class="form-control input-lg"
                           type="password">
                </div>
                <div class="form-group">
                    <label class="control-label">Confirm Password</label>
                    <input name="password_confirmed" id="password_confirmed" placeholder="确认密码" class="form-control input-lg"
                           type="password">
                </div>
                <div class="form-group">
                    <label class="control-label">Validate Code</label>
                    <input name="captcha" id="captcha" placeholder="验证码" class="form-control input-lg"
                           type="text" style="vertical-align:middle;">
                    <img id="captcha_f" title="点击刷新" src="/captcha"
                         onclick="this.src = '/captcha?r=' + Math.random();"
                         style="border-radius: 2px;cursor: pointer;position: vertical-align:middle;float: right;margin-top: -46px">
                </div>
                <div class="checkbox">
                    <label>
                        <p>注册即代表同意<a href="/tos">服务条款</a>，以及保证所录入信息的真实性，如有不实信息会导致账号被删除。</p>
                    </label>
                </div>
                <button id="reg" type="submit" class="btn btn-primary" onclick="onRegisterClick();">确认注册</button>
                <div class="line line-dashed"></div>

                <div id="msg-success" class="alert alert-info alert-dismissable" style="display: none;">
                    <button type="button" class="close" id="ok-close" aria-hidden="true">×</button>
                    <h4><i class="icon fa fa-check"></i> 成功!</h4>
                    <p id="msg-success-p"></p>
                </div>

                <div id="msg-error" class="alert alert-warning alert-dismissable" style="display: none;">
                    <button type="button" class="close" id="error-close" aria-hidden="true">×</button>
                    <h4><i class="icon fa fa-times"></i> 出错了!</h4>
                    <p id="msg-error-p"></p>
                </div>


                <p class="text-muted text-center">
                    <small>已经注册过了?</small>
                </p>
                <a href="/auth/login" class="btn btn-default btn-block">返回登录</a>
            </div>
        </section>
    </div>
@endsection
@section('footer')
    <div class="text-center padder">
        <p>
            <small>使用本站服务请遵守当地法律<br>© <a href="/">{{env('APP_NAME')}}</a></small>
        </p>
    </div>
@endsection



@section('my-js')
    <script type="text/javascript">
        $("#header").remove();
        $("#content").addClass("m-t-lg wrapper-md animated fadeInUp");
    </script>
    <script type="text/javascript">
        $(document).ready(function () {
            $("#ok-close").click(function () {
                $("#msg-success").hide(100);
            });
            $("#error-close").click(function () {
                $("#msg-error").hide(100);
            });
        })
    </script>
    <script type="text/javascript">
        function onRegisterClick() {
            document.getElementById("reg").disabled = true;
            $.ajax({
                type: "POST",
                url: '/auth/register',
                dataType: 'json',
                cache: false,
                data: {
                    name: $("#name").val(),
                    email: $("#email").val(),
                    password: $("#password").val(),
                    password_confirmed: $("#password_confirmed").val(),
                    captcha: $("#captcha").val(),
                    _token: "{{csrf_token()}}"
                },
                success: function (data) {
                    if (data == null) {
                        $("#msg-error").show();
                        $("#msg-error-p").html('服务端错误');
                        document.getElementById("captcha_f").src = '/captcha?r=' + Math.random();
                        document.getElementById("reg").disabled = false;
                        return;
                    }
                    if (data.status == 0) {
                        $("#msg-error").show();
                        $("#msg-error-p").html(data.msg);
                        document.getElementById("captcha_f").src = '/captcha?r=' + Math.random();
                        document.getElementById("reg").disabled = false;
                        return;
                    }
                    $("#msg-success").show();
                    $("#msg-success-p").html('注册成功');
                    window.setTimeout("location.href='/auth/login'", 1800);
                },
                error: function (jqXHR) {
                    //console.log(JSON.parse(jqXHR.responseText));
                    $("#msg-error").show();
                    var json = JSON.parse(jqXHR.responseText);
                    $.each(json, function (index, content) {
                        $("#msg-error-p").html(content);
                        return false;
                        //console.log(content);
                    })
                    document.getElementById("captcha_f").src = '/captcha?r=' + Math.random();
                    document.getElementById("reg").disabled = false;
                }
            });

        }

    </script>

@endsection