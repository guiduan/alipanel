<?php namespace App\Http\Controllers;

use Ecs\Request\V20140526 as Ecs;
use Illuminate\Support\Facades\Response;

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
        $iClientProfile = \DefaultProfile::getProfile(env('ALI_REGION_ID'), env('ALI_ID'), env('ALI_SECRET'));

        $client = new \DefaultAcsClient($iClientProfile);

        $request = new Ecs\RenewInstanceRequest();
        $request->setMethod("GET");
        $request->setInstanceId("i-t4n6nhmb5r19qqreorla");
        $request->setPeriod('a');

        $response = $client->getAcsResponse($request);

        if ($response == 'false') {
            $ret['code'] = 0;
            $ret['msg'] = 'fail';
            return response()->json($ret);
        }
        //var_dump($response);
        //echo $response->ImageId;
        return response()->json($response);


    }

}
