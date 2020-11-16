<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Session;

class CustomerAuthenticate
{
	public function handle($request, Closure $next)
	{

		$userId = Session::get('user_id');
		
		if (!isset($userId)) {
			return redirect('user/login');
		}

		return $next($request);
	}
}