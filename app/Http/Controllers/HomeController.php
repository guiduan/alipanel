<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Tools\Captcha;

class HomeController extends Controller {
    public function index()
    {
        return view('home.index');
    }

    public function captcha(Request $request)
    {
        $captcha = new Captcha();
        $captcha->width = 120;
        $captcha->height = 46;
        $request->session()->put('captcha', $captcha->getCode());
        return $captcha->doimg();
    }

}
