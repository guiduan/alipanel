<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Password;
use App\Tools\Hash;
use App\Tools\Mail;
use App\Tools\Tool;
use App\User;
use Illuminate\Http\Request;

class PasswordController extends Controller
{

    public function reset()
    {
        return view('password.reset', []);
    }

    public function resetHandle(Request $request)
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

        $email = $request->input('email', '');
        $email = strtolower($email);
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $ret['code'] = 0;
            $ret['status'] = false;
            $ret['msg'] = '用户邮箱格式不正确';
            return response()->json($ret);
        }

        $user = User::where('email', $email)->first();
        if (null == $user) {
            $ret['code'] = 0;
            $ret['status'] = false;
            $ret['msg'] = '用户邮箱不存在';
            return response()->json($ret);
        }
        $token = Tool::genRandomChar(64);
        $pass = new Password();
        $pass->email = $email;
        $pass->init_time = time();
        $pass->expire_time = time() + 2 * 3600;
        $pass->token = $token;
        if (!$pass->save()) {
            $ret['code'] = 0;
            $ret['status'] = false;
            $ret['msg'] = "保存token失败";
            return response()->json($ret);
        }

        $host = $_SERVER['HTTP_HOST'];
        $xieyi = ($_SERVER['HTTPS'] === 1 || $_SERVER['HTTPS'] === 'on' || $_SERVER['SERVER_PORT'] == 443) ? 'https' : 'http';
        $resetUrl = $xieyi . '://' . $host . "/password/token/" . $token;

        $subject = env('APP_NAME') . '密码重置';
        $content = '您的找回密码链接为：' . $resetUrl;

        $result = Mail::send($email, $subject, $content);
        $result = json_decode($result);
        if ($result->result == false) {
            $ret['code'] = 0;
            $ret['status'] = false;
            $ret['msg'] = "发送邮件失败";
            return response()->json($ret);
        }
        $ret['code'] = 1;
        $ret['status'] = true;
        $ret['msg'] = "发送邮件成功";
        return response()->json($ret);
    }

    public function tokenHandle(Request $request)
    {
        $token = $request->input('token', '');
        $password = $request->input('password', '');
        $password_confired = $request->input('password_confirmed', '');
        if ($password != $password_confired) {
            $ret['code'] = 0;
            $ret['status'] = false;
            $ret['msg'] = "两次输入不符合";
            return response()->json($ret);
        }
        if (strlen($password) < 8) {
            $ret['code'] = 0;
            $ret['status'] = false;
            $ret['msg'] = "密码太短啦";
            return response()->json($ret);
        }
        $token = Password::where('token', $token)->first();
        if ($token == null || $token->expire_time < time()) {
            $ret['code'] = 0;
            $ret['status'] = false;
            $ret['msg'] = '链接已经失效,请重新获取';
            return response()->json($ret);
        }

        $user = User::where('email', $token->email)->first();
        if ($user == null) {
            $ret['code'] = 0;
            $ret['status'] = false;
            $ret['msg'] = '链接已经失效,请重新获取';
            return response()->json($ret);
        }
        $hashPassword = Hash::passwordHash($password);
        $user->password = $hashPassword;
        if (!$user->save()) {
            $ret['code'] = 0;
            $ret['status'] = false;
            $ret['msg'] = '重置失败,请重试';
            return response()->json($ret);
        }
        $ret['code'] = 1;
        $ret['status'] = true;
        $ret['msg'] = '重置成功';
        return response()->json($ret);;
    }

}
