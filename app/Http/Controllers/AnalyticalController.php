<?php

namespace App\Http\Controllers;

use App\Jobs\GetSmsStatus;
use App\Models\SmsStatusSend;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;

class AnalyticalController extends Controller
{
    public function index()
    {


        RateLimiter::attempt('get_status_sms', 1, function () {
            dispatch(new GetSmsStatus(now(), Auth::user()->id));
            return null;
        }, 25);

        $maililngs = SmsStatusSend::query()->where('user_id', Auth::user()->id)->get();

        if ($maililngs->isNotEmpty()){

            foreach ($maililngs->groupBy('mailing_id')  as $key => $mailing){

                $sms_status_code = $mailing->groupBy('sms_status_code')->toArray();

                if (array_key_exists(1, $sms_status_code)) {

                    $report [$key] = ['all' => $mailing->count(), 'yes' => count($sms_status_code[1])];

                } else {
                    $report [$key] = ['all' => $mailing->count(), 'yes' => 0];
                }
            }
        } else{
            return view('analytical.index', ['mailing' => []]);
        }

        return view('analytical.index', ['mailing' => $report]);
    }

}
