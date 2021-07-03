<?php

namespace App\Http\Middleware;

use App\Services\SessionService;
use Closure;
use Illuminate\Support\Facades\Redirect;
use Config;
use Log;

class HttpsProtocol
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
        $apiENV = config::get('apikeys.APP_ENV');

        if (!$request->secure() && $apiENV !== 'local') {
            return redirect()->secure($request->getRequestUri());
        }

        return $next($request);
    }
}
