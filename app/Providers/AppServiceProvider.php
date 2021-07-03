<?php

namespace App\Providers;

use App\Services\SessionService;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;
use Config;
use Log;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
//        $this->app()
        $this->app->bind('SessionService', function()
        {
            return new SessionService();
//    return "hi";
        });
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        \Illuminate\Support\Facades\View::share('appFileVersion', scriptVersion());

        $apiENV = config::get('apikeys.APP_ENV');

//        Log::info("apiENV $apiENV");

        If ($apiENV !== 'local') {
//            Log::info("in");
//            URL::forceScheme('https');
//            $this->app['request']->server->set('HTTPS', true);
        }

        view()->composer('*', function ($view) {
            $stripeKey = config::get('apikeys.STRIPE_KEY');
            $appEnvIs = config::get('apikeys.APP_ENV');

//            $view->with('your_var', \Session::get('var') );
//            echo "hi";
//            exit;
            $sessionService = new SessionService();
            $userSession = $sessionService->getAuthUserSession();

            $userCredits = !empty($userSession['credits']) ? $userSession['credits'] : 0;

            $view->with('userCredits', $userCredits);
            $view->with('stripeKey', $stripeKey);
            $view->with('appEnvIs', $appEnvIs);
//            print_r($ettt);
//            exit;

        });

        Schema::defaultStringLength(191);
    }
}
