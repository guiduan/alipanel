<?php
namespace App\Http\Controllers;

use Ecs\Request\V20140526 as Ecs;
use Illuminate\Support\Facades\Response;
use Illuminate\Http\Request;


class WelcomeController extends Controller
{

    public function index(Request $request)
    {
        return redirect('/auth/login');
    }

}
