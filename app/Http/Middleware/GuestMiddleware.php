<?php

namespace App\Http\Middleware;

use App\Services\SessionService;
use App\traits\ApiServer;
use Closure;
use Log;
use Redirect;

class GuestMiddleware
{

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $sessionService = new SessionService();
        $data = $sessionService->getAuthUserSession();

        if (!empty($data)) {
            return redirect()->route('home');
        }

        return $next($request);
    }
}
