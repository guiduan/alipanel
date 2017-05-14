<?php namespace App\Http\Middleware;

use Closure;

class CheckUserLogin {

	/**
	 * Handle an incoming request.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  \Closure  $next
	 * @return mixed
	 */
	public function handle($request, Closure $next)
	{
        if (!$request->session()->has('user')) {
            if ($request->ajax()) {
                return response('Unauthorized!', 401);
            }else {
                $return_url = 'http://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
                return redirect('/auth/login?return_url=' . urlencode($return_url));
            }
        }
        return $next($request);
	}

}
