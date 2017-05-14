<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\User;
use App\Loginlog;
use App\Tools\Hash;

class AuthController extends Controller
{

    public function register()
    {
        return view('auth.register');
    }

    public function registerHandle(Request $request)
    {
        $captcha = $request->input('captcha', '');
        $captcha = strtolower($captcha);

        $captcha_session = $request->session()->get('captcha', '');
        if ('' == $captcha || $captcha != $captcha_session) {
            $ret['code'] = 0;
            $ret['status'] = false;
            $ret['msg'] = "验证码不正确";
            return response()->json($ret);
        }

        $name = $request->input('name', '');
        if (!preg_match('/^[a-zA-Z0-9]{4,10}$/i', $name)) {
            $ret['code'] = 0;
            $ret['status'] = false;
            $ret['msg'] = '用户名必须为4至10位应为字符';
            return response()->json($ret);
        }
        $email = $request->input('email', '');
        $email = strtolower($email);
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $ret['code'] = 0;
            $ret['status'] = false;
            $ret['msg'] = '用户邮箱格式不正确';
            return response()->json($ret);
        }

        $password = $request->input('password', '');
        if (strlen($password) < 8) {
            $ret['code'] = 0;
            $ret['status'] = false;
            $ret['msg'] = "密码太短";
            return response()->json($ret);
        }
        $password_confirmed = $request->input('password_confirmed', '');
        if ($password != $password_confirmed) {
            $ret['code'] = 0;
            $ret['status'] = false;
            $ret['msg'] = "两次输入的密码不一致";
            return response()->json($ret);
        }
        $user_email = User::where('email', $email)->first();
        if ($user_email != null) {
            $ret['code'] = 0;
            $ret['status'] = false;
            $ret['msg'] = "邮箱已经被注册了";
            return response()->json($ret);
        }
        $user_name = User::where('name', $name)->first();
        if ($user_name != null) {
            $ret['code'] = 0;
            $ret['status'] = false;
            $ret['msg'] = "用户名已经被注册了";
            return response()->json($ret);
        }

        $user = new User();
        $user->name = $name;
        $user->email = $email;
        $user->password = Hash::passwordHash($password);

        if ($user->save()) {
            $ret['code'] = 1;
            $ret['status'] = true;
            $ret['msg'] = "注册成功";
            return response()->json($ret);
        }
    }
    public function login(Request $request)
    {
        return view('auth.login');
    }

    public function loginHandle(Request $request)
    {
        $name = $request->input('name', '');
        $password = $request->input('password', '');
        $return_url = $request->input('return_url', '');
        $captcha = $request->input('captcha', '');
        $captcha = strtolower($captcha);

        $captcha_session = $request->session()->get('captcha', '');
        if ('' == $captcha || $captcha != $captcha_session) {
            $ret['code'] = 0;
            $ret['status'] = false;
            $ret['msg'] = "验证码不正确";
            return response()->json($ret);
        }
        $user = User::where('name', $name)->first();
        if ($user == null) {
            $ret['code'] = 0;
            $ret['status'] = false;
            $ret['msg'] = "401 用户名或者密码错误！";
            return response()->json($ret);
        }
        if ($user->enable == 0) {
            $ret['code'] = 0;
            $ret['status'] = false;
            $ret['msg'] = "账户被暂停，请联系管理员！";
            return response()->json($ret);
        }
        if (!Hash::checkPassword($user->password, $password)) {
            $loginlog = new Loginlog();
            $loginlog->ip = $_SERVER["REMOTE_ADDR"];
            $loginlog->uid = $user->id;
            $loginlog->type = 1;
            $loginlog->save();

            $ret['code'] = 0;
            $ret['status'] = false;
            $ret['msg'] = "用户名或者密码不正确";
            return response()->json($ret);
        }

        if ($user->is_admin) {
            $request->session()->put('admin', $user);
        } else {
            $request->session()->put('user', $user);
        }
        $ret['code'] = 1;
        $ret['status'] = true;
        $ret['msg'] = '登陆成功，欢迎回来。';
        $ret['return_url'] = $return_url == '' ? '/user' : $return_url;

        $loginlog = new LoginLog();
        $loginlog->ip = $_SERVER["REMOTE_ADDR"];
        $loginlog->uid = $user->id;
        $loginlog->type = 0;
        $loginlog->save();
        return response()->json($ret);
    }

}
