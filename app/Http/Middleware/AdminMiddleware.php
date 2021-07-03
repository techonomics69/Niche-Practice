<?php

namespace App\Http\Middleware;

use App\Services\SessionService;
use Closure;
use Illuminate\Support\Facades\Redirect;

class AdminMiddleware
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
        $userData = $sessionService->getAdminUserSession();

//        print_r($userData);
//        exit;

        // confirm requested user is admin.
        if ( !empty($userData['user_role']) && $userData['user_role'][0]['slug'] == 'admin')
        {
//            dd($request->route()->getName());

            if($userData['user_role'][0]['id'] == 3)
            {
                $permissions = ['admin.promotions.list', 'admin.promotion-builder'];

                if(in_array($request->route()->getName(), $permissions) === true)
                {
                    return $next($request);
                }
                else
                {
                    return redirect()->route('admin.promotions.list');
                }
            }
            else if($userData['user_role'][0]['id'] == 4)
            {
                $permissions = ['admin.reports', 'admin.addReports', 'report.edit'];

                if(in_array($request->route()->getName(), $permissions) === true)
                {
                    return $next($request);
                }
                else
                {
                    return redirect()->route('admin.reports');
                }
            }
            else
            {
                return $next($request);
            }
        }

//        dd("e");

        return Redirect::route('admin-login');
    }

}
