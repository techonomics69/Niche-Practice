<?php

namespace App\Http\Middleware;

use App\Services\SessionService;
use Closure;
use Redirect;

class UserAuthMiddleware
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
        $sessionService = new SessionService();
        $data = $sessionService->getAuthUserSession();

        if( !empty($data) )
        {
            return $next($request);
        }

        return Redirect::route('login');
    }
}
