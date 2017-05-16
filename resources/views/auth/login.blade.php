@extends('auth.master')
@section('title','用户登入')
@section('keyword','aliyun,ECS,控制面板')
@section('description','一个简单的 Aliyun ECS 控制面板')
@section('content')
<div class="container aside-xxl">
    <a class="navbar-brand block" href="/">{{env('APP_NAME')}}</a>
    <section class="panel panel-default bg-white m-t-lg">
        <header class="panel-heading text-center">
            <strong>用户登陆</strong>
        </header>

        <div class="panel-body wrapper-lg">
            <div class="form-group">
                <label class="control-label">Name</label>
                <input id="name" name="name" placeholder="用户名" class="form-control input-lg" type="text">
            </div>
            <div class="form-group">
                <label class="control-label">Password</label>
                <input id="password" name="password" placeholder="密码" class="form-control input-lg" type="password">
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
                    <input id="remember_me" value="week" type="checkbox"> 记住我
                </label>
            </div>


            <a href="/password/reset" target="_blank" class="pull-right m-t-xs">
                <small>忘记密码?</small>
            </a>
            <button id="login" type="submit" class="btn btn-primary" onclick="onLoginClick();">确认登陆</button>
            <div class="line line-dashed"></div>
            <div id="msg-success" class="alert alert-info alert-dismissable" style="display: none;">
                <button type="button" class="close" id="ok-close" aria-hidden="true">×</button>
                <h4><i class="icon fa fa-check"></i> 登录成功!</h4>
                <p id="msg-success-p"></p>
            </div>

            <div id="msg-error" class="alert alert-warning alert-dismissable" style="display: none;">
                <button type="button" class="close" id="error-close" aria-hidden="true">×</button>
                <h4><i class="icon fa fa-times"></i> 出错了!</h4>
                <p id="msg-error-p"></p>
            </div>

            <p class="text-muted text-center">
                <small>没有账号?</small>
            </p>
            <a href="/auth/register" class="btn btn-default btn-block">马上注册新账号</a>
        </div>
    </section>
</div>
@endsection
@section('footer')
<div class="text-center padder">
    <p>
        <small>使用本站服务请遵守当地法律<br>Powered by <a href="http://panel.31sky.net">Aliyun Panel</a>|<a target="_blank" href="//shang.qq.com/wpa/qunwpa?idkey=48ab85755a2e4cb3f1b09e0fa980fd0cd2df73af2ef328cc53d3406af6d04a8c"><img border="0" src="//pub.idqqimg.com/wpa/images/group.png" alt="阿里云国际代购" title="阿里云国际代购"></a></small>
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
    function getUrlParam(name) {
        var reg = new RegExp("(^|&)" + name + "=([^&]*)(&|$)"); //构造一个含有目标参数的正则表达式对象
        var r = window.location.search.substr(1).match(reg);  //匹配目标参数
        if (r != null) return unescape(r[2]);
        return null; //返回参数值
    }
    function onLoginClick() {
        document.getElementById("login").disabled = true;
        var return_url = getUrlParam('return_url');
        $.ajax({
            type: "POST",
            url: '/auth/login',
            dataType: 'json',
            cache: false,
            data: {
                name: $("#name").val(),
                password: $("#password").val(),
                captcha:$("#captcha").val(),
                return_url: return_url,
                _token: "{{csrf_token()}}"
            },
            success: function (data) {
                if (data == null) {
                    $("#msg-error").show();
                    $("#msg-error-p").html('服务端错误');
                    document.getElementById("captcha_f").src = '/captcha?r=' + Math.random();
                    document.getElementById("login").disabled = false;
                    return;
                }
                if (data.code == 0) {
                    $("#msg-error").show();
                    $("#msg-error-p").html(data.msg);
                    document.getElementById("captcha_f").src = '/captcha?r=' + Math.random();
                    document.getElementById("login").disabled = false;
                    return;
                }
                $("#msg-success").show();
                $("#msg-success-p").html(data.msg);
                window.setTimeout("location.href='" + data.return_url + "'", 1800);
            },
            error: function (jqXHR) {
                $("#msg-error").show();
                var json = JSON.parse(jqXHR.responseText);
                $.each(json, function (index, content) {
                    $("#msg-error-p").html(content);
                    return false;
                    //console.log(content);
                })
                document.getElementById("captcha_f").src = '/captcha?r=' + Math.random();
                document.getElementById("login").disabled = false;
            }
        });

    }

</script>
@endsection