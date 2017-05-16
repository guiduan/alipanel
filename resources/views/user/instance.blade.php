@extends('user.master')
@section('title','实例列表')
@section('content')
    <section class="vbox">
        <section class="scrollable wrapper">
            <div class="row">
                <div class="col-lg-12">
                    <!-- .breadcrumb -->
                    <ul class="breadcrumb">
                        <li><a href="/"><i class="fa fa-home"></i> Home</a></li>
                        <li class="active">实例列表</li>
                    </ul>
                    <!-- / .breadcrumb -->
                </div>
            </div>

            <div class="row">
                <div class="col-md-12">
                    <section class="panel panel-default">
                        <header class="panel-heading font-bold">实例列表说明<span class="panel-default pull-right"
                                                                            id="shuoming">点击隐藏</span></header>
                        <div class="panel-body" id="shuomingcontent">
                            <article class="media">
                                <div class="media-body">
                                    <span class="h5">
                                        1、请确保实例状态为 Stopped 时，才能进行“开机”操作<br>
                                        2、请确保实例状态为 Running 时，才能进行“关机”、“重启”操作<br><br>
                                    </span>
                                </div>
                            </article>
                        </div>
                    </section>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <section class="panel panel-default">
                        <div class="box box-solid">
                            <div class="box-body table-responsive no-padding">
                                <table class="table table-hover">
                                    <thead>
                                    <tr>
                                        <th>实例ID</th>
                                        <th>区域</th>
                                        <th>外网IP</th>
                                        <th>内网IP</th>
                                        <th>创建日期</th>
                                        <th>到期日期</th>
                                        <th>实例状态</th>
                                        <th>带宽</th>
                                        <th>操作</th>
                                    </tr>
                                    </thead>
                                    <tbody id="info">
                                    @foreach($instances as $instance)
                                        <tr id="{{$instance['InstanceId']}}">
                                            <td class="name">{{$instance['InstanceId']}}</td>
                                            <td class="zoneid">{{$instance['ZoneId']}}</td>
                                            <td class="paddr">{{$instance['PublicIpAddress']->IpAddress[0]}}</td>
                                            <td class="iaddr">{{$instance['VpcAttributes']->PrivateIpAddress->IpAddress[0]}}</td>
                                            <td class="ctime">{{$instance['CreationTime']}}</td>
                                            <td class="etime"><font
                                                        color="@if($instance['ExpiredTime'] < date('Y-m-d\TH:i\Z') )red @endif">{{$instance['ExpiredTime']}}</font>
                                            </td>
                                            <td class="status">{{$instance['Status']}}</td>
                                            <td class="maxb">{{$instance['InternetMaxBandwidthOut']}} M</td>
                                            <td>
                                                <div class='btn-group btn-group-sm'>
                                                    <button type='button' class='btn btn-primary dropdown-toggle'
                                                            data-toggle='dropdown'>操作<span class='caret'></span>
                                                    </button>
                                                    <ul class='dropdown-menu' role='menu'>
                                                        <li>
                                                            <a href='javascript:showContent("开机/关机/重启","/user/showstart?instanceid={{$instance['InstanceId']}}");'>开机/关机/重启</a>
                                                        </li>
                                                        <li class='divider'></li>
                                                        <li>
                                                            <a href='javascript:showContent("实例详情","/user/showinstancedetail?instanceid={{$instance['InstanceId']}}");'>实例详情</a>
                                                        </li>
                                                        <li class='divider'></li>
                                                        <li>
                                                            <a href='javascript:showContent("重置密码","/user/showchangepwd?instanceid={{$instance['InstanceId']}}");'>重置密码</a>
                                                        </li>
                                                        <li>
                                                            <a href='javascript:showContent("重装系统","/user/showreinstall?instanceid={{$instance['InstanceId']}}");'>重装系统</a>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </td>

                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
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
            $("#shuoming").click(function () {
                if (document.getElementById("shuoming").innerText == '点击隐藏') {
                    $("#shuomingcontent").hide();
                    $("#shuoming").html("点击显示");
                }
                else {
                    $("#shuomingcontent").show();
                    $("#shuoming").html("点击隐藏");
                }
            });
        })
    </script>
    <script>
        function check() {
            $.ajax({
                type: "GET",
                url: "/user/getlistinstancejson",
                dataType: "json",
                success: function (data) {
                    if (data.success) {
                        var count = data.list.length;
                        for (i = 0; i < count; i++) {
                            var tag = '#' + data.list[i].InstanceId;
                            $("tr" + tag + " .name").html(data.list[i].InstanceId);
                            $("tr" + tag + " .status").html(data.list[i].Status);
                            /**
                             var dom = +"<tr id='" + data.list[i].InstanceId + "'><td>" + data.list[i].InstanceName + "</td><td>" + data.list[i].PublicIpAddress.IpAddress + "</td><td>" + data.list[i].VpcAttributes.PrivateIpAddress.IpAddress + "</td><td>" + data.list[i].CreationTime + "</td><td>" + data.list[i].ExpiredTime + "</td><td>" + data.list[i].Status + "</td><td>" + data.list[i].InternetMaxBandwidthOut + "</td><td><div class='btn-group btn-group-sm'><button type='button' class='btn btn-primary dropdown-toggle' data-toggle='dropdown'>操作<span class='caret'></span></button><ul class='dropdown-menu' role='menu'><li><a href='javascript:start(\"" + data.list[i].InstanceId + "\");'>开机</a></li><li><a href='javascript:stop(\"" + data.list[i].InstanceId + "\");'>关机</a></li><li><a href='javascript:reboot(\"" + data.list[i].InstanceId + "\");'>重启</a></li><li class='divider'></li><li><a href='javascript:showContent(\"重装系统\",\"/user/showreinstall?instanceid=" + data.list[i].InstanceId + "\");'>重装系统</a></li></ul></div></td></tr>";

                             var tag = '#' + data.list[i].InstanceId;
                             if (!$(tag).length) {
                                $("#info").append(dom);
                            }

                             $("#info").html(dom);
                             **/
                        }

                    } else {
                        alert('error');
                    }
                },
                error: function (res) {
                    console.log(res.status);
                }
            });
        }
        window.setInterval(check, 2000); //每秒执行一次
    </script>
    <script>
        function showContent(title, url) {
            $('#waModal').modal('show');
            $('#waModal .modal-title').text(title);
            $.get(url, {t: new Date().getTime()}, function (data) {
                $('#waModal .modal-body').html(data);
            });
        }
    </script>
@endsection
