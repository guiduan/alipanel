@extends('user.master')
@section('title','绑定实例')
@section('content')
    <section class="vbox">
        <section class="scrollable wrapper">
            <div class="row">
                <div class="col-lg-12">
                    <!-- .breadcrumb -->
                    <ul class="breadcrumb">
                        <li><a href="/"><i class="fa fa-home"></i> Home</a></li>
                        <li class="active">绑定实例</li>
                    </ul>
                    <!-- / .breadcrumb -->
                </div>
            </div>

            <div class="row">
                <div class="col-sm-12">
                    <section class="panel panel-default">
                        <header class="panel-heading font-bold">绑定实例</header>

                        <div class="panel-body">

                            <div class="form-group">
                                <label>实例 ID</label>
                                <input class="form-control" placeholder="请输入实例 ID" id="instanceid" type="text">
                            </div>
                            <button type="submit" id="bind" class="btn btn-primary">绑定</button>
                        </div>
                    </section>
                </div>
            </div>


        </section>
    </section>
    <a href="#" class="hide nav-off-screen-block" data-toggle="class:nav-off-screen" data-target="#nav"></a>
@endsection

@section('my-js')
    <script>
        $(document).ready(function () {
            $("#bind").click(function () {
                $("#bind").text("正在绑定...");
                document.getElementById("bind").disabled = true;
                $.ajax({
                    type: "POST",
                    url: "/user/bindinstance",
                    dataType: "json",
                    data: {
                        instanceid: $("#instanceid").val(),
                        _token: '{{csrf_token()}}'
                    },
                    success: function (data) {
                        if (data.code) {
                            $('#waModal').modal('show');
                            $('#waModal .modal-title').text('提示信息');
                            $('#waModal .modal-body').html(data.msg);
                            window.setTimeout("location.href='/user/instance'", 1800);
                        } else {
                            $('#waModal').modal('show');
                            $('#waModal .modal-title').text('提示信息');
                            $('#waModal .modal-body').html(data.msg);
                            $("#bind").text("绑定");
                            document.getElementById("bind").disabled = false;
                        }
                    },
                    error: function (jqXHR) {
                        $("#bind").text("绑定");
                        document.getElementById("bind").disabled = false;
                        console.log(jqXHR.status);
                    }
                })
            })
        })
    </script>
@endsection