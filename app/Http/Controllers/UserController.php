<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Instance;
use App\User;
use App\Image;
use Illuminate\Http\Request;

use Ecs\Request\V20140526 as Ecs;
use Illuminate\Http\Response;

class UserController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    private $user;

    public function __construct(Request $request)
    {
        $id = $request->session()->get('user')->id;
        //$id = 3;
        $this->user = User::where('id', $id)->first();
        $this->iClientProfile = \DefaultProfile::getProfile(env('ALI_REGION_ID'), env('ALI_ID'), env('ALI_SECRET'));
        $this->client = new \DefaultAcsClient($this->iClientProfile);
    }


    public function index()
    {
        $iClientProfile = \DefaultProfile::getProfile(env('ALI_REGION_ID'), env('ALI_ID'), env('ALI_SECRET'));
        $client = new \DefaultAcsClient($iClientProfile);

        //$request = new Ecs\DescribeInstanceAttributeRequest();
        $request = new Ecs\DescribeInstanceStatusRequest();
        $request->setMethod("GET");
        $request->setInstanceId("i-t4n6nhmb5r19qqreorla");
        //$request->setInstanceName("aaa");
        $response = $client->getAcsResponse($request);
        return $response;
    }

    public function profile(Request $request)
    {
        $user = $this->user;

        return view('user.profile', ['user' => $user,]);
    }

    public function listInstance()
    {
        $user = $this->user;
        $instances = Instance::where('uid', $user->id)->get();
        $instances_arr = [];
        foreach ($instances as $instance) {
            $instanceid = $instance->instanceid;
            //$iClientProfile = \DefaultProfile::getProfile(env('ALI_REGION_ID'), env('ALI_ID'), env('ALI_SECRET'));
            //$client = new \DefaultAcsClient($iClientProfile);
            $client = $this->client;
            $rqt = new Ecs\DescribeInstanceAttributeRequest();
            $rqt->setMethod("GET");
            $rqt->setInstanceId($instanceid);
            $rps = $client->getAcsResponse($rqt);

            $instances_arr[] = (array)$rps;
        }
        //dd($instances_arr);
        return view('user.instance', ['user' => $user, 'instances' => $instances_arr]);
    }

    public function showReinstall(Request $request)
    {
        $user = $this->user;
        $instanceid = $request->input('instanceid', '');
        $images = Image::where('uid', 0)->orWhere('uid', $user->id)->get();
        return view('user.showreinstall', ['images' => $images, 'instanceid' => $instanceid]);
    }

    public function showChangePwd(Request $request)
    {
        $instanceid = $request->input('instanceid', '');
        return view('user.showchangepwd', ['instanceid' => $instanceid]);
    }

    public function showInstanceDetail(Request $request)
    {
        $instanceid = $request->input('instanceid', '');
        //$iClientProfile = \DefaultProfile::getProfile(env('ALI_REGION_ID'), env('ALI_ID'), env('ALI_SECRET'));
        //$client = new \DefaultAcsClient($iClientProfile);
        $client = $this->client;
        $rqt = new Ecs\DescribeInstanceAttributeRequest();
        $rqt->setMethod("GET");
        $rqt->setInstanceId($instanceid);
        $rps = $client->getAcsResponse($rqt);

        return view('user.showinstancedetail', ['instance' => $rps]);
    }

    public function showStart(Request $request)
    {
        $instanceid = $request->input('instanceid', '');

        return view('user.showstart', ['instanceid' => $instanceid]);
    }

    public function getListInstanceJson(Request $request)
    {
        $user = $this->user;
        $instances = Instance::where('uid', $user->id)->get();
        $instances_arr = [];
        foreach ($instances as $instance) {
            $instanceid = $instance->instanceid;
            //$iClientProfile = \DefaultProfile::getProfile(env('ALI_REGION_ID'), env('ALI_ID'), env('ALI_SECRET'));
            //$client = new \DefaultAcsClient($iClientProfile);
            $client = $this->client;
            $rqt = new Ecs\DescribeInstanceAttributeRequest();
            $rqt->setMethod("GET");
            $rqt->setInstanceId($instanceid);
            $rps = $client->getAcsResponse($rqt);

            $instances_arr[] = (array)$rps;
        }
        $instances_arr_a['list'] = $instances_arr;
        $instances_arr_a['success'] = true;

        return response()->json($instances_arr_a);

    }

    public function instanceHandle(Request $request)
    {
        //$iClientProfile = \DefaultProfile::getProfile(env('ALI_REGION_ID'), env('ALI_ID'), env('ALI_SECRET'));
        //$client = new \DefaultAcsClient($iClientProfile);
        $client = $this->client;

        $action = $request->input('action', '');
        if ($action == '') {
            $ret['code'] = 0;
            $ret['msg'] = 'action 不能为空';
            return response()->json($ret);
        }

        switch ($action) {
            case 'startinstance':
                $instanceId = $request->input('instanceid', '');
                if ($instanceId == '') {
                    $ret['code'] = 0;
                    $ret['msg'] = 'instance id 不能为空';
                    return response()->json($ret);
                }
                $rqt = new Ecs\StartInstanceRequest();
                $rqt->setMethod("GET");
                $rqt->setInstanceId($instanceId);
                $rps = $client->getAcsResponse($rqt);
                if ($rps == 'false') {
                    $ret['code'] = 0;
                    $ret['msg'] = '启动实例失败';
                    return response()->json($ret);
                }
                $ret['code'] = 1;
                $ret['msg'] = '启动实例成功';
                $ret['response'] = $rps;
                return response()->json($ret);
                break;
            case 'stopinstance':
                $instanceId = $request->input('instanceid', '');
                if ($instanceId == '') {
                    $ret['code'] = 0;
                    $ret['msg'] = 'instance id 不能为空';
                    return response()->json($ret);
                }
                $rqt = new Ecs\StopInstanceRequest();
                $rqt->setMethod("GET");
                $rqt->setInstanceId($instanceId);
                $rps = $client->getAcsResponse($rqt);
                if ($rps == 'false') {
                    $ret['code'] = 0;
                    $ret['msg'] = '停止实例失败';
                    return response()->json($ret);
                }
                $ret['code'] = 1;
                $ret['msg'] = '停止实例成功';
                $ret['response'] = $rps;
                return response()->json($ret);
                break;
            case 'rebootinstance':
                $instanceId = $request->input('instanceid', '');
                if ($instanceId == '') {
                    $ret['code'] = 0;
                    $ret['msg'] = 'instance id 不能为空';
                    return response()->json($ret);
                }
                $forceStop = $request->input('forcestop', false);
                $rqt = new Ecs\RebootInstanceRequest();
                $rqt->setMethod("GET");
                $rqt->setInstanceId($instanceId);
                $rqt->setForceStop($forceStop);
                $rps = $client->getAcsResponse($rqt);
                if ($rps == 'false') {
                    $ret['code'] = 0;
                    $ret['msg'] = '重启实例失败';
                    return response()->json($ret);
                }
                $ret['code'] = 1;
                $ret['msg'] = '重启实例成功';
                $ret['response'] = $rps;
                return response()->json($ret);
                break;

            case 'modifyinstance':
                $instanceId = $request->input('instanceid', '');
                if ($instanceId == '') {
                    $ret['code'] = 0;
                    $ret['msg'] = 'instance id 不能为空';
                    return response()->json($ret);
                }
                $password = $request->input('password', '');
                if (!preg_match('/^(?=.*[0-9].*)(?=.*[A-Z].*)(?=.*[a-z].*).{8,30}$/', $password)) {
                    $ret['code'] = 0;
                    $ret['msg'] = '8-30个字符，必须同时包含三项（大、小写字母，数字和( ) ` ~ ! @ # $ % ^ & * - + = | { } [ ] : ; \' < > , . ? / 中的特殊符号）。';
                    return response()->json($ret);
                }
                $rqt = new Ecs\ModifyInstanceAttributeRequest();
                $rqt->setMethod("GET");
                $rqt->setInstanceId($instanceId);
                $rqt->setPassword($password);
                $rps = $client->getAcsResponse($rqt);
                if ($rps == 'false') {
                    $ret['code'] = 0;
                    $ret['msg'] = '修改实例密码失败';
                    $ret['response'] = $rps;
                    return response()->json($ret);
                }
                $ret['code'] = 1;
                $ret['msg'] = '修改实例密码成功，注意：重启后生效';
                $ret['response'] = $rps;
                return response()->json($ret);
                break;
            case 'replacesystemdisk':
                $instanceId = $request->input('instanceid', '');
                if ($instanceId == '') {
                    $ret['code'] = 0;
                    $ret['msg'] = 'instance id 不能为空';
                    return response()->json($ret);
                }
                $imageid = $request->input('imageid', '');
                if ($imageid == '') {
                    $ret['code'] = 0;
                    $ret['msg'] = 'imageid 不能为空';
                    return response()->json($ret);
                }
                $rqt = new Ecs\ReplaceSystemDiskRequest();
                $rqt->setMethod("GET");
                $rqt->setInstanceId($instanceId);
                $rqt->setImageId($imageid);
                $rps = $client->getAcsResponse($rqt);
                if ($rps == 'false') {
                    $ret['code'] = 0;
                    $ret['msg'] = '重装系统失败';
                    $ret['response'] = $rps;
                    return response()->json($ret);
                }
                $ret['code'] = 1;
                $ret['msg'] = '重装系统成功';
                $ret['response'] = $rps;
                return response()->json($ret);
                break;

            default:
                $ret['code'] = 0;
                $ret['msg'] = 'action不存在';
                return response()->json($ret);
                break;

        }
    }

    public function getBindInstance()
    {
        $user = $this->user;
        return view('user.bind', ['user' => $user]);
    }

    public function bindInstance(Request $request)
    {
        $user = $this->user;
        $instanceid = $request->input('instanceid', '');
        if ('' == $instanceid) {
            $ret['code'] = 0;
            $ret['msg'] = 'instanceid 不能为空';
            return response()->json($ret);
        }
        $instance = Instance::where('instanceid', $instanceid)->first();
        if (null != $instance) {
            $ret['code'] = 0;
            $ret['msg'] = '该实例已经被绑定';
            return response()->json($ret);
        }

        //$iClientProfile = \DefaultProfile::getProfile(env('ALI_REGION_ID'), env('ALI_ID'), env('ALI_SECRET'));
        //$client = new \DefaultAcsClient($iClientProfile);
        $client = $this->client;
        $rqt = new Ecs\DescribeInstanceAttributeRequest();
        $rqt->setMethod("GET");
        $rqt->setInstanceId($instanceid);
        $rps = $client->getAcsResponse($rqt);
        if ($rps == 'false') {
            $ret['code'] = 0;
            $ret['msg'] = '实例 ID 错误';
            return response()->json($ret);
        }

        $instance = new Instance();
        $instance->uid = $user->id;
        $instance->instanceid = $instanceid;
        if ($instance->save()) {
            $ret['code'] = 1;
            $ret['msg'] = '绑定实例成功';
            return response()->json($ret);
        }
    }

    public function logout(Request $request)
    {
        $request->session()->flush();
        return redirect('/auth/login');
    }


}
