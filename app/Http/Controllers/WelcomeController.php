<?php
namespace App\Http\Controllers;

use Ecs\Request\V20140526 as Ecs;
use Illuminate\Support\Facades\Response;
use App\Tools\Mail;


class WelcomeController extends Controller
{

    /*
    |--------------------------------------------------------------------------
    | Welcome Controller
    |--------------------------------------------------------------------------
    |
    | This controller renders the "marketing page" for the application and
    | is configured to only allow guests. Like most of the other sample
    | controllers, you are free to modify or remove it as you desire.
    |
    */

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Show the application welcome screen to the user.
     *
     * @return Response
     */
    public function index()
    {
        var_dump(Mail::send('254732500@qq.com', 'test', ''));

    }

}
