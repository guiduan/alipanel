<div class="form-group">
    <input id="instanceid" value="{{$instanceid}}" type="hidden"></input>
</div>
<div class="form-group">
    <label class="checkbox-inline">
        <input type="radio" name="action" id="action1" value="startinstance" checked> 开机
    </label>
    <label class="checkbox-inline">
        <input type="radio" name="action" id="action2"  value="stopinstance"> 关机
    </label>
    <label class="checkbox-inline">
        <input type="radio" name="action" id="action3"  value="rebootinstance"> 重启
    </label>
</div>
<hr class="colorgraph">
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
<div class="row" style="margin-top:20px">
    <div class="col-xs-12 col-sm-12 col-md-12">
        <input type="submit" id="kaiguanji" class="btn btn-lg btn-success btn-block" value="确定">
    </div>
</div>
<script>
    $(document).ready(function () {
        function kaiguanji() {
            document.getElementById("kaiguanji").disabled = true;
            $.ajax({
                type: "POST",
                url: "/user/instancehandle",
                dataType: "json",
                data: {
                    action: $('input:radio:checked').val(),
                    instanceid: $("#instanceid").val(),
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
                        document.getElementById("kaiguanji").disabled = false;
                    }
                },
                error: function (res) {
                    console.log(res.status);
                    document.getElementById("kaiguanji").disabled = false;
                }
            });
        }

        $("#kaiguanji").click(function () {
            kaiguanji();
        });
        $("#ok-close").click(function () {
            $("#msg-success").hide(100);
        });
        $("#error-close").click(function () {
            $("#msg-error").hide(100);
        });
    });
</script>