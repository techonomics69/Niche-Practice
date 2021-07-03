<?php

namespace Modules\Admin\Http\Controllers;

use App\Services\SessionService;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\Admin\Entities\AdminEntity;
use Log;
use Redirect;

class AdminController extends Controller
{
    protected $data = [];

    protected $userEntity;

    protected $sessionService;

    public function __construct()
    {
        $this->userEntity = new AdminEntity();
        $this->sessionService = new SessionService();
    }

    public function showLoginView()
    {
        $this->data['showHeader'] = 'hide';

        $this->data['title'] = 'login'; // set the page title

        return view('admin.auth.login', $this->data);
    }

    /**
     * Show the application's login form.
     *
     * @return \Illuminate\Http\Response
     */
    public function login(Request $request)
    {
        try {
            $result = $this->userEntity->login($request);

            $responseMessage = $result['_metadata']['message'];

            // success response code
            if ($result['_metadata']['outcomeCode'] == 200) {
                $userModified = $result['records'];
//                print_r($userModified);
//                exit;

                $this->sessionService->setAdminUserSession($userModified);
                return Redirect::route('adminDashboard');
            }
            else {
                // user not authenticate.
                $errors = [];
                foreach ($result['errors'] as $error) {
                    $errors[$error['map']] = $error['message'];
                }
                return Redirect::route('post-login')->withInput()->withErrors($errors)->with('message', $responseMessage);
            }
        }
        catch(Exception $e)
        {
            Log::info($e->getMessage());
            return Redirect::route('post-login')->with('message', 'An unknown error has occurred. Please try again. please try again or contact webmaster.');
        }
    }

    public function logOut(Request $request)
    {
//        $request->session()->flush();
        $request->session()->forget(['admin_data']);

//        $this->sessionService->setAdminUserSession(['admin_data' => '']);

        return Redirect('admin/login')
            ->with('messageCode', 200)
            ->with('message', 'Successfully logged out.');
    }
}
