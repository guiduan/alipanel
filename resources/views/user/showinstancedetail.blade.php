实例型号：{{$instance->InstanceType}}<br>
CPU数量：{{$instance->Cpu}}<br>
内存：{{$instance->Memory}}<br>
磁盘镜像：{{$instance->ImageId}}<br>
带宽：{{$instance->InternetMaxBandwidthOut}} M<br>
区域：{{$instance->RegionId}}<br>
内网IP：{{$instance->VpcAttributes->PrivateIpAddress->IpAddress[0]}}<br>
外网IP：{{$instance->PublicIpAddress->IpAddress[0]}}<br>