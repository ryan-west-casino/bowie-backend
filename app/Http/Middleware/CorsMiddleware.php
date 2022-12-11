<?php

/**
 * Location: /app/Http/Middleware
 */
namespace App\Http\Middleware;

use Closure;

class CorsMiddleware
{
	/**
	 * Handle an incoming request.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  \Closure  $next
	 * @return mixed
	 */
	public function handle($request, Closure $next)
	{
		$headers = [
			'Access-Control-Allow-Origin' => '*',
			'Access-Control-Allow-Methods' => 'POST,GET,PATCH,PUT,DELETE,OPTIONS',
			'Access-Control-Max-Age' => '86400',
                        'Access-Control-Allow-Headers' => 'Content-Type,API-KEY'
                ];

		if ($request->isMethod('OPTIONS')) {
			return response()->json('', 200, $headers);
		}

		$response = $next($request);

		foreach ($headers as $key => $value) {
			$response->header($key, $value);
		}

		return $response;
	}
}