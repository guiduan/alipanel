<div class="form-group">
    <input id="instanceid" value="{{$instanceid}}" type="hidden"></input>
</div>
<div class="form-group">
    <input id="password" name="password" type="password" class="form-control input-lg"></input>
</div>
<hr class="colorgraph">
<div id="msg-success" class="alert alert-info alert-dismissable" style="display: none;">
    <button type="button" class="close" id="ok-close" aria-hidden="true">×</button>
    <h4><i class="icon fa fa-check"></i> 修改密码成功!</h4>
    <p id="msg-success-p"></p>
</div>
<div id="msg-error" class="alert alert-warning alert-dismissable" style="display: none;">
    <button type="button" class="close" id="error-close" aria-hidden="true">×</button>
    <h4><i class="icon fa fa-times"></i> 出错了!</h4>
    <p id="msg-error-p"></p>
</div>
<div class="row" style="margin-top:20px">
    <div class="col-xs-12 col-sm-12 col-md-12">
        <input type="submit" id="changepwd" class="btn btn-lg btn-success btn-block" value="重置密码">
    </div>
</div>
<script>
    $(document).ready(function () {
        function changepwd() {
            document.getElementById("changepwd").disabled = true;
            $.ajax({
                type: "POST",
                url: "/user/instancehandle",
                dataType: "json",
                data: {
                    action: 'modifyinstance',
                    instanceid: $("#instanceid").val(),
                    password: $("#password").val(),
                    _token: '{{csrf_token()}}'
                },
                success: function (data) {
                    if (data.code) {
                        $("#msg-error").hide(100);
                        $("#msg-success").show(100);
                        $("#msg-success-p").html(data.msg);
                    } else {
                        $("#msg-success").hide(100);
                        $("#msg-error").show(100);
                        $("#msg-error-p").html(data.msg);
                        document.getElementById("changepwd").disabled = false;
                    }
                },
                error: function (res) {
                    console.log(res.status);
                    document.getElementById("changepwd").disabled = false;
                }
            });
        }

        $("#changepwd").click(function () {
            changepwd();
        });
        $("#ok-close").click(function () {
            $("#msg-success").hide(100);
        });
        $("#error-close").click(function () {
            $("#msg-error").hide(100);
        });
    });
</script>