<?php namespace App\Http\Middleware;

use Closure;
use Toast;

class CheckLogin {

	/**
	 * Handle an incoming request.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  \Closure  $next
	 * @return mixed
	 */
	public function handle($request, Closure $next)
	{
		if (!session()->has('_token')) {
			$message = \Config::get('messages.session_expired');
			Toast::message($message, 'danger');
            return redirect('home');
        }

		return $next($request);
	}

}
