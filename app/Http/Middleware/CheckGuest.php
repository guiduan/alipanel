<?php namespace App\Http\Middleware;

use Closure;

class CheckGuest {

	/**
	 * Handle an incoming request.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  \Closure  $next
	 * @return mixed
	 */
	public function handle($request, Closure $next)
	{
        if ($request->session()->has('user')) {
            return redirect('/user');
        }
        if ($request->session()->has('admin')) {
            return redirect('/admin');
        }
        return $next($request);
	}

}
