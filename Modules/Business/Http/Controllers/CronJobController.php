<?php

namespace Modules\Business\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Mail;
use Modules\Business\Entities\CronJobEntity;
use Exception;
use Log;
use Symfony\Component\HttpKernel\Exception\HttpException;

class CronJobController extends Controller
{
    protected $cronjobEntity;

    public function  __construct()
    {
        $this->cronjobEntity = new CronJobEntity();
    }

    public function getNewReviewsNotification(Request $request)
    {
        return $this->cronjobEntity->getNewReviewsNotification($request);
    }
}
