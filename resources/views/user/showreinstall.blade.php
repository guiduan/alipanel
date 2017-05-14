<div class="form-group">
    <input id="instanceid" value="{{$instanceid}}" type="hidden"></input>
</div>
<div class="form-group">
    <select id="imageid" class="form-control input-lg">
        @foreach($images as $image)
            <option value="{{$image->imageid}}">{{$image->imagename}}</option>
        @endforeach
    </select>
</div>
<hr class="colorgraph">
<div id="msg-success" class="alert alert-info alert-dismissable" style="display: none;">
    <button type="button" class="close" id="ok-close" aria-hidden="true">×</button>
    <h4><i class="icon fa fa-check"></i> 重装系统成功!</h4>
    <p id="msg-success-p"></p>
</div>
<div id="msg-error" class="alert alert-warning alert-dismissable" style="display: none;">
    <button type="button" class="close" id="error-close" aria-hidden="true">×</button>
    <h4><i class="icon fa fa-times"></i> 出错了!</h4>
    <p id="msg-error-p"></p>
</div>
<div class="row" style="margin-top:20px">
    <div class="col-xs-12 col-sm-12 col-md-12">
        <input type="submit" id="reinstall" class="btn btn-lg btn-success btn-block" value="重装系统">
    </div>
</div>
<script>
    $(document).ready(function () {
        function reinstall() {
            document.getElementById("reinstall").disabled = true;
            $.ajax({
                type: "POST",
                url: "/user/instancehandle",
                dataType: "json",
                data: {
                    action: 'replacesystemdisk',
                    instanceid: $("#instanceid").val(),
                    imageid: $("#imageid").val(),
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
                        document.getElementById("reinstall").disabled = false;
                    }
                },
                error: function (res) {
                    console.log(res.status);
                    document.getElementById("reinstall").disabled = false;
                }
            });
        }

        $("#reinstall").click(function () {
            reinstall();
        });
        $("#ok-close").click(function () {
            $("#msg-success").hide(100);
        });
        $("#error-close").click(function () {
            $("#msg-error").hide(100);
        });
    });
</script>